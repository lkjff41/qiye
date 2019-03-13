<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/8
 * Time: 14:06
 */
namespace app\admin\validate;
use think\Validate;
class Article extends Validate{
    protected $rule = [
        'title'=>'require|max:25|unique:article',
        'keywords'=>'require|max:100',
        'desc'=>'require|max:255',
        'author'=>'require|max:30',
//        'pic'=>'fileSize:2048000|ext:jpg.png.gif',
        'content'=>'require',
    ];

    protected $message = [
        'title.require'=>'标题不能为空',
        'title.max'=>'标题不能超过个60字符',
        'keywords.require'=>'关键词不能为空',
        'keywords.max'=>'关键词不能超过100个字符',
        'desc.require'=>'简介不能为空',
        'desc.max'=>'简介不能超过255个字符',
        'author.require'=>'作者不能为空',
        'author.max'=>'作者不能超过30个字符',
        'content.require'=>'内容不能为空',
//        'pic.fileSize'=>'图片太大',
//        'pic.ext'=>'图片类型不符合',
    ];

//    protected $scene = [
//        'add'=>['username'=>'require|max:25|unique:admin'],
//        'edit'=>['username'=>'require|max:25'],
//    ];

}