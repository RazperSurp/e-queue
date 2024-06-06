<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property int $users_id
 * @property int $strg_posts_id
 *
 * @property EmployeesPositions[] $employeesPositions
 * @property StrgPosts $strgPosts
 * @property Users $users
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'strg_posts_id'], 'required'],
            [['users_id', 'strg_posts_id'], 'default', 'value' => null],
            [['users_id', 'strg_posts_id'], 'integer'],
            [['strg_posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => StrgPosts::class, 'targetAttribute' => ['strg_posts_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Users ID',
            'strg_posts_id' => 'Strg Posts ID',
        ];
    }

    /**
     * Gets query for [[EmployeesPositions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesPositions()
    {
        return $this->hasMany(EmployeesPositions::class, ['employees_id' => 'id']);
    }

    /**
     * Gets query for [[StrgPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStrgPosts()
    {
        return $this->hasOne(StrgPosts::class, ['id' => 'strg_posts_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }
}
