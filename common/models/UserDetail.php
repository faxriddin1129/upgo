<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_detail}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $address
 * @property int|null $file_id
 * @property float|null $salary_int
 * @property float|null $salary_percent
 *
 * @property File $file
 * @property User $user
 */
class UserDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file_id'], 'integer'],
            [['salary_int', 'salary_percent'], 'number'],
            [['first_name', 'last_name', 'middle_name', 'address'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'address' => Yii::t('app', 'Address'),
            'file_id' => Yii::t('app', 'File ID'),
            'salary_int' => Yii::t('app', 'Salary Int'),
            'salary_percent' => Yii::t('app', 'Salary Percent'),
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
