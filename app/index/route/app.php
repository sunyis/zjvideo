<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;
Route::rule('videoSearch','Video/videoSearch','GET|POST');
Route::rule('videoDetail','Video/videoDetail','GET|POST');
Route::rule('videoList','Video/videoList','GET|POST');
Route::rule('lists','Lists/index','GET|POST');
Route::rule('getVideoDetail','Api/getVideoDetail','GET|POST');
Route::rule('Detail/:type/:urlid','Detail/index','GET|POST');
Route::rule('Play/:type/:urlid/:id/:urlbase64','Play/index','GET|POST');
Route::rule('Vlists/:type/:page','Vlists/index','GET|POST');
Route::rule('Search/:title','Search/index','GET|POST');

