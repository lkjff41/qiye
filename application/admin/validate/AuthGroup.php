<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class AuthGroup extends Validate{
    protected $rule = [
        'title'=>'require|max:100|unique:AuthGroup',
        'rules'=>'max:80',
    ];

    protected $message = [
        'title.require'=>'用户组名称不能为空',
        'rules.max'=>'名称不可超过80个字符',
    ];

//    protected $scene = [
//        'add'=>['cnname','enname','type','sort','value','values'],
//        'edit'=>['cnname','enname','type','sort','value','values'],
//        'undate'=>['enname']
//    ];

}