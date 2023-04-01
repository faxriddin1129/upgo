<?php

namespace common\models;

use Yii;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "{{%permission_user}}".
 *
 * @property int $id
 * @property int|null $permission_id
 * @property int|null $user_id
 * @property string|null $position
 * @property int|null $permission
 *
 * @property Permission $permission0
 * @property User $user
 */
class PermissionUser extends \yii\db\ActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permission_id', 'user_id', 'permission', 'position'], 'required'],
            [['permission'], 'in', 'range' => [self::ACTIVE, self::INACTIVE]],
            [['permission_id', 'user_id', 'permission'], 'integer'],
            [['position'], 'string', 'max' => 255],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::class, 'targetAttribute' => ['permission_id' => 'id']],
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
            'permission_id' => Yii::t('app', 'Permission ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'position' => Yii::t('app', 'Position'),
            'permission' => Yii::t('app', 'Permission'),
        ];
    }

    /**
     * Gets query for [[Permission0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermission0()
    {
        return $this->hasOne(Permission::class, ['id' => 'permission_id']);
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

    public function csave(){
        if (!$this->validate()){
            return false;
        }

        if (!$this->id){
            $checkPermission = PermissionUser::findOne(['user_id' => $this->user_id, 'permission_id' => $this->permission_id]);
            if ($checkPermission){
                throw new BadRequestHttpException('Permission dublicat!');
            }
        }

        if (!$this->save()){
            return false;
        }

        return true;
    }

    public function fields()
    {
        return [
            'id',
            'permission_id',
            'permission_name' => function($model){
                return $model->permission0->name;
            },
            'user_id',
            'position',
            'permission',
        ];
    }


}
