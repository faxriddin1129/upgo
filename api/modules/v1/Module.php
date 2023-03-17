<?php

namespace api\modules\v1;

use common\components\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;


/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\v1\controllers';


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => [
                'user/sign-up',
                'user/confirm',
                'user/send-sms',
                '*/options',
            ],
            'optional' => [
                'default/*'
            ],
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Expose-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Methods' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Allow-Headers' => ['Authorization', 'X-Requested-With', 'Content-Type'],
            ],
        ];


        return $behaviors;
    }

    /**
     * @var array
     */
    public static $urlRules = [

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1',
            'pluralize' => false,
            'patterns' => [
                'GET' => 'default/index',

                'GET clear-cache' => 'default/clear-cache',
            ]
        ],

    ];

    /**
     * @return array
     */
    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }
}
