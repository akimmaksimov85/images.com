<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<h1>Hello!</h1>
<h3>It's <?php echo Html::encode($user->username); ?> page!</h3>
<p>It's <?php echo HtmlPurifier::process($user->about); ?> page!</p>
<hr>

<?php if ($user->getId() !== $currentUser->getId()): ?>

<?php if ($currentUser->isFollowing($user)): ?>
<a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Unsubscribe</a>
<?php else: ?>
<a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Subscribe</a>
<?php endif; ?>

<hr>

<?php if ((!Yii::$app->user->isGuest) && ($mutualSubscriptions = $currentUser->getMutualSubscriptionsTo($user))): ?>

<h5>Friends, who are also following <?php echo Html::encode($user->username); ?>: </h5>
<div class="row">
    <?php foreach ($mutualSubscriptions as $item): ?>
        <div class="col-md-12">
            <a href="<?php
            echo Url::to(['/user/profile/view',
                'nickname' =>
                ($item['nickname']) ? $item['nickname'] : $item['id']]);
            ?>">
        <?php echo Html::encode($item['username']); ?>
            </a>
        </div>
<?php endforeach; ?>
</div>

<?php endif; ?>
<hr>

<?php endif; ?>

<!-- Button subscriptions -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
    Subscriptions: <?php echo Html::encode($user->countSubscriptions()); ?>
</button>

<!-- Modal subscriptions  -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
            </div>
            <div class="modal-body">
                        <?php foreach ($user->getSubscriptions() as $subscription): ?>
                    <div class="col-md-12">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?>">
                    <?php echo Html::encode($subscription['username']); ?>
                        </a>
                    </div>
<?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal subscriptions  -->


<!-- Button followers -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">
    Followers: <?php echo Html::encode($user->countFollowers()); ?>
</button>

<!-- Modal follower  -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
            </div>
            <div class="modal-body">
                        <?php foreach ($user->getFollowers() as $follower): ?>
                    <div class="col-md-12">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                    <?php echo Html::encode($follower['username']); ?>
                        </a>
                    </div>
<?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal follower  -->