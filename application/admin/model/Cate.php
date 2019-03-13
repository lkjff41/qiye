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
class Cate extends Model{

//    protected static function init()
//    {
//        Cate::event('before_delete',function ($data){
//            $sonid = $this->getchilrenid($data['id']);
//            if ($sonid){
//                foreach ($sonid as $k=>$v) {
//                    db('cate')->delete($v);
//                }
//            }
//        });
//    }

    public function catetree(){
        $cateres = $this->order('sort desc')->select();
        return $this->sort($cateres);
//        var_dump($cateres);die;
    }

    public function sort($data,$pid=0,$level=0){
        static $arr = [];
        foreach ($data as $k=>$v){
            if ($v['pid']==$pid){
                $v['level'] =$level;
                $arr[] = $v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
//        var_dump($arr);die;
    }

    public function getchilrenid($cateid){
        $cateres = $this->select();
        return $this->_getchilrenid($cateres,$cateid);
    }

    public function _getchilrenid($cateres,$cateid){
        static $arr=[];
        foreach ($cateres as $k=>$v){
            if ($v['pid']==$cateid){
                $arr[]=$v['id'];
                $this->_getchilrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }
}