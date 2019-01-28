<?php

use App\Models\Folder;

return [
    'title'   => '文件夹',
    'single'  => '文件夹',
    'model'   => Folder::class,

    //permission

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => 'name',
            'sortable' => false,
            // 'output'   => function ($value, $model) {
            //     return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            // },
        ],
        'data' => [
            'title'    => 'content',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<div style="max-width:600px">' . model_link($value, $model) . '</div>';
            },
        ],

        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [

        'name' => [
            'title'              => '文件夹名',
            //'name_field'         => 'name',
            //'type'               => 'text',
            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            //'autocomplete'       => true,

            // 自动补全的搜索字段
            //'search_fields'      => ["CONCAT(id, ' ', name)"],

            // 自动补全排序
            //'options_sort_field' => 'id',
        ],
        'data' => [
            'title'              => '数据',
            'type'               => 'textarea',
            //'name_field'         => 'name',
            //'search_fields'      => ["CONCAT(id, ' ', name)"],
            // 'options_sort_field' => 'id',
        ],

    ],
    'filters' => [

        'name' => [
            'title'              => '文件夹',
            //'type'               => 'relationship',
            //'name_field'         => 'name',
            //'autocomplete'       => true,
            //'search_fields'      => array("CONCAT(id, ' ', name)"),
            //'options_sort_field' => 'id',
        ],
        'data' => [
            'title'              => '内容',
            'type'               => 'textarea',
            //'name_field'         => 'name',
            //'search_fields'      => array("CONCAT(id, ' ', name)"),
            // 'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'name' => 'required'
    ],
    'messages' => [
        'name.required' => '请填写文件名',
    ],
];