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
                'user/sign-in',
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

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/user',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS get-me' => 'options',
                'PUT get-me' => 'get-me',

                'OPTIONS settings' => 'options',
                'POST settings' => 'settings',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/measure',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
                'GET <id:\d+>' => 'view',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/permission',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/category',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
                'GET <id:\d+>' => 'view',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/payment-type',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
                'GET <id:\d+>' => 'view',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/diller',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'GET' => 'index',
                'POST' => 'create',

                'OPTIONS <id:\d+>' => 'options',
                'GET <id:\d+>' => 'view',
                'POST <id:\d+>' => 'status',
                'PUT <id:\d+>' => 'update',

            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/region',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/file',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'upload',
            ],
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/client',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'PUT <id:\d+>' => 'update',
                'GET <id:\d+>' => 'view',

                'OPTIONS <id:\d+>/<text:>' => 'options',
                'DELETE <id:\d+>/<text:>' => 'delete',

                'OPTIONS deleted' => 'options',
                'GET deleted' => 'deleted',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/statistics',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'GET' => 'index',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/employee',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'GET <id:\d+>' => 'view',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',

                'OPTIONS <id:\d+>/statistics' => 'options',
                'GET <id:\d+>/statistics' => 'statistics',

                'OPTIONS <id:\d+>/salary' => 'options',
                'GET <id:\d+>/salary' => 'salary',

                'OPTIONS <id:\d+>/work-days' => 'options',
                'GET <id:\d+>/work-days' => 'work-days',

                'OPTIONS <id:\d+>/work-days-all' => 'options',
                'GET <id:\d+>/work-days-all' => 'work-days-all',

                'OPTIONS <id:\d+>/work-create' => 'options',
                'GET <id:\d+>/work-create' => 'work-create',

                'OPTIONS <id:\d+>/work-delete' => 'options',
                'GET <id:\d+>/work-delete' => 'work-delete',

                'OPTIONS orders' => 'options',
                'GET orders' => 'orders',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/product',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'GET <id:\d+>' => 'view',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/stock',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS /delete' => 'options',
                'POST /delete' => 'delete',
            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/order',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'POST' => 'create',
                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',
                'GET <id:\d+>' => 'view',
                'DELETE <id:\d+>' => 'delete',
                'PUT <id:\d+>' => 'update',

                'OPTIONS <id:\d+>/pending' => 'options',
                'GET <id:\d+>/pending' => 'pending',

                'OPTIONS <id:\d+>/finish' => 'options',
                'GET <id:\d+>/finish' => 'finish',
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
