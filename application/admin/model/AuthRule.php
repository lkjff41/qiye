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

class AuthRule extends Model{
//    protected static function init(){
//        AuthGroup::event('before_delete',function ($info){
//            db('authGroupAccess')->where(['group_id'=>$info['id']])->delete();
//        });
//    }

    public function catetree(){
        $arr = $this->order('sort desc')->select();
        return $this->sort($arr);
    }

    public function sort($data,$pid=0){
        static $arr = [];
        foreach ($data as $k=>$v){
            if ($v['pid']==$pid){
                $v['dataid'] = $this->getparentid($v['id']);
                $arr[] = $v;
                $this->sort($data,$v['id']);
            }
        }
        return $arr;
    }

    public function getchilrenid($cateid){
        $cates = $this->select();
        return $this->_getchilrenid($cates,$cateid);
    }

    public function _getchilrenid($data,$cateid){
        static $arr = [];
        foreach ($data as $k=>$v){
            if ($v['pid']==$cateid){
                $arr[] = $v['id'];
                $this->_getchilrenid($data,$v['id']);
            }
        }
        return $arr;
    }

    public function getparentid($cateid){
        $cates = $this->select();
        return $this->_getparentid($cates,$cateid,True);
    }

    public function _getparentid($data,$cateid,$clear=false){
        static $arr = [];
        //静态数组重复 所以加个判断 清空
        if ($clear){
            $arr = [];
        }
        foreach ($data as $k=>$v){
            if ($v['id']==$cateid){
                $arr[] = $v['id'];
                $this->_getparentid($data,$v['pid'],false);
            }
        }
        asort($arr);
        $arrstr = implode('-',$arr);
        return $arrstr;
    }
}