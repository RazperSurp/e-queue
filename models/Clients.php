<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property int $employees_positions_id
 * @property string $firstname
 * @property string $secondname
 * @property string|null $thirdname
 * @property string $phone
 * @property int $queue
 * @property string $date
 * @property bool|null $closed
 *
 * @property EmployeesPositions $employeesPositions
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'secondname', 'phone'], 'required'],
            [['employees_positions_id'], 'default', 'value' => null],
            [['employees_positions_id', 'time'], 'integer'],
            [['closed'], 'boolean'],
            [['firstname', 'secondname', 'thirdname', 'phone'], 'string', 'max' => 255],
            [['employees_positions_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeesPositions::class, 'targetAttribute' => ['employees_positions_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'employees_positions_id' => 'Сотрудник',
            'firstname' => 'Имя',
            'secondname' => 'Фамилия',
            'thirdname' => 'Отчество',
            'phone' => 'Номер телефона',
            'time' => 'Время регистрации',
            'closed' => 'Закрыто',
        ];
    }

    /**
     * Gets query for [[EmployeesPositions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesPositions()
    {
        return $this->hasOne(EmployeesPositions::class, ['id' => 'employees_positions_id']);
    }

    public static function addNew($post) {
        $time = time();
        $model = new Clients();

        $model->load($post);
        $model->time = $time;

        if ($model->save()) return ['id' => $model->id, 'time' => $model->time];
        else throw new \yii\web\HttpException(500, 'Регистрация не завершена из-за ошибки сервера.');
    }

    public static function checkQueue($token) {
        list($id, $time) = explode('_', $token);
        $model = self::findOne(['id' => $id, 'time' => $time]);
        if ($model && isset($model->employees_positions_id)) {
            return [
                'employee' => $model->employeesPositions->employees->strgPosts->name . ' '. $model->employeesPositions->employees->users->fullName(),
                'position' => $model->employeesPositions->position_id
            ];
        }
        else if ($model && !isset($model->employees_positions_id)) throw new \yii\web\HttpException(204);
        else {
            throw new \yii\web\HttpException(401, 'Неверный регистрационный токен');
        }
    }
}
