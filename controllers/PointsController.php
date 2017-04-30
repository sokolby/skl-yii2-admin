<?php

namespace amnah\yii2\user\controllers;

use amnah\yii2\user\models\Points;
use Yii;
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\UserToken;
use amnah\yii2\user\models\UserAuth;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AdminController implements the CRUD actions for User model.
 */
class PointsController extends Controller
{

    public $layout = '@app/views/layouts/admin/main.php';

    /**
     * @var \amnah\yii2\user\Module
     * @inheritdoc
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        // check for admin permission (`tbl_role.can_admin`)
        // note: check for Yii::$app->user first because it doesn't exist in console commands (throws exception)
        if (!empty(Yii::$app->user) && !Yii::$app->user->can("admin")) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * List all User models
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var \amnah\yii2\user\models\search\UserSearch $searchModel */
        $searchModel = $this->module->model("PointsSearch");
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }


    /**
     * Display a single User model
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'points' => $this->findModel($id),
        ]);
    }

    /**
     * Create a new User model. If creation is successful, the browser will
     * be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var \amnah\yii2\user\models\User $user */
        /** @var \amnah\yii2\user\models\Profile $profile */

        $user = $this->module->model("Points");

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // load post data and validate
        if ($userLoaded && $user->validate()) {
            $user->save(false);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('create', compact('user'));
    }

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // delete row
        $row = $this->findModel($id);
        $row->delete();

        return $this->redirect(['index']);
    }

    public function actionAddpoints(){
        if(Yii::$app->user->identity->attributes['role_id'] !== 1){
            var_dump('Get out'); die;
        }


        $user = $this->module->model("Points");

        $transaction = $this->module->model("Transaction");


        // Get points amount
        $user_identity = Yii::$app->user->identity;
        $uid = $user_identity->profile->user_id;
        $points_amount = Points::find()->where(['user_id' => $uid])->one();

        $post = Yii::$app->request->post();

        $userLoaded = $user->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // load post data and validate
        if ($userLoaded && $user->validate()) {
            $user = $this->findModel($post['Points']['user_id']);
            $new_balance = (int)$points_amount->amount + (int)$post['Points']['amount'];
            $user->amount = $new_balance;
            $user->last_update = date("Y-m-d H:i:s");
            $user->save(false);

            $transaction->user_id = $post['Points']['user_id'];
            $transaction->date = date("Y-m-d H:i:s");
            $transaction->status = 200;
            $transaction->amount = (int)$post['Points']['amount'];
            $transaction->desc = $post['Transaction']['desc'];
            $transaction->save(false);

            return $this->redirect('index');
        }

        return $this->render('addpoints', compact('user','transaction'));
    }

    public function actionRemovepoints(){
        if(Yii::$app->user->identity->attributes['role_id'] !== 1){
            var_dump('Get out'); die;
        }


        $user = $this->module->model("Points");

        $transaction = $this->module->model("Transaction");


        // Get points amount
        $user_identity = Yii::$app->user->identity;
        $uid = $user_identity->profile->user_id;
        $points_amount = Points::find()->where(['user_id' => $uid])->one();

        $post = Yii::$app->request->post();

        $userLoaded = $user->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // load post data and validate
        if ($userLoaded && $user->validate()) {
            $user = $this->findModel($post['Points']['user_id']);
            $new_balance = (int)$points_amount->amount - (int)$post['Points']['amount'];
            $user->amount = $new_balance;
            $user->last_update = date("Y-m-d H:i:s");
            $user->save(false);

            $transaction->user_id = $post['Points']['user_id'];
            $transaction->date = date("Y-m-d H:i:s");
            $transaction->status = 100;
            $transaction->amount = (int)$post['Points']['amount'];
            $transaction->desc = $post['Transaction']['desc'];
            $transaction->save(false);

            return $this->redirect('index');
        }

        return $this->render('removepoints', compact('user','transaction'));
    }

    /**
     * Find the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \amnah\yii2\user\models\User $user */
        $user = $this->module->model("Points");
        $user = $user::findOne($id);
        if ($user) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
