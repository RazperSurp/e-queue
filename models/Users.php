<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $firstname
 * @property string $secondname
 * @property string|null $thirdname
 *
 * @property Employees[] $employees
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstname', 'secondname'], 'required'],
            [['password'], 'string'],
            [['username', 'firstname', 'secondname', 'thirdname'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'firstname' => 'Firstname',
            'secondname' => 'Secondname',
            'thirdname' => 'Thirdname',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['users_id' => 'id']);
    }

    public function getFullName($shortMode = false) {
        return $this->secondname 
            .' '. ($shortMode ? (
                mb_substr($this->firstname, 0, 1) . '.'
            ) : $this->firstname)
            .' '. ($shortMode ? (
                mb_substr($this->thirdname, 0, 1) . '.'
            ) : $this->thirdname);
    }
}
