<?php
namespace webrise1\filemanager\controllers\api;

use webrise1\filemanager\models\File;
use Yii;
class ApiController extends \yii\web\Controller{
    public function actionGetFile($code){
        $file=File::find()->where(['BINARY(`hashcode`)' =>$code])->one();
        if($file){
            Yii::$app->response->sendFile($file->path, $file->name)->send();
        }
    }
}

