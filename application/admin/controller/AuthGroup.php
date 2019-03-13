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
use app\admin\model\AuthGroup as agModel;
use app\admin\model\AuthRule as ruModel;
class AuthGroup extends Base {

    public function lis(){
        $list = db('authGroup')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('AuthGroup');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            if (empty($info['status'])){
                $info['status']=0;
            }
            if (!empty($info['rules'])){
                $info['rules'] = implode(',',$info['rules']);
            }else{
                $info['rules']='';
            }

//            var_dump($info);die;
            $up = db('authGroup')->insert($info);
            if ($up){
                $this->success('添加成功','lis');
            }else{
                $this->error('添加失败');
            }
            return;
        }
        $rule = new ruModel();
        $rules = $rule->catetree();
        $this->assign('rules',$rules);
        return $this->fetch('add');
    }

    public function edit(){
        $id = input('id');
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('AuthGroup');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }

            if (empty($info['status'])){
                $info['status']=0;
            }

            if (!empty($info['rules'])){
                $info['rules'] = implode(',',$info['rules']);
            }else{
                $info['rules']='';
            }

            $up = db('authGroup')->update($info);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
        }
        $data = db('authGroup')->find($id);
        $rule = new ruModel();
        $rules = $rule->catetree();
        $this->assign('rules',$rules);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        $guoup = new agModel();
        if ($guoup::destroy($id)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }

}