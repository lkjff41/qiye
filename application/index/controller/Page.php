<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Controller;

class Page extends Base
{
    public function index()
    {
        $id = input('cateid');
        $cate = db('cate')->find($id);
        $this->assign('cate',$cate);
        return $this->fetch('page');
    }
}
