<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%permission}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $action_id
 *
 * @property PermissionUser[] $permissionUsers
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
            [['name', 'action_id'], 'required'],
            [['name'], 'string'],
            [['action_id'], 'string', 'max' => 255],
            ['action_id', 'unique', 'targetClass' => '\common\models\Permission', 'message' => 'This action_id has already been taken.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'action_id' => Yii::t('app', 'Action ID'),
        ];
    }

    /**
     * Gets query for [[PermissionUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermissionUsers()
    {
        return $this->hasMany(PermissionUser::class, ['permission_id' => 'id']);
    }
}
