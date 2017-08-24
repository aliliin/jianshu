<?php

namespace App\Admin\Controllers;


class LoginController extends Controller
{

    //登录展示页面
    public function index()
    {
        return view('admin.login.index');
    }
    //登录具体行为
    public function login()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|min:2',
            'password' => 'required |min:5|max:10',
        ]);
        //验证逻辑
        $user = request(['name','password']);

        if(\Auth::guard("admin")->attempt($user)){
            return redirect('/admin/home');
        }
        return \Redirect::back()->withErrors('用户名密码不匹配');
    }
    //登出行为
    public function logout()
    {
         \Auth::guard("admin")->logout();
        return redirect('/admin/login');

    }
}