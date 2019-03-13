<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Controller;
use app\index\model\Article as artModel;


class Article extends Base
{
    public function index()
    {
        $id = input('artid');
        $data = db('article')->find($id);
        db('article')->where(['id'=>$id])->setInc('click');
//        var_dump($data);die;
        $art = new artModel();
        $hot = $art->getHotClick($data['cateid']);
        $this->assign('hot',$hot);
        $this->assign('data',$data);
//        var_dump($hot);die;
        return $this->fetch('article');
    }
    public function getzan($id){
        $zan = db('article')->where(['id'=>$id])->setInc('zan');
        echo json_decode($zan);
    }
}
