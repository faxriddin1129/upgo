<?php

namespace api\models\form;

use common\models\File;
use common\models\PermissionUser;
use common\models\User;
use common\models\UserDetail;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class EmployeeForm extends Model
{

    public $first_name;
    public $last_name;
    public $phone;
    public $salary_int;
    public $salary_percent;
    public $password;
    public $id;
    public $password_confirm;
    public $permissions;
    public $file_id;


    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'password', 'password_confirm', 'salary_int', 'salary_percent', 'permissions', 'file_id'], 'required'],
            [['first_name', 'last_name', 'phone', 'password', 'password_confirm'], 'string', 'min' => 4],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            ['phone', function ($attribute, $params, $validator) {
                $check = User::findOne(['id' => $this->id]);
                if ($check){
                    if ($check->username != $this->phone and User::findOne(['username' => $this->phone])) {
                        $this->addError($attribute, 'This phone has already been taken.');
                    }
                }else{
                    if (User::findOne(['username' => $this->phone])) {
                        $this->addError($attribute, 'This phone has already been taken.');
                    }
                }
            }],
            [['phone'], 'string', 'max'=>13, 'min'=>'12'],
            [['salary_int', 'salary_percent'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    public function save(){
        if (!$this->validate()){
            return false;
        }

        if (!is_array($this->permissions)){
            throw new BadRequestHttpException('');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $userModel = new User();
        $userModel->username = $this->phone;
        $userModel->password = $this->password;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        $userModel->role = User::ROLE_SUP_DILLER;
        if (\Yii::$app->user->identity['role'] == User::ROLE_ADMIN){
            $userModel->parent_id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $userModel->parent_id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $userModel->parent_id = \Yii::$app->user->identity['parent_id'];
        }
        $userModel->status = User::STATUS_ACTIVE;
        $userModel->auth_key = \Yii::$app->security->generateRandomString();
        if (!$userModel->save()){
            $transaction->rollBack();
            $this->addErrors($userModel->getErrors());
            return false;
        }

        $userDetailModel = new UserDetail();
        $userDetailModel->user_id = $userModel->id;
        $userDetailModel->first_name = $this->first_name;
        $userDetailModel->last_name = $this->last_name;
        $userDetailModel->file_id = $this->file_id;
        $userDetailModel->salary_int = $this->salary_int;
        $userDetailModel->salary_percent = $this->salary_percent;
        if (!$userDetailModel->save()){
            $transaction->rollBack();
            $this->addErrors($userDetailModel->getErrors());
            return false;
        }

        foreach ($this->permissions as $permission){
            $permissionModel = new PermissionUser();
            $permissionModel->setAttributes($permission);
            $permissionModel->user_id = $userModel->id;
            if (!$permissionModel->csave()){
                $transaction->rollBack();
                $this->addErrors($permissionModel->getErrors());
                return false;
            }
        }

        $transaction->commit();
        return $this;
    }

    public function update(){
        if (!$this->validate()){
            return false;
        }

        if (!is_array($this->permissions)){
            throw new BadRequestHttpException('');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $userModel = User::findOne(['id' => $this->id]);
        $userModel->username = $this->phone;
        $userModel->password = $this->password;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        $userModel->role = User::ROLE_SUP_DILLER;
        if (\Yii::$app->user->identity['role'] == User::ROLE_ADMIN){
            $userModel->parent_id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $userModel->parent_id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $userModel->parent_id = \Yii::$app->user->identity['parent_id'];
        }
        if (!$userModel->save()){
            $transaction->rollBack();
            $this->addErrors($userModel->getErrors());
            return false;
        }

        $userDetailModel = UserDetail::findOne(['user_id' => $this->id]);
        $userDetailModel->first_name = $this->first_name;
        $userDetailModel->last_name = $this->last_name;
        $userDetailModel->file_id = $this->file_id;
        $userDetailModel->salary_int = $this->salary_int;
        $userDetailModel->salary_percent = $this->salary_percent;
        if (!$userDetailModel->save()){
            $transaction->rollBack();
            $this->addErrors($userDetailModel->getErrors());
            return false;
        }

        foreach ($this->permissions as $permission){
            $permissionModel = new PermissionUser();
            if (array_key_exists('id',$permission)){
                $permissionModel = PermissionUser::findOne(['id' => $permission['id']]);
            }
            $permissionModel->setAttributes($permission);
            $permissionModel->user_id = $userModel->id;
            if (!$permissionModel->csave()){
                $transaction->rollBack();
                $this->addErrors($permissionModel->getErrors());
                return false;
            }
        }

        $transaction->commit();
        return $this;
    }


}