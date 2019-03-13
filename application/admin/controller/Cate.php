<?php
/**
 * Created by PhpStorm.
 * User: cateistrator
 * Date: 2018/12/7
 * Time: 23:09
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Loader;
use app\admin\model\Cate as cateModel;
use app\admin\model\Article as articleModel;
class Cate extends Base {

    protected $beforeActionList = [
        'delsoncate'=>['only'=>'del'],
    ];

    public function lis(){
        $cate = new cateModel();
        $list = $cate->catetree();
        if (request()->isPost()){
            $sort = input('post.');
            foreach ($sort as $k=>$v){
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功');
        }
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        $cate = new cateModel();
        $pid = $cate->catetree();
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Cate');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            if (db('cate')->insert($info)){
                $this->success('添加成功','lis');
            }else{
                $this->error('添加失败');
            }
        }
        $this->assign('pid',$pid);
        return $this->fetch('add');
    }

    public function edit(){
        $cate = new cateModel();
        //上级
        $pid = $cate->catetree();
        $id=input('id');
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Cate');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            $up = db('cate')->update($info);
            if ($up){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
            return;
        }
        $data = db('cate')->find($id);
        $this->assign('data',$data);
        $this->assign('pid',$pid);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        $cate = new cateModel();
        if ($cate::destroy($id)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }
    public function delsoncate(){
        $cateid = input('id');
        $cate = new cateModel();
        $sonid = $cate->getchilrenid($cateid);
        $allcateid = $sonid;
        $allcateid[]  = $cateid;
//        var_dump($allcateid);die;
        foreach ($allcateid as $k=>$v) {
            $art = new articleModel();
            $art->where(['cateid'=>$v])->delete();
        }
        if ($sonid){
            db('cate')->delete($sonid);
        }
    }
}