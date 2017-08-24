<?php
namespace App\Admin\Controllers;


use App\Topic;

class TopicController extends Controller
{
    //专题页面显示
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topic.index',compact('topics'));
    }
    //创建页面
    public function create()
    {
        return view('admin.topic.add');
    }
    //创建逻辑
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|max:16'
        ]);
        $name = request('name');
        Topic::create(compact('name'));
        return  redirect('/admin/topics');
    }
    //删除专题
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return [
            'error' => 0,
            'msg'=>''
        ];
    }
}