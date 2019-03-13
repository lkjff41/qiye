<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Controller;
use app\index\model\Cate;
use app\index\model\Article;

class Artlist extends Base
{
    public function index()
    {
        $id = input('cateid');
        $art = new Article();
        $list = $art->getAllArticle($id);
        $hot = $art->getHotClick($id);

        $this->assign('list',$list);
        $this->assign('hot',$hot);
        return $this->fetch('artlist');
    }


}
