<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post' => 'App\Policies\PostPolicy', //管理文章修改删除的权限
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //权限，把所有的权限都拿出来。
        $permissions = \App\AdminPermission::all();
        //对每一个权限定义门卫
        foreach ($permissions as $permission) {
            Gate::define($permission->name,function ($user) use($permission){
                return $user->hasPermission($permission);
            });
        }

        //
    }
}
