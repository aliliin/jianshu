<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 2017/8/20
 * Time: 下午6:23
 */

namespace App\Admin\Controllers;

use App\Post;

class PostController extends Controller
{
    //文章展示
    public function index()
    {
        $posts = Post::withoutGlobalScope('avaiable')
                ->orderBy('created_at','desc')
                ->where('status',0)
                ->paginate(10);
        return view('admin.post.index',compact('posts'));

    }
    //文章状态
    public function status(Post $post)
    {
        // 验证
        $this->validate(request(), [
            'status' => 'required|in:-1,1'
        ]);
        //逻辑
        $post->status = request('status');
        $post->save();
        // 渲染
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}