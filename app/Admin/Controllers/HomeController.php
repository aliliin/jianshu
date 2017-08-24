<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 2017/8/19
 * Time: 上午9:32
 */

namespace App\Admin\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }
}