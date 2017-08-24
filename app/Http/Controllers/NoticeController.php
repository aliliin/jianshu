<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 2017/8/23
 * Time: 下午7:57
 */

namespace App\Http\Controllers;


class NoticeController extends Controller
{
    //通知列表页面
    public function index()
    {
        //获取当前用户是谁
        $user = \Auth::user();

        $notices = $user->notices;
        return view('notice/index',compact('notices'));
    }

}