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
use app\admin\model\Link as linkModel;
class Link extends Base {

    public function lis(){
        if (request()->isPost()){
            $sorts = input('post.');
            foreach ($sorts as $k=>$v){
                db('link')->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('排序成功',url('lis'));
        }
        $list = db('link')->order('sort desc')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Link');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            $link = new linkModel();
            $up = $link->insert($info);
            if ($up){
                $this->success('添加成功','lis');
            }else{
                $this->error('添加失败');
            }
            return;
        }
        return $this->fetch('add');
    }

    public function edit(){
        $id = input('id');
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Link');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            $up = db('link')->update($info);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
        }
        $data = db('link')->find($id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        $link = new linkModel();
        if ($link::destroy($id)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }

}