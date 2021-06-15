<?php
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$img_ext=['jpg','png','gif','jpeg'];
$imgFolderPath=Yii::$app->assetManager->publish('@vendor/webrise1/filemanager/src/assets/img/folder.png')[1];
$showFolders=null;
$folders=Yii::$app->controller->module->folders;
if($folderNs){
    $parent=$folders[$folderNs]->parent;
    $curFolderTitle=$folders[$folderNs]->title;
    foreach($folders[$folderNs]->childs as $child){
        $showFolders[$child->pathNS]=$child;
    }
    $initialPreview=[];
    $initialPreviewConfig=[];
    foreach($files as $file){
        $image=false;
        if(in_array(pathinfo($file->path)['extension'],$img_ext))
            $image=true;
        $initialPreview[]='/'.$file->path;
        $initialPreviewConfig[]=
            [

                'caption' =>"<a  target='_blank' href='".Url::to(['/filemanager/api/api/get-file','code'=>$file->hashcode])."'>".$file->name."</a><br>".$file->snippet,
                'url'=> Url::to(['admin/default/delete-file']),
                'key'=> $file->id,
                'type' => ($image)?'image':'object',

//                'zoomData' =>  "http://dev.webrise-big-change/uploads/extension_filemanager/extension_pdf_generator/assets/css/style_VC9sPDJ-DFArFy6o.css"
            ];
    }

}else{
    $SchemaFolders=Yii::$app->controller->module->SchemaFolders;
    foreach($SchemaFolders as $SchemaFolder){
        $showFolders[$folders[$SchemaFolder['folderName']]->pathNS]=$folders[$SchemaFolder['folderName']];
    }
}
if($parent){
    $returnLink= "?folder=".$parent->pathNS;
}else
    $returnLink='/admin/filemanager';




?>
    <?=\yii\helpers\Html::a(($parent)?'&#8592;'.$parent->title:'&#8592;Home',$returnLink,['class'=>'btn btn-success'])?><br>
    <h3><?=$curFolderTitle?></h3>
    <?php foreach($showFolders as $showFolder): ?>
        <div class="filemanager_folder" >
            <a href="?folder=<?=$showFolder->pathNS?>">
                <h4><?=$showFolder->title?></h4>
                <img src="<?=$imgFolderPath?>">
            </a>
        </div>
    <?php  endforeach;?>

<?php $form=ActiveForm::begin()?>



<?php
if($folderNs){
    echo $form->field($model, 'upload_files[certificate][]')->widget(FileInput::classname(), [
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'layoutTemplates'=>[
               'actionZoom'=>'',
               'actionDrag'=>'',
                'footer'=>'{caption}{actions}',


            ],
            'initialPreviewAsData'=>true,
            'initialPreview'=>$initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ]
    ]);
}
?>
<?php $form=ActiveForm::end()?>
