
<?php
/* @var $this yii\web\View */
/* @var $post frontend\models\Post */

use Yii;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use rmrevin\yii\module\Comments;
?>
<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user): ?>
                <?php echo $post->user->username; ?>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>" />
        </div>

        <div class="col-md-12">
            <?php echo Html::encode($post->description); ?>
        </div>

    </div>

    <hr>

    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>

    </div>

    <?php
    echo Comments\widgets\CommentListWidget::widget([
        'entity' => (string) 'photo-15', // type and id
    ]);
    ?>


</div>


<?php
/* frontend\modules\post\views\default\view */
/* @var $this yii\web\View */
/* @var $post frontend\models\Post */
/* @var $currentUser frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JqueryAsset;
?>

<div class="container full">

    <div class="page-posts no-padding">
        <div class="row">
            <div class="page page-post col-sm-12 col-xs-12 post-82">
                <div class="blog-posts blog-posts-large">
                    <div class="row">
                        <!-- feed item -->
                        <article class="post col-sm-12 col-xs-12">                                            
                            <div class="post-meta">
                                <div class="post-title">
                                    <?php if ($post->user): ?>
                                        <img src="<?php echo $post->user->getPicture(); ?>" class="author-image" />
                                        <div class="author-name"><a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $post->user->getNickname()]); ?>"><?php echo $post->user->username; ?></a></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="post-type-image">
                                <a href="<?php echo $post->getImage(); ?>">
                                    <img src="<?php echo $post->getImage(); ?>" alt="">
                                </a>
                            </div>
                            <div class="post-description">
                                <p><?php echo Html::encode($post->description); ?></p>
                            </div>
                            <div class="post-bottom">
                                <div class="post-likes">
                                    <i class="fa fa-lg fa-heart-o"></i>
                                    <span class="likes-count"><?php echo $post->countLikes(); ?></span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="#" class="btn btn-default button-unlike <?php echo ($currentUser->likesPost($post->getId())) ? "" : "display-none"; ?>" data-id="<?php echo $post->getId(); ?>">
                                        Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                    </a>
                                    <a href="#" class="btn btn-default button-like <?php echo ($currentUser->likesPost($post->getId())) ? "display-none" : ""; ?>" data-id="<?php echo $post->getId(); ?>">
                                        Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                    </a>
                                </div>
                                &nbsp;&nbsp;
                                <div class="post-date">
                                    <span><?php echo Yii::$app->formatter->asDatetime($post->created_at); ?></span>    
                                </div>
                                <br><br>
                            </div>
                        </article>
                        <!-- feed item -->

                        <!-- comments-post -->
                        <div class="col-sm-12 col-xs-12">
                            <div class="comment-respond">
                                <h4>Leave a Reply</h4>
                                <?php
                                echo \yii2mod\comments\widgets\Comment::widget([
                                    'model' => $post,
                                    'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
                                    'maxLevel' => \Yii::$app->params['comment']['maxLevel'],
                                    'dataProviderConfig' => [
                                        'pagination' => [
                                            'pageSize' => \Yii::$app->params['comment']['pagination']['pageSize'],
                                        ],
                                    ],
                                    'listViewConfig' => [
                                        'emptyText' => Yii::t('app', 'No comments found.'),
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
