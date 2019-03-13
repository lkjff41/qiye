<?php
/**
 * Created by PhpStorm.
 * User: cateistrator
 * Date: 2018/12/7
 * Time: 23:09
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AuthRule as arModel;
use think\Loader;

class AuthRule extends Base {

    public function lis(){
        $rule = new arModel();
        $info = input('post.');
        if (request()->isPost()){
            foreach ($info as $k=>$v){
                db('authRule')->update(['id'=>$k,'sort'=>$v]);
            }
        }
//        $list = db('authRule')->order('sort desc')->paginate(5);
        $list = $rule->catetree();
//        var_dump($list);
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('AuthRule');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
//            var_dump($info);die;
            $plevel = db('authRule')->field('level')->find($info['pid']);
            if ($plevel){
                $info['level'] = $plevel['level']+1;
            }else{
                $info['level'] = 0;
            }

//            var_dump($info);die;
            $up = db('authRule')->insert($info);
            if ($up){
                $this->success('添加成功','lis');
            }else{
                $this->error('添加失败');
            }
            return;
        }
        $rule = new arModel();
        $data = $rule->catetree();
        $this->assign('data',$data);
        return $this->fetch('add');
    }

    public function edit(){
        $id = input('id');
        $data = db('authRule')->find($id);//读取本条

        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('AuthRule');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            foreach ($info as $k=>$v){
                $f_info[] = $k;
            }
            if (!in_array('status',$f_info)){
                $info['status'] = 0;
            }
            $plevel = db('authRule')->field('level')->find($info['pid']);
            if ($plevel){
                $info['level'] = $plevel['level']+1;
            }else{
                $info['level'] = 0;
            }

            $up = db('authRule')->update($info);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
        }

        $rule = new arModel();
        $datas = $rule->catetree();
        $this->assign('datas',$datas);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function del(){
        $rule = new arModel();
        $id = input('id');
        $chil = $rule->getchilrenid($id);
        $chil[]=$id;
        if ($rule::destroy($chil)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }

}