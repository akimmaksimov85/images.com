<?php

namespace frontend\modules\user\controllers;

use Yii;
use frontend\models\User;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\web\Response;

class ProfileController extends \yii\web\Controller
{

    public function actionView($nickname)
    {
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $user = $this->findUser($nickname);
        $postItems = $user->getPost();
        $modelPicture = new PictureForm();

        return $this->render('view', [
                    'user' => $user,
                    'currentUser' => $currentUser,
                    'postItems' => $postItems,
                    'modelPicture' => $modelPicture,
        ]);
    }

    /**
     * Handle profile image upload via ajax request
     */
    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()) {

            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);

            if ($user->save(false, ['picture'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionEdit()
    {
        $currentUser = Yii::$app->user->identity;
        $post = Yii::$app->request->post();
        $currentUser->about = $post['User']['about'];
        $currentUser->save();

        return $this->redirect(['/user/profile/view', 'nickname' => $currentUser->getNickname()]);
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

    public function actionSubscribe()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']); //если гость, перенаправить на login
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity; //юзер, который хочет подписаться
        $user = $this->findUserById($id); //юзер, на которого хотят подписаться

        $currentUser->followUser($user);

        return [
            'success' => true,
        ];
    }

    public function actionUnsubscribe()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']); //если гость, перенаправить на login
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity; //юзер, который хочет отписаться
        $user = $this->findUserById($id); //юзер, от которого хотят отписаться

        $currentUser->unfollowUser($user);

        return [
            'success' => true,
        ];
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
