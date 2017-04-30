<?php

namespace amnah\yii2\user\controllers;

use Yii;
use amnah\yii2\user\models\User;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Log activity model.
 */
class TriggerController extends Controller
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

        $this->layout = false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $data = [
            "RequestId" => 1,
            "Photo"     => 'http://rastishka.by/wp-content/themes/afisha_rastishka/content/banner/adv-3.png'
        ];
        $data_string = json_encode($data);

        $data_string = '{ "RequestId": 3,"ContactId": 24364,"Product": [ {"productId":1, "count":3}, {"productId":2, "count":1}],"Photo": ["http://rastishka.by/wp-content/themes/afisha_rastishka/content/banner/adv-3.png"]}';

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://139.59.146.153:8080/api/receipt?');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $out = curl_exec($curl);
            curl_close($curl);
        }


        var_dump(json_decode($out));
        die;

    }

    public function actionReceipt_add(){
        $this->layout = false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $data = [
            "RequestId" => 7,
            "Product"   => [
                [
                "productId" => 1,
                "count"     => 2
                ],[
                "productId" => 2,
                "count"     => 1
                ],
            ],
            "Photo"     => [
                'http://rastishka.by/wp-content/themes/afisha_rastishka/content/banner/adv-3.png'
            ],
            "TestStatus" => 2
        ];
        $data_string = json_encode($data);

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://139.59.146.153:8080/api/receipt');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $out = curl_exec($curl);
            curl_close($curl);
        }


        var_dump(json_decode($out));
        die;
    }

    public function actionReceipt_status(){
        $this->layout = false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $data = [
            "ArrayRequestId" => [1,3,7]
        ];

        $data_string = json_encode($data);

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://139.59.146.153:8080/api/receiptList');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $out = curl_exec($curl);
            curl_close($curl);
        }


        var_dump(json_decode($out));
        die;
    }

    public static function api_receipt_add($receipt_id,$info){



        $coll_name = \amnah\yii2\user\models\Receipt::find()->where(['id'=>$receipt_id])->one();
        $photos = json_decode($coll_name->img);
        $products = json_decode($info);

        foreach ($photos as $ind => $ph){
            $photos[$ind] = 'http://rastishka-new.stage.by/user_receipt/'.$coll_name->user_id.'/'.$ph;
            //$photos[$ind] = 'http://rastishka-new.stage.by/user_receipt/1/1_IMG_17062015_114455_2017_04_17_14_03_24.png';
        }

        $product_arr = [];
        $i=0;
        foreach ($products as $ind=>$pr){
            if($pr > 0){
                $pr_id = explode('_',$ind);
                if($pr_id[3] > 0){
                    $product_arr[$i]['productId'] = $pr_id[1].$pr_id[3];
                }else{
                    $product_arr[$i]['productId'] = $pr_id[1];
                }

                $product_arr[$i]['count'] = $pr;
                $i++;
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $data = [];
        $data["RequestId"] = $receipt_id;
        $data["Product"] = $product_arr;
        $data["Photo"] = $photos;
        $data["TestStatus"] = 2;

        $data_string = json_encode($data);

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://139.59.146.153:8080/api/receipt');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $out = curl_exec($curl);
            curl_close($curl);
        }

        return $out;

    }

}
