<?php

namespace api\models\form;

use common\models\User;
use common\models\UserDetail;

class SettingsForm extends \yii\base\Model
{

    public $legal_name;
    public $first_name;
    public $last_name;
    public $address;
    public $phone;
    public $password;

    public function rules()
    {
        return [
//            [['legal_name', 'first_name', 'last_name', 'address', 'phone', 'password'], 'required'],
            [['legal_name', 'first_name', 'last_name', 'address', 'phone', 'password'], 'string'],
        ];
    }

    public function save()
    {
        if (!$this->validate()){
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        $userModel = User::findOne(['id' => \Yii::$app->user->id]);
        $userModel->username = $this->phone;
        $userModel->password = $this->password;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        if (!$userModel->save()){
            $transaction->rollBack();
            $this->addErrors($userModel->errors);
            return false;
        }

        $detailModel = UserDetail::findOne(['user_id' => $userModel->id]);
        if (!$detailModel){
            $detailModel = new UserDetail();
            $detailModel->user_id = \Yii::$app->user->id;
        }
        $detailModel->legal_name = $this->legal_name;
        $detailModel->first_name = $this->first_name;
        $detailModel->last_name = $this->last_name;
        $detailModel->address = $this->address;
        if (!$detailModel->save()){
            $transaction->rollBack();
            $this->addErrors($detailModel->errors);
            return false;
        }

        $transaction->commit();
        return $userModel;
    }

}