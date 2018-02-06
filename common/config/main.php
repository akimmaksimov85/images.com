<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
          'class' => 'yii\rbac\DbManager',  
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'storage' => [
            'class' => 'common\components\Storage',
        ],
        'deleteLikesAndComplaints' => [
            'class' => 'common\components\DeleteLikesAndComplaints',
        ],
    ],
];
