<?php

return [
    'login' => [
        'email'    => 'required|string|email|max:50',
        'password' => 'required|string|min:6|max:30',
    ],

    'register' => [
        'name'     => 'required|string|between:2,12|unique:users',
        'email'    => 'required|string|email|max:50|unique:users',
        'password' => 'required|string|min:6|max:30',
    ],

    'avatar' => [
        'avatar' => 'required|string|url|max:191',
    ],

    'wechat_qrcode' => [
        'wechat_qrcode' => 'required|string|url|max:191',
    ],

    'basic' => [
        'name' => 'required|string|between:2,12',
    ],

    'profile' => [
        'gender'   => 'nullable|string',
        'describe' => 'nullable|string|max:100',
        'website'  => 'nullable|string|url',
        'resume'   => 'nullable|string|max:1000',
    ],

    'article' => [
        'store' => [
            'title'    => 'required|string|between:2,50',
            'topic_id' => 'required|numeric|exists:topics,id',
            'content'  => 'required|string|between:2,100000',
        ],
        'update' => [
            'title'    => 'required|string|between:2,50',
            'topic_id' => 'required|numeric|exists:topics,id',
            'content'  => 'required|string|between:2,100000',
        ],
    ],

    'comments' => [
        'store' => [
            'content'    => 'required|string|max:200',
            'article_id' => 'required|numeric|exists:articles,id',
            'reply_id'   => 'nullable|numeric|exists:comments,id',
        ],
    ],

    'topics' => [
        'store'  => [
            'name'     => 'required|string|between:1,50|unique:topics',
            'cover'    => 'required|string|url|max:191',
            'describe' => 'required|string|max:1000',
            'manages'  => 'nullable|array',
        ],
        'update' => [
            'name'     => 'required|string|between:1,50',
            'cover'    => 'required|string|url|max:191',
            'describe' => 'required|string|max:1000',
            'manages'  => 'nullable|array',
        ],
    ],
];