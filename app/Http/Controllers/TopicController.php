<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //专题想起页
    public function show(Topic $topic)
    {
        //传递带文章数的专题
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //专题的文章列表 按照创建时间 倒序排列前十个
        $posts = $topic->posts()->orderBy('created_at','desc')->take(10)->get();

        //属于我的文章但是未投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        return view('topic.show',compact('topic','posts','myposts'));
    }
    //投稿
    public function submit(Topic $topic)
    {
        //验证
        $this->validate(\request(),[
            'post_ids' => 'required | array'
        ]);
        $post_ids = \request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id){
            \App\PostTopic::firstOrCreate(compact('topic_id','post_id'));
        }
        return  back();
    }
}
