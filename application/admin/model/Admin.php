<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 19:18
 */
namespace  app\admin\model;
use think\Model;
use think\Db;
use think\captcha;
class Admin extends Model{
    protected static function init(){
        Admin::event('before_delete',function ($info){
            db('authGroupAccess')->where(['uid'=>$info['id']])->delete();
        });

    }

    public function login($data){
            $captcha = new captcha\Captcha();
            if (!$captcha->check($data['code'])) {
                return 4;
            }
            $user = Db::name('admin')
                ->where('username', '=', $data['username'])->find();
            if ($user) {
                if ($user['password'] == md5($data['password'])) {
                    session('username', $user['username']);
                    session('uid', $user['id']);
                    return 3; //信息正确
                } else {
                    return 2;//用户存在，密码错误
                }
            } else {
                return 1;//用户不存在
            }
        }

}