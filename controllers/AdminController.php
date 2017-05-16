<?php

namespace amnah\yii2\user\controllers;

use Yii;
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\UserToken;
use amnah\yii2\user\models\UserAuth;
use amnah\yii2\user\models\Points;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
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
        $searchModel = $this->module->model("UserSearch");
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
            'user' => $this->findModel($id),
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

        $user = $this->module->model("User");
        $user->setScenario("admin");
        $profile = $this->module->model("Profile");

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }

        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('create', compact('user', 'profile'));
    }

    /**
     * Update an existing User model. If update is successful, the browser
     * will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // set up user and profile
        $user = $this->findModel($id);
        $user->setScenario("admin");
        $profile = $user->profile;

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }

        // load post data and validate
        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('update', compact('user', 'profile'));
    }

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // delete profile and userTokens first to handle foreign key constraint
        $user = $this->findModel($id);
        $profile = $user->profile;
        UserToken::deleteAll(['user_id' => $user->id]);
        UserAuth::deleteAll(['user_id' => $user->id]);
        Points::deleteAll(['user_id' => $user->id]);
        $profile->delete();
        $user->delete();

        return $this->redirect(['index']);
    }

    public function actionExport($type){

        $out = [];

        switch ($type){
            case "csv":
                $csv = $this->generateUserCsv();
                $out['error'] = 0;
                $out['response'] = $csv;
                $out['message'] = 'Скачать файл: <a href="/'.$csv.'">тут</a>';
                break;
            default:
                $out['error'] = 1;
                $out['message'] = 'Error type value';
        }

        if($out['error'] === 0){
            Yii::$app->session->setFlash("admin-success",$out['message']);
        }else{
            Yii::$app->session->setFlash("admin-error",$out['message']);
        }

        return $this->redirect('/user/admin');
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
        $user = $this->module->model("User");
        $user = $user::findOne($id);
        if ($user) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function generateUserCsv(){
        $csv_out = [];
        $user = $this->module->model("User");
        $profile = $this->module->model("Profile");

        $users = $user::find()->all();

        $region_arr = [
            "170"=>'г. Минск',
            "164"=>'Брестская область',
            "165"=>'Витебская область',
            "166"=>'Гомельская область',
            "167"=>'Гродненская область',
            "168"=>'Минская область',
            "169"=>'Могилевская область'
        ];

        $i = 0;
        $csv_result[$i] = [
            'email',
            'фамилия',
            'имя',
            'пол',
            'рождение день',
            'рождение месяц',
            'рождение год',
            'область',
            'город',
            'телефон',
            'Хочу получать сообщения об акциях Растишка',
        ];


        foreach ($users as $u){

            $profile = $profile::findOne($u->attributes['id']);

            $csv_result[$i+1] = [
                $u->attributes['email'],
                $profile->attributes['surname'],
                $profile->attributes['name'],
                ($profile->attributes['sex']===1)?'м':'ж',
                $profile->attributes['bday_d'],
                $profile->attributes['bday_m'],
                $profile->attributes['bday_y'],
                $region_arr[$profile->attributes['region']],
                $profile->attributes['city'],
                $profile->attributes['phone'],
                ($profile->attributes['chkbxEmailMe']===1)?'да':'нет'
            ];
            ++$i;
        }

        $date = date('m-d-y-H-i-s');
        $date_hash = hash('crc32',date('mdyHis'));

        $filename = $date_hash.$date;
        $file = fopen("csv_export_folder/{$filename}.csv","w");


        foreach ($csv_result as $line)
        {
            fputcsv($file,$line);
        }

        fclose($file);

        return "csv_export_folder/{$filename}.csv";
    }
}
