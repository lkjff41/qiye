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

class AuthGroup extends Model{
    protected static function init(){
        AuthGroup::event('before_delete',function ($info){
            db('authGroupAccess')->where(['group_id'=>$info['id']])->delete();
        });

//        AuthGroup::event('before_update',function ($info){
//           db('authGroup')->where(['id'=>$info['id']])->update(['rules'=>'']);
//        });
    }

}