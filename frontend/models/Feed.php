<?php

namespace frontend\models;

use Yii;
use frontend\models\User;
use yii2mod\comments\models\CommentModel;
use frontend\models\events\PostDeletedEvent;

/**
 * This is the model class for table "feed".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $author_id
 * @property string $author_name
 * @property integer $author_nickname
 * @property string $author_picture
 * @property integer $post_id
 * @property string $post_filename
 * @property string $post_description
 * @property integer $post_created_at
 */
class Feed extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
            'author_name' => 'Author Name',
            'author_nickname' => 'Author Nickname',
            'author_picture' => 'Author Picture',
            'post_id' => 'Post ID',
            'post_filename' => 'Post Filename',
            'post_description' => 'Post Description',
            'post_created_at' => 'Post Created At',
        ];
    }

    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->post_id}:likes");
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getAuthorPicture()
    {
        if (!isset($user)) {
            return User::DEFAULT_IMAGE;
        }
        $user = $this->hasOne(User::className(), ['id' => 'author_id'])->one();
        if ($user->picture) {
            return Yii::$app->storage->getFile($user->picture);
        }
        
        return $this->author_picture;
    }

    public function commentsCount()
    {
        return $this->hasMany(CommentModel::className(), ['entityId' => 'post_id'])
                        ->where(['entityId' => $this->getPostId()])
                        ->count();
    }

    public function isReported(User $user)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->post_id}:complaints", $user->getId());
    }

    public static function deletePosts($event)
    {
        $posts = Feed::find()->where('post_id = ' . $event->getPostId())->all();
        foreach ($posts as $post) {
            $post->delete();
        }
        
        /* @var redis connection */

    }

}
