<?php

namespace common\models\events;

use yii\base\Event;

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
