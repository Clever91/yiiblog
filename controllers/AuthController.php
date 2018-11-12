<?php  

namespace app\controllers;

use Yii;
use yii\web\controller;
use app\models\LoginForm;
use app\models\RegisterForm;

/**
 * @author Sherzod Usmonov
 */
class AuthController extends Controller
{
	
	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->createUser()) {
                
                return $this->redirect(['login']);
            }
        }

        return $this->render('register', array(
            'model' => $model
        ));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest()
    {
    	echo "Test"; die;
    }
}

?>