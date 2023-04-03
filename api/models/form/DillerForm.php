<?php

namespace api\models\form;

use common\models\Stock;
use common\models\User;
use common\models\UserDetail;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class DillerForm extends Model
{

    public $legal_name;
    public $first_name;
    public $last_name;
    public $phone;
    public $password;
    public $address;
    public $id;
    public $password_confirm;


    public function rules()
    {
        return [
            [['legal_name', 'first_name', 'last_name', 'phone', 'password', 'password_confirm', 'address'], 'required'],
            [['legal_name', 'first_name', 'last_name', 'phone', 'password', 'password_confirm', 'address'], 'string', 'min' => 4],
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
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    public function save(){
        if (!$this->validate()){
            return false;
        }


        $transaction = \Yii::$app->db->beginTransaction();
        $userModel = new User();
        $userModel->username = $this->phone;
        $userModel->password = $this->password;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        $userModel->role = User::ROLE_DILLER;
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
        $userDetailModel->address = $this->address;
        $userDetailModel->legal_name = $this->legal_name;
        if (!$userDetailModel->save()){
            $transaction->rollBack();
            $this->addErrors($userDetailModel->getErrors());
            return false;
        }

        $stockModel = new Stock();
        $stockModel->name = $this->legal_name;
        $stockModel->user_id = $userModel->id;
        if (!$stockModel->save()){
            $transaction->rollBack();
            $this->addErrors($stockModel->getErrors());
            return false;
        }


        $transaction->commit();
        return $userModel;
    }

    public function update(){
        if (!$this->validate()){
            return false;
        }

        $user = User::findOne(['id' => $this->id]);
        if ($user->role != User::ROLE_DILLER){
            throw new NotFoundHttpException('User not found!');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $userModel = User::findOne(['id' => $this->id]);
        $userModel->username = $this->phone;
        $userModel->password = $this->password;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        $userModel->role = User::ROLE_DILLER;
        $userModel->status = User::STATUS_ACTIVE;
        $userModel->auth_key = \Yii::$app->security->generateRandomString();
        if (!$userModel->save()){
            $transaction->rollBack();
            $this->addErrors($userModel->getErrors());
            return false;
        }

        $userDetailModel = UserDetail::findOne(['user_id' => $this->id]);
        $userDetailModel->first_name = $this->first_name;
        $userDetailModel->last_name = $this->last_name;
        $userDetailModel->address = $this->address;
        $userDetailModel->legal_name = $this->legal_name;
        if (!$userDetailModel->save()){
            $transaction->rollBack();
            $this->addErrors($userDetailModel->getErrors());
            return false;
        }


        $transaction->commit();
        return $userModel;
    }

}