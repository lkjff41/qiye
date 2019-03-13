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
use app\admin\model\Conf as confModel;
class Conf extends Base {

    public function lis(){
        if (request()->isPost()){
            $sorts = input('post.');
//            var_dump($sorts);die;
            foreach ($sorts as $k=>$v){
                $up = db('conf')->update(['id'=>$k,'sort'=>$v]);
            }
            if ($up){
                $this->success('排序成功','lis');
            }else{
                $this->error('排序失败');
            }
            return;
        }
        $list = db('conf')->order('sort desc')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Conf');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            $info['values'] = str_replace('，',',',$info['values']);
//            var_dump($info);die;
            $conf = new confModel();
            $up = $conf->insert($info);
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
            $validate = Loader::validate('Conf');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            $info['values'] = str_replace('，',',',$info['values']);
//            var_dump($info);die;
            $up = db('conf')->update($info);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
        }
        $data = db('Conf')->find($id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        $conf = new confModel();
        if ($conf::destroy($id)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }

    public function conf()
    {
        if (request()->isPost()) {
            $info = input('post.');
            $confs = db('conf')->field('enname')->select();
            //表里的字段
            $conf = [];
            foreach ($confs as $k => $v) {
                $conf[] = $v['enname'];
            }
            //提交的字段
            $f_conf = [];
            foreach ($info as $k => $v) {
                $f_conf[] = $k;
            }
            foreach ($conf as $k => $v) {
                if (!in_array($v, $f_conf)) {
                    $info[$v] = '';
                }elseif (is_array($info[$v])){
                    $info[$v] = implode(',',$info[$v]);
                }
            }
//            var_dump($info);die;
            foreach ($info as $k => $v) {
                db('conf')->where(['enname' => $k])->update(['value' => $v]);
            }
        }
        $list = db('conf')->select();
        $this->assign('list', $list);
        return $this->fetch('conf');

    }
}