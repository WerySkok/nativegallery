<?php

namespace App\Core;

use \App\Services\{Router, Auth, DB};
use \App\Core\{Page};



class Routes
{
    public static function init()
    {
        Router::get('/', 'MainController@i');
        Router::get('/t', 'MainController@t');
        Router::get('/login', 'LoginController@i');
        Router::get('/register', 'RegisterController@i');
        Router::get('/photo/$id', 'PhotoController@i');
        Router::get('/author/$id', 'ProfileController@i');

        Router::post('/api/login', 'ApiController@login');
        Router::get('/api/photo/vote', 'ApiController@photovote');
        Router::post('/api/register', 'ApiController@register');




        if (Auth::userid() > 0) {
            Router::get('/lk', 'ProfileController@lk');
            Router::get('/lk/upload', 'ProfileController@upload');
            Router::get('/lk/history', 'ProfileController@lkhistory');
            Router::post('/api/upload', 'ApiController@upload');
            Router::post('/api/photo/comment', 'ApiController@photocomment');
            Router::post('/api/photo/getcomments/$id', 'ApiController@photocommentload');
        } else {
            Router::redirect('/login?return='.$_SERVER['HTTP_REFERER']);
        }
    }
}
