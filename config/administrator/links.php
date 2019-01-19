<?php

use App\Models\Link;

return [

    'title' => 'Resource Recommend',
    'single' => 'Resource Recommend',

    'model' => Link::class,

    //permission can has see this
    'permission' => function(){
        return Auth::user() -> hasRole('SuperAdmin');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'link' => [
            'title'    => '链接',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'    => '名称',
        ],
        'link' => [
            'title'    => '链接',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '标签 ID',
        ],
        'title' => [
            'title' => '名称',
        ],
    ],
];