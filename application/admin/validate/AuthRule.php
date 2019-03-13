<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class AuthRule extends Validate{
    protected $rule = [
        'name'=>'require|max:80|unique:AuthRule',
        'title'=>'require|max:20|unique:AuthRule',

        'sort'=>'number',
        'value'=>'max:255',
        'values'=>'max:255',
    ];

    protected $message = [
        'name.require'=>'方法名称不能为空',
        'title.require'=>'权限名称不能为空',
        'name.max'=>'中文名称不可超过80个字符',
        'title.max'=>'英文名称不可超过20个字符',
        'sort.number'=>'必须是数字',
    ];

//    protected $scene = [
//        'add'=>['cnname','enname','type','sort','value','values'],
//        'edit'=>['cnname','enname','type','sort','value','values'],
//        'undate'=>['enname']
//    ];

}