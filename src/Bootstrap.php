<?php
namespace webrise1\filemanager;

use Yii;
use yii\base\BootstrapInterface;
class Bootstrap implements BootstrapInterface{
    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {


        //Правила маршрутизации
        $app->getUrlManager()->addRules([
           'admin/filemanager/<controller>/<action>' => 'filemanager/admin/<controller>/<action>',
           'admin/filemanager/<controller>' => 'filemanager/admin/<controller>',
           'filemanager/get-file' => 'filemanager/api/api/get-file',
           'admin/filemanager' => 'filemanager/admin/default',

        ], false);

    }
}