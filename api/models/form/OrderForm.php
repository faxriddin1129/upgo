<?php

namespace api\models\form;

use common\models\Client;
use common\models\PaymentType;
use yii\base\Model;

class OrderForm extends Model
{

    public $payment_type_id;
    public $delivery_time;
    public $client_id;

    public function rules()
    {
        return [
            [['payment_type_id', 'delivery_time', 'client_id'], 'integer'],
            [['total_price'], 'number'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::class, 'targetAttribute' => ['payment_type_id' => 'id']],
        ];
    }

    public function save(){
        if (!$this->validate()){
            return false;
        }

        

        return false;
    }

}