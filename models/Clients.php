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
        else {
            echo '<pre>';
            print_r($model->errors);
            exit;
            throw new \yii\web\HttpException(500, 'Регистрация не завершена из-за ошибки сервера.');
        } 
    }
}
