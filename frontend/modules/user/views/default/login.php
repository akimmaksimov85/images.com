<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode(Yii::t('login', $this->title)) ?></h1>

    <p><?= Yii::t('login', 'Please fill out the following fields to login'); ?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                <?= Yii::t('login', 'If you forgot your password you can'); ?> <?= Html::a(Yii::t('login', 'reset it').'.', ['/user/default/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5">
            <h3>Login with Facebook</h3>
            <?=
            yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['/user/default/auth'],
                'popupMode' => false,
            ])
            ?>
        </div>
    </div>
</div>
