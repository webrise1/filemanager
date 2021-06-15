<?php
namespace webrise1\filemanager\models;
use yii\db\ActiveRecord;
use kartik\file\FileInput;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
class File extends ActiveRecord {
    public $upload_files;



    public static function tableName()
    {
        return '{{%filemanager_file}}';
    }
    public function upload($uploadsPath)
    {

        if ($this->validate()) {
            foreach ($this->upload_files as $file) {
                $model=new File();
                $model->name=$file->baseName. '.' . $file->extension;
                $filename=$file->baseName.'_'.Yii::$app->security->generateRandomString(16). '.' . $file->extension;
                $pathUrl=$uploadsPath .'/'. $filename;
                $path =Yii::getAlias('@'.$pathUrl);
                if (!is_dir($uploadsPath)) {
                    BaseFileHelper::createDirectory($uploadsPath, 0777, true);
                }
                $model->path=$pathUrl;
                $model->hashcode=Yii::$app->security->generateRandomString(32);
                $model->folderNS=$this->folderNS;

                if($file->saveAs($path))
                    $model->save();
            }
            return true;
        } else {
            return false;
        }
    }



    public function findUsingChippetFile(){
        $snippet=$this->getSnippet();
        $foundSnippet=false;
        foreach(Yii::$app->controller->module->modelsUsingFileSnippets as $modelInfo){
            $query=$modelInfo['class']::find();
            foreach($modelInfo['attributes'] as $attribute){
                $query->orWhere(['like', $attribute, $snippet]);
            }
            $result=$query->one();
            if($result){
                $message='Ошибка. Данный файл используется в таблице модели: '.$modelInfo['class'].' (id='.$result->id.') атрибуты='.implode(',',$modelInfo['attributes']);
                return $message;
                break;
            }
        }
        return $foundSnippet;
    }

    public function getSnippet(){
        return "[[file_$this->id]]";
    }
    public static function getIdFromSnippet($snippet){
        return preg_replace('/[^0-9]/', '', $snippet);
    }
    public function getFileUrl(){
       return  Url::to(['/filemanager/api/api/get-file','code'=>$this->hashcode]);
    }
    public static function convertFileSnippets($data){
        if(preg_match_all('/\[\[file_[0-9]+\]\]/',$data,$mathes)){
            $snippets=array_unique ($mathes[0]);
            foreach($snippets as $snippet){
                $file_id=self::getIdFromSnippet($snippet);
                $file=self::findOne($file_id);
                if($file){
                    $data=str_replace($snippet,$file->getFileUrl(),$data);
                }
            }
        }
        return $data;
    }

    public function afterDelete()
    {
        unlink(Yii::getAlias('@'.$this->path));
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }
}