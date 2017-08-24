<?php

namespace App\Admin\Controllers;


use App\AdminUser;
use Illuminate\View\View;

class UserController extends Controller
{

    //管理员管理页面
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('/admin.user/index',compact('users'));
    }

    public function create()
    {
        return view('/admin.user/add');

    }

    public function store()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required | min:3 | unique:users,name',
            'password' => 'required |min:5|max:10',
        ]);
        //验证逻辑
        $name     = request('name');
        $password = bcrypt(request('password'));

         AdminUser::create(compact('name','password'));
        //渲染
        return redirect('/admin/users');
    }

    //用户角色页面
    public function role(\App\AdminUser $user)
    {
        $roles = \App\AdminRole::all();
        $myRole = $user->roles;
        return view('admin.user.role',compact('roles','myRole','user'));

    }
    //储存用户角色
    public function storeRole(\App\AdminUser $user)
    {
        $this->validate(request(),[
            'roles' => 'required | array',
        ]);
        $roles = \App\AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        //要增加的新角色
        $addRoles=$roles->diff($myRoles);
        foreach ($addRoles as $role){
            $user->assignRole($role);
        }
        //要取消的已经又的角色
        $deleteRoles= $myRoles->diff($roles);
        foreach ($deleteRoles as $role){
            $user->deleteRole($role);
        }

        return back();

    }
}