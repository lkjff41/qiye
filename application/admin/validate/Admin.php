<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate{
    protected $rule = [
        'username'=>'require|max:25|unique:admin',
        'password'=>'require'
    ];

    protected $message = [
        'username.require'=>'用户名不能为空',
        'username.max'=>'用户名不能超过25个字符',
        'password.require'=>'密码不能为空',
    ];

    protected $scene = [
        'add'=>['username','password'],
        'edit'=>['username'=>'require|max:25'],
    ];

}