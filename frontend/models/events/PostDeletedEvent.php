<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\models\Post;

class PostDeletedEvent extends Event
{

    /**
     * @var Post
     */
    public $postId;
    public $postFilename;

    public function getPostId(): int
    {
        return $this->postId;
    }
    
    public function getPostFilename(): string
    {
        return $this->postFilename;
    }

}
