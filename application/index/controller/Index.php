<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Controller;
use app\index\model\Article;

class Index extends Base
{
    public function index()
    {
        $art = new Article();
        $new = $art->getNewArt();
        $ac = $art->getAllClick();
        $pic = $art->getPic();
        $link = db('link')->select();
        $this->assign('link',$link);
        $this->assign('pic',$pic);
        $this->assign('ac',$ac);
        $this->assign('new',$new);
        return $this->fetch();
    }
}
