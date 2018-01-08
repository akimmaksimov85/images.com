<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;
use Intervention\Image\ImageManager;

class PictureForm extends Model
{
    
    

    public $picture;
    public $user;
    
    public function __construct()
    {
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

    public function save()
    {
        return 1;
    }
    
    public function resizePicture()
    {
        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];
        
        $manager = new ImageManager(array('driver' => 'imagick'));
        
        $image = $manager->make($this->picture->tempName);
        
        $image->resize($width, $height, function ($constant) {
            $constant->aspectRatio();
            $constant->upsize();
        })->save();
    }

}
