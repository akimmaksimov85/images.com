<?php

namespace backend\modules\user\controllers\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

/**
 * Description of UserAccessBehavior
 *
 * @author basta
 */
class UserAccessBehavior extends Behavior
{

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'checkAccess',
        ];
    }

    public function checkAccess()
    {
        
        if (!Yii::$app->user->can('viewUsersList')) {
            return Yii::$app->controller->redirect(['site/index']);
        }
    }

}
