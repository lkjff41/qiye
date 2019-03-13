<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class Link extends Validate{
    protected $rule = [
        'title'=>'require|max:30|unique:link',
        'desc'=>'require|max:60',
        'url'=>'require|url',
    ];

    protected $message = [
        'title.require'=>'网站名不能为空',
        'desc.require'=>'简介不能为空',
        'url.require'=>'链接地址不能为空',
        'url.url'=>'必须是url格式',
    ];

//    protected $scene = [
//        'add'=>['username'=>'require|max:25|unique:admin'],
//        'edit'=>['username'=>'require|max:25'],
//    ];

}