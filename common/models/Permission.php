<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%permission}}".
 *
 * @property int $id
 * @property string|null $position
 * @property string|null $name
 * @property string|null $action_id
 * @property int|null $user_id
 * @property int|null $permission
 *
 * @property User $user
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['user_id', 'permission'], 'integer'],
            [['position', 'action_id'], 'string', 'max' => 255],
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
            'position' => Yii::t('app', 'Position'),
            'name' => Yii::t('app', 'Name'),
            'action_id' => Yii::t('app', 'Action ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'permission' => Yii::t('app', 'Permission'),
        ];
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
