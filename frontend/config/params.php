<?php

return [
    'adminEmail' => 'bastard9@mail.ru',
    'maxFileSize' => 1024 * 1024 * 2, // 2 megabites
    'storageUri' => '/uploads/', //http://images.com/uploads/f1/d7/4ferg4f3f3g34g3.jpg
    'postPicture' => [
        'maxWidth' => 1024,
        'maxHeight' => 768,
    ],
    'profilePicture' => [
        'maxWidth' => 100,
        'maxHeight' => 100,
    ],
    'feedPostLimit' => 200,
    'comment' => [
        'maxLevel' => 3,
        'pagination' => [
            'pageSize' => 5
        ],
    ],
];

