<?php
namespace webrise1\filemanager\models;
class Menu {
    public static function getAdminMenu($label='Файл менеджер'){
        return
            [
                'label' => $label, 'icon' => 'files-o','url' => ['/admin/filemanager']
            ];
    }
}