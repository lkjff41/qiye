<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class Conf extends Validate{
    protected $rule = [
        'cnname'=>'require|max:50|unique:Conf',
        'enname'=>'require|max:50|unique:Conf',
        'type'=>'require|number',
        'sort'=>'number',
        'value'=>'max:255',
        'values'=>'max:255',
    ];

    protected $message = [
        'cnname.require'=>'中文名称不能为空',
        'enname.require'=>'英文名称不能为空',
        'type.require'=>'类型不能为空',
        'cnname.max'=>'中文名称不可超过50个字符',
        'enname.max'=>'英文名称不可超过50个字符',
        'value.max'=>'配置值不可超过255个字符',
        'values.max'=>'配置可选值不可超过255个字符',
        'sort.number'=>'必须是数字',
    ];

//    protected $scene = [
//        'add'=>['cnname','enname','type','sort','value','values'],
//        'edit'=>['cnname','enname','type','sort','value','values'],
//        'undate'=>['enname']
//    ];

}