<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 23:10
 */
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Base extends Controller{
    public function _initialize()
    {
        if (!session('username')){
            $this->error('请登录','login/index');
        }

        $auth = new Auth();
        $request = Request::instance();
        $con = $request->controller();
        $action = $request->action();
        $name = $con.'/'.$action;
        $name = strtolower($name);
        $notcheck = ['index/index','login/index','admin/logout'];
        if (session('uid')!=1){
            if (!in_array($name,$notcheck)){
                if (!$auth->check($name,session('uid'))){
                    $this->error('你没有权限访问','index/index');
                }
            }

        }

    }
}