<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setting (User $user)
    {
        return view('user.setting', compact('user'));
    }
    // 个人设置行为
    public function settingStore (User $user)
    {
        $this->validate(request(),[
            'name' => 'min:3',
        ]);
        $user->name = request('name');
        $path = request('avatar')->storePublicly(md5(time()));
        $user->avatar =  "/storage/". $path;
        $user->save();
        return back();
    }

    //个人中心页面展示
    public function show(User $user)
    {

        //这个人的信息 关注 粉丝 文章数
        $user = User::withCount(['stars','fans','posts'])->find($user->id);

        //这个人的文章列表 取创建时间的前十条
        $posts = $user->posts()->orderBy('created_at','desc')->take(10)->get();

        //这个人关注的用户信息 关注粉丝 文章数
        $stars = $user->stars;
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();

        //关注这个人的用户 ，包含粉丝用户 的 关注 粉丝 文章
        $fans = $user->fans;
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();

        return view('user.show',compact('user','posts','susers','fusers'));
    }
    //关注用户
    public function fan(User $user)
    {
        $me = \Auth::user();
        $me->doFan($user->id);
        return [
            'error' => 0,
            'msg'=>''
        ];

    }
    //取消关注用户
    public function unfan(User $user)
    {
        $me = \Auth::user();
        $me->doUnFan($user->id);
        return [
            'error' => 0,
            'msg'=>''
        ];
    }
}
