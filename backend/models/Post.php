<?php

namespace backend\models;

use Yii;
use common\models\events\PostDeletedEvent;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $filename
 * @property string $description
 * @property integer $created_at
 * @property integer $complaints
 */
class Post extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
            'complaints' => 'Complaints',
        ];
    }

    public static function findComplaints()
    {
        return Post::find()->where('complaints > 0')->orderBy('complaints DESC');
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }
    
    /**
     * return path for file on server
     * @return string
     */
    public function getFilePath()
    {
        return Yii::getALias('@uploads').'/'.$this->filename;
    }

    /**
     * get post id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function approve()
    {
        /* @var $redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);

        $this->complaints = 0;
        return $this->save(false, ['complaints']);
    }

    public function deletePost()
    {
        $id = $this->getId();
//        echo var_dump(file_exists($this->getFilePath()));
//        die();
        if ($this->delete()) {

            $event = new PostDeletedEvent();
            $event->postId = $id;
            $event->postFilename = $this->getFilePath();

            $this->on(self::EVENT_AFTER_DELETE, [Yii::$app->deleteLikesAndComplaints, 'deleteComplaints']);
            $this->on(self::EVENT_AFTER_DELETE, [Yii::$app->deleteLikesAndComplaints, 'deleteLikes']);
            $this->on(self::EVENT_AFTER_DELETE, [Yii::$app->storage, 'deleteFile']);
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            return true;
        }
        return false;
    }

}
