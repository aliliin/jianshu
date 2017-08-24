<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//用户模块
Route::get('/','\App\Http\Controllers\LoginController@welcome');
//注册页面
Route::get('/register','\App\Http\Controllers\RegisterController@index');
//注册行为
Route::post('/register','\App\Http\Controllers\RegisterController@register');
//登录页面
Route::get('/login','\App\Http\Controllers\LoginController@index');
//登录行为
Route::post('/login','\App\Http\Controllers\LoginController@login');

Route::group(['middleware' => 'auth:web'], function(){
    //登出行为
    Route::get('/logout','\App\Http\Controllers\LoginController@logout');

    //个人设置页面
    Route::get('/user/me/setting','\App\Http\Controllers\UserController@setting');
    //个人设置操作
    Route::post('/user/me/setting','\App\Http\Controllers\UserController@settingStore');

    //个人中心路由
    Route::get('/user/{user}','\App\Http\Controllers\UserController@show');
    //个人关注某人
    Route::post('/user/{user}/fan','\App\Http\Controllers\UserController@fan');
    //取消关注
    Route::post('/user/{user}/unfan','\App\Http\Controllers\UserController@unfan');


    //文章展示页
    Route::get('/posts','\App\Http\Controllers\PostController@index');

    //文章创建
    Route::get('/posts/create','\App\Http\Controllers\PostController@create');
    Route::post('/posts','\App\Http\Controllers\PostController@store');

    //文章详情页
    Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
    //编辑文章
    Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
    Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
    //删除文章
    Route::get('/posts/{post}/delete','\App\Http\Controllers\PostController@delete');
    //图片上传
    Route::post('/posts/image/upload','\App\Http\Controllers\PostController@imageUpload');

    //提交评论
    Route::post('posts/{post}/comment','\App\Http\Controllers\PostController@comment');

    //点赞
    Route::get('posts/{post}/zan','\App\Http\Controllers\PostController@zan');
    //取消点赞
    Route::get('posts/{post}/unzan','\App\Http\Controllers\PostController@unzan');


    //专题详情页
    Route::get('/topic/{topic}','\App\Http\Controllers\TopicController@show');
    //投稿
    Route::post('/topic/{topic}/submit','\App\Http\Controllers\TopicController@submit');

    //通知路由
    Route::get('/notices','\App\Http\Controllers\NoticeController@index');

});


//后台路由逻辑
Route::group(['prefix' => 'admin'],function (){
   //后台登录展示页面
    Route::get('/login','\App\Admin\Controllers\LoginController@index');
    //登录行为
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    //登出行为
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');


    //登录以后才能访问的页面
    Route::group(['middleware' => 'auth:admin'],function (){
        //首页
        Route::get('/home','\App\Admin\Controllers\HomeController@index');

        //根据权限判断路由的进入口
        Route::group(['middleware' => 'can:系统管理员'],function (){
            //管理人员模块
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            //用户角色修改页面
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');
            //角色
            //角色列表页
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            //角色创建页面
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            //角色创建逻辑
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
            //角色权限设置页面
            Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

            //权限
            //权限列表页面
            Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
            //权限创建页面
            Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
            //权限创建逻辑行为
            Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');
        });


        Route::group(['middleware' => 'can:文章管理'],function (){
            //文章审核模块
            Route::get('/posts','\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });
        Route::group(['middleware' => 'can:专题管理'],function (){
            Route::resource('topics', '\App\Admin\Controllers\TopicController',
                ['only' => ['index', 'create', 'store','destroy']]);
        });

        Route::group(['middleware' => 'can:通知管理'],function (){
            Route::resource('notices', '\App\Admin\Controllers\NoticeController',
                ['only' => ['index', 'create', 'store']]);
        });

    });

});