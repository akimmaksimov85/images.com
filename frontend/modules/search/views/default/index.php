<?php
/* @var $this yii\web\view */
/* @var $model frontend\modules\post\models\forms\PostForm */
/* @var $currentUser User */
/* @var $friends frontend\modules\search\models\SearchUser */

use yii\helpers\Url;
use frontend\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\JqueryAsset;
?>

<div class="container full">
    <div class="page-posts no-padding">
        <div class="row">
            <div class="blog-posts blog-posts-large">
                <h3><?= Yii::t('search', 'Recommended friends'); ?>:</h3>
                <br>
                <article class="profile col-sm-12 col-xs-12">
                    <?php foreach ($friends as $friend): ?>
                        <div class="col-lg-3">
                            <?php $user = User::findOne(['id' => $friend['id']]); ?>
                            <div class="profile-title">
                                <?php if ($friend['picture']): ?>
                                    <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />
                                <?php endif; ?>
                                <div class="author-name">
                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $user->getNickname()]); ?>">
                                        <?php echo Html::encode($user->username); ?>
                                    </a>
                                </div>
                            </div>
                            <br>
                        </div>
                    <?php endforeach; ?>
                </article>

                <div class="row">

                    <h3><?= Yii::t('search', 'Find your friends'); ?>!</h3>

                    <?php $form = ActiveForm::begin(); ?>

                    <?php echo $form->field($model, 'keyword'); ?>

                    <?php echo Html::submitButton(Yii::t('search', 'Search'), ['class' => 'btn btn-search']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <article class="profile col-sm-12 col-xs-12">
                <div class="blog-posts blog-posts-large">
                    <div class="row">

                        <h1><?= Yii::t('search', 'Search results'); ?>:</h1>

                        <?php if ($results): ?>
                            <?php foreach ($results as $result): ?>
                                <?php $user = User::findOne(['id' => $result['id']]); ?>
                                <div class="profile-title">
                                    <?php if ($result['picture']): ?>
                                        <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />
                                    <?php endif; ?>
                                    <div class="author-name">
                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $user->getNickname()]); ?>">
                                            <?php echo Html::encode($user->username); ?>
                                        </a>
                                        <?php if ($currentUser && !$currentUser->equals($user)): ?>
                                            <a href="#" 
                                               class="btn btn-info button-unsubscribe 
                                               <?php echo ($currentUser->isFollowing($user)) ? "" : "display-none"; ?>" 
                                               data-id="<?php echo $user->getId(); ?>">Unsubscribe
                                            </a>
                                            <a href="#" 
                                               class="btn btn-info button-subscribe 
                                               <?php echo ($currentUser->isFollowing($user)) ? "display-none" : ""; ?>" 
                                               data-id="<?php echo $user->getId(); ?>">Subscribe
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <br>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/subscription.js', [
    'depends' => JqueryAsset::className(),
]);
