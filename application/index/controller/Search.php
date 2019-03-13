<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18
 * Time: 22:58
 */
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
class Search extends Base{
    function index(){
        if (request()->isGet()){
            $q = input('q');
            $search = db('article')
                ->where('title','like',"%".$q."%")
                ->paginate($listRows = 10, $simple = false, $config = ['query'=>['q'=>$q]]);
        }
        $this->assign('search',$search);
        return $this->fetch('search');
    }
}