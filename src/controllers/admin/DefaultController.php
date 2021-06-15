<?php
namespace webrise1\filemanager\controllers\admin;
use webrise1\filemanager\assets\AssetsBundle;
use webrise1\filemanager\models\File;
use webrise1\filemanager\Module;
use yii\web\UploadedFile;
use Yii;
class DefaultController extends \yii\web\Controller{
    public function actionIndex($folder=null){

        AssetsBundle::register($this->view);
        $model=new File();
        if($folder){
            $folderModel=$this->module->folders[$folder];
            if($folderModel){
                $files=File::find()->where(['folderNS'=>$folderModel->pathNS])->all();
                if($_FILES){
                        $module=$this->module;
                        $path= $module->uploadsDir.'/'.$module::MODULE_UPLOADS_FOLDER_NAME.'/'.$folderModel->path ;
                        $model->folderNS=$folderModel->pathNS;
                        $model->upload_files = UploadedFile::getInstances($model, 'upload_files');
                        $model->upload($path);
                        $this->refresh();
                    }
            }

        }
        return $this->render('index',['model'=>$model,'folderNs'=>$folder,'files'=>$files]);
    }

    public function actionDeleteFile(){


        if($key=Yii::$app->request->post('key')){
            if($file=File::findOne($key)){
                if($message=$file->findUsingChippetFile())
                    return json_encode(['error'=>$message]);
                if($file->delete())
                    return true;
            }

        }
        return json_encode(['error'=>'error']);
    }

}

