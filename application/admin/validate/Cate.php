<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate{
    protected $rule = [
        'catename'=>'require|max:30|unique:cate',
        'keywords'=>'max:255',
        'desc'=>'max:255',
    ];

    protected $message = [
        'catename.require'=>'用户名不能为空',
        'catename.max'=>'用户名不能超过30个字符',
        'keywords.max'=>'用户名不能超过255个字符',
        'desc.max'=>'用户名不能超过255个字符',
    ];

//    protected $scene = [
//        'add'=>['username'=>'require|max:25|unique:admin'],
//        'edit'=>['username'=>'require|max:25'],
//    ];

}