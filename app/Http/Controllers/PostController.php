<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Zan;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //列表展示页面
    public function index()
    {
        //获取关联的评论 withCount();
        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(6);
        //预加载使用方法
        $posts->load('user');
        return view("post/index",compact('posts'));
    }
    //文章详情页
    public function show(Post $post)
    {
        //评论展示
        $post->load('comments');
        return view("post/show",compact('post'));
    }
    //创建文章
    public function create()
    {
        return view("post/create");
    }
    //创建逻辑
    public function store()
    {
        //验证
        $this->validate(\request(),[
           'title' => 'required | string | max:100 |min:5',
           'content' => 'required | string |min:10',
        ]);
        //逻辑
        $user_id = \Auth::id();
        $params = array_merge(request(['title','content']),compact('user_id'));
        $post = Post::create($params);
        //渲染
        return redirect('/posts');
    }
    //编辑文章
    public function edit(Post $post)
    {
        return view("post/edit",compact('post'));
    }
    //编辑逻辑
    public function update(Post $post)
    {
        //验证
        $this->validate(\request(),[
            'title' => 'required | string | max:100 |min:5',
            'content' => 'required | string |min:10',
        ]);
        $this->authorize('update',$post);
        //逻辑
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染
        return redirect("/posts/{$post->id}");


    }
    //删除逻辑
    public function delete(Post $post)
    {
        //用户权限验证
        $this->authorize('delete',$post);
        $post->delete();
        return redirect("/posts");
    }
    //上传图片
    public function imageUpload(Request $request)
    {

        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }
    //提交评论
    public function comment(Post $post)
    {
        $this->validate(\request(),[
           'content' => 'required | min:3',
        ]);
        //逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);
        //渲染
        return back();
    }
    //点赞
    public function zan(Post $post)
    {
        $param = [
          'user_id' => \Auth::id(),
          'post_id' => $post->id,
        ];
        //如果有就查找，没有就创建 firstOrCreate;
        Zan::firstOrCreate($param);
        return back();
    }

    //取消点赞
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }
}
