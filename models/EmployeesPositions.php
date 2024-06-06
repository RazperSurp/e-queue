<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees_positions".
 *
 * @property int $id
 * @property int $time_start
 * @property int $time_end
 * @property int $position
 * @property int $employees_id
 *
 * @property Clients[] $clients
 * @property Employees $employees
 */
class EmployeesPositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees_positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_start', 'time_end', 'position', 'employees_id'], 'required'],
            [['time_start', 'time_end', 'position', 'employees_id'], 'default', 'value' => null],
            [['time_start', 'time_end', 'position', 'employees_id'], 'integer'],
            [['employees_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::class, 'targetAttribute' => ['employees_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'position' => 'Position',
            'employees_id' => 'Employees ID',
        ];
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::class, ['employees_positions_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employees::class, ['id' => 'employees_id']);
    }

    public static function getFreePosition($epoch) {
        $currentPositions = self::find()
            ->select(['employees_positions.id', 'count(clients.id)'])
            ->innerJoinWith(['employees'])
            ->joinWith(['clients'])
            ->where(['<', 'time_start', $epoch])
            ->andWhere(['>', 'time_end', $epoch])
            ->groupBy('employees_positions.id')
            ->asArray()
            ->all();

        $min = $currentPositions[0]['count'];
        $result = $currentPositions[0]['id'];

        foreach ($currentPositions as $currentPosition) {
            if ($currentPosition['count'] <= $min) {
                $result = $currentPosition['id'];
                $min = $currentPosition['count'];
            }
        }

        return $result;
    }
}
