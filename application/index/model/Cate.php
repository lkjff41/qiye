<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 11:13
 */
namespace app\index\model;
use think\Model;

class Cate extends Model{
    public function getchilrenId($cateId){
        $data = $this->select();
        $arr = $this->_getchilrenId($data,$cateId);
        $arr[] = $cateId;
        $str = implode(',',$arr);
        return $str;
    }

    public function _getchilrenId($data,$cateId){
        static $arr=[];
        foreach ($data as $k=>$v){
            if ($v['pid']==$cateId){
                $arr[] = $v['id'];
                $this->_getchilrenId($data,$v['id']);
            }
        }
        return $arr;
    }

    public function getparents($cateid){
        $data = $this->field('id,catename,pid')->select();
        $datas = db('cate')->field('id,catename,pid')->find($cateid);
        $pid = $datas['pid'];
        if ($pid){
            $arr = $this->_getparentsid($data,$pid);
        }
        $arr[] = $datas;
        return $arr;
    }
    public function _getparentsid($data,$pid){
        static $arr = [];
        foreach ($data as $k=>$v){
            if ($v['id']==$pid){
                $arr[]=$v;
                $this->_getparentsid($data,$v['pid']);
            }
        }
        return $arr;
    }
}