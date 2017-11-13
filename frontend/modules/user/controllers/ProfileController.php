<?php

namespace frontend\modules\user\controllers;

use Yii;
use frontend\models\User;

class ProfileController extends \yii\web\Controller
{
    public function actionView($nickname)
    {
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        
        return $this->render('view', [
            'user' => $this->findUser($nickname),
            'currentUser' => $currentUser,
        ]);
    }
    
    /**
     * 
     * @param string $nickname
     * @return User
     * @throws \yii\web\NotFoundHttpException
     */
    private function findUser($nickname)
    {
        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()) {
            return $user;   
        }
        throw new \yii\web\NotFoundHttpException;
    }
    
    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);//если гость, перенаправить на login
        }
        
        /**
         * @var $currentUser User
         */
        $currentUser = Yii::$app->user->identity; //юзер, который хочет подписаться
        
        $user = $this->findUserById($id);//юзер, на которого хотят подписаться

        $currentUser->followUser($user);
        
        return $this->redirect(['/user/profile/view', 'nickname' =>$user->getNickname()]);
    }
    
    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);//если гость, перенаправить на login
        }
        
        /**
         * @var $currentUser User
         */
        $currentUser = Yii::$app->user->identity; //юзер, который хочет отписаться
        
        $user = $this->findUserById($id);//юзер, от которого хотят отписаться

        $currentUser->unfollowUser($user);
        
        return $this->redirect(['/user/profile/view', 'nickname' =>$user->getNickname()]);
    }
    
    private function findUserById($id)
    {
        if ($user = User::findOne($id)) {
            return $user;
        }
        throw new \yii\web\NotFoundHttpException();
    }
//    public function actionGenerate()
//    {
//        $faker = \Faker\Factory::create();
//        
//        for ($i = 0; $i <1000; $i++) {
//            $user = new User([
//               'username' => $faker->name,
//                'email' => $faker->email,
//                'about' => $faker->text(200),
//                'nickname' => $faker->regexify('[A-Za-z0-9_]{5,15}'),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//            $user->save(false);
//        }
//    }
}
