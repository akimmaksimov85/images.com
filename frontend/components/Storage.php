<?php

namespace frontend\components;

use Yii;
use frontend\components\StorageInterface;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * Description of Storage
 *
 * @author basta
 */
class Storage extends Component implements StorageInterface
{
    private $fileName;
    
    /**
     * Save given UploadedFIle instance to disk
     * @param UploadedFile
     * @return string|NULL
     */
    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);
        
        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        }
    }
    
    /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string|NULL
     */
    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);
        // c9/q2/4h4j6j44h5j3h5...k3j5l.jpg
        
        $path = $this->getStoragePath() . $this->fileName;
        // /var/www/project/frontend/web/uploads/c9/q2/4h4j6j44h5j3h5...k3j5l.jpg
        
        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
        
    }
    
    protected function getFileName(UploadedFile $file)
    {
        // $file->tempname - /tmp/qio93kf
        
        $hash = sha1_file($file->tempName); // 4uf94j49y4i3o20094h39g004i2i8f0230i1s
        
        $name = substr_replace($hash, '/', 2, 0); // 4u/f94j49y4i3o20094h39g004i2i8f0230i1s
        $name = substr_replace($name, '/', 5, 0); // 4u/f9/4j49y4i3o20094h39g004i2i8f0230i1s
        return $name . '.' . $file->extension; // 4u/f9/4j49y4i3o20094h39g004i2i8f0230i1s.jpg
    }
    
    /*
     * @return string
     */
    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }
    
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'].$filename;
    }
}
