<?php

namespace frontend\models;

use Yii;
use frontend\models\Feed;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use frontend\models\events\PostDeletedEvent;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $filename
 * @property string $description
 * @property integer $created_at
 */
class Post extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::classname(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
        ];
    }

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
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    /**
     * Get author of the post
     * @return User|null
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Like current post by given user
     * @param \frontend\models\User $user
     */
    public function like(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * Unlike current post by given user
     * @param \frontend\models\User $user
     */
    public function unLike(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * get post id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    /**
     * Check whether given user liked current post
     * @param \frontend\models\User $user
     * @return integer
     */
    public function isLikedBy(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    public function complain(User $user)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";

        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }
    }
    
    protected function deleteComplaints($event)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$event->getPostId()}:complaints";
        
        return $redis->del($key);
    }
    
    protected function deleteLikes($event)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$event->getPostId()}:likes";
        
        return $redis->del($key);
    }

    
    public function deletePost()
    {
        $id = $this->getId();
        
        /* deleted first slash */
//        $filename = mb_substr(, 0);

        if ($this->delete()) {

            $event = new PostDeletedEvent();
            $event->postId = $id;
            $event->postFilename = $this->getImage();

            $this->on(self::EVENT_AFTER_DELETE, [Feed::className(), 'deletePosts']);
            $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteComplaints']);
            $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteLikes']);
            $this->on(self::EVENT_AFTER_DELETE, [Yii::$app->storage, 'deleteFile']);
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            return true;

            
        }
        return false;
    }


}
