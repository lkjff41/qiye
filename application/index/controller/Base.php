<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 13:28
 */
namespace app\index\controller;
use app\index\model\Cate;
use think\Controller;
use app\index\model\Conf;
class Base extends Controller{
    public function _initialize()
    {
        if (input('cateid')){
            $this->getPos(input('cateid'));
        }
        if (input('artid')){
            $art = db('article')->field('cateid')->find(input('artid'));
            $cateid = $art['cateid'];
            $this->getPos($cateid);
        }

        $this->getConf();
        $this->getNavCates();
    }

    public function getNavCates(){
        $data = db('cate')->where(['pid'=>0])->order('sort desc')->select();
        foreach ($data as $k=>$v){
            $children = db('cate')->where(['pid'=>$v['id']])->select();
            if ($children){
                $data[$k]['children'] = $children;
            }else{
                $data[$k]['children'] = 0;
            }
        }
//        var_dump($data);
        $this->assign('nav',$data);
    }

    public function getConf(){
        $conf = new Conf();
        $confs = $conf->getAllConf();
        $con = [];
        foreach ($confs as $k=>$v){
            $con[$v['enname']] = $v['value'];
        }
        $this->assign('con',$con);
    }

    public function getPos($cateid){
        $cate = new Cate();
        $posArr = $cate->getparents($cateid);
        $this->assign('posArr',$posArr);
    }

    public function search(){

    }
}