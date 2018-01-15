<?php
/* @var $this yii\web\view */
/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="container full">
    <div class="page-posts no-padding">
        <div class="row">
            <div class="page page-post col-sm-12 col-xs-12 post-82">
                <div class="blog-posts blog-posts-large">
                    <div class="row">

                        <h1>Create post</h1>

                        <?php $form = ActiveForm::begin(); ?>

                        <?php echo $form->field($model, 'picture')->fileInput(); ?>

                        <?php echo $form->field($model, 'description'); ?>

                        <?php echo Html::submitButton('Create'); ?>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
