<?php

namespace common\components;

use Yii;
use yii\base\Component;
/**
 * Description of DeleteLikesAndComplaints
 *
 * @author basta
 */
class DeleteLikesAndComplaints extends Component
{
     
    public function deleteComplaints($event)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$event->getPostId()}:complaints";
        
        return $redis->del($key);
    }
    
    public function deleteLikes($event)
    {
        /* @var redis connection */
        $redis = Yii::$app->redis;
        $key = "post:{$event->getPostId()}:likes";
        
        return $redis->del($key);
    }

}
