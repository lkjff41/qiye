<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Controller;
use app\index\model\Article;

class Imglist extends Base
{
    public function index()
    {
        $id = input('cateid');
        $art = new Article();
        $list = $art->getAllArticle($id);
//        var_dump($list);die;
        $this->assign('list',$list);
        return $this->fetch('imglist');
    }
}
