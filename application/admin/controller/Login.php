<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 23:09
 */
namespace app\admin\controller;
//use app\admin\controller\Base;
use think\Controller;
use app\admin\model\Admin;
class Login extends Controller {
    public function index(){
        if (request()->isPost()){
           $admin = new Admin();
           $num =  $admin->login(input('post.'));
//           var_dump($num);die;
           if ($num == 3){
               $this->success('登录成功','admin/lis');
           }elseif ($num==4){
               $this->error('验证码错误');
            }else{
               $this->error('登录信息错误');
           }
        }
        return $this->fetch('login');
    }
}