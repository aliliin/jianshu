<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 2017/8/23
 * Time: 下午6:14
 */

namespace App\Admin\Controllers;


use App\Notice;

class NoticeController extends Controller
{
    //通知页面显示
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index',compact('notices'));
    }
    //创建通知页面
    public function create()
    {
        return view('admin.notice.create');
    }
    //创建通知逻辑
    public function store()
    {
        $this->validate(request(),[
            'title' => 'required|max:16|string',
            'content' => 'required|max:16|string',
        ]);
        $notice = Notice::create(request(['title','content']));
        //分发通知消息的逻辑
        dispatch(new \App\Jobs\SendMessage($notice));
        return  redirect('/admin/notices');
    }

}