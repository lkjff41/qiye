<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 23:09
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Loader;
use app\admin\model\Admin as adminModel;
class Admin extends Base {
    public function lis(){
        $auth = new Auth();
        $admin = new adminModel();
        $list = $admin->paginate(5);
        foreach ($list as $k=>$v){
            $gtitle = $auth->getGroups($v['id']);
            $v['title'] = $gtitle[0]['title'];
        }
        $this->assign('list',$list);
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Admin');
            if (!$validate->scene('add')->check($info)){
                $this->error($validate->getError());die;
            }
            $info['password'] = md5($info['password']);
            $adminDate = [];
            $adminDate['username'] = $info['username'];
            $adminDate['password'] = $info['password'];
            $admin = new adminModel();
            if ($admin->insert($adminDate)){
                $aga = [];
                $aga['uid'] = $admin->getLastInsID();//获取增id
                $aga['group_id'] = $info['group_id'];
                db('auth_group_access')->insert($aga);
                $this->success('添加信息成功','lis');
            }else {
                $this->error('添加失败');
            }
        }
        $gname = db('authGroup')->select();
        $this->assign('gname',$gname);
        return $this->fetch();
    }

    public function edit(){
        $id = input('id');
        $data = db('admin')->find($id);
        if (request()->isPost()){
            $info = [
                'username'=>input('username'),
            ];
            if (input('password')){
                $info['password'] = md5(input('password'));
            }else{
                $info['password'] = $data['password'];
            }

            $validate = Loader::validate('Admin');
            if (!$validate->scene('edit')->check($info)){
                $this->error($validate->getError());die;
            }
            $aga = [];
            $aga['uid'] = $id;
            $aga['group_id'] = input('post.group_id');
            if (!$aga['group_id']){
                $aga['group_id']='';
            }
//            var_dump($aga);die;
            db('auth_group_access')->where('uid',$aga['uid'])->update(['group_id'=>$aga['group_id']]);
            $adminDate = [];
            $adminDate['username'] = $info['username'];
            $adminDate['password'] = $info['password'];
            $up = db('admin')->where('id',$id)->update($adminDate);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }
        }
        $gname = db('authGroup')->select();
        $panduan = db('auth_group_access')->where('uid',$id)->find();
        $this->assign('panduan',$panduan);
        $this->assign('gname',$gname);
        $this->assign('data',$data);
        return $this->fetch();

    }

    public function del(){
        $id = input('id');
        $admin = new adminModel();
        if ($id!=1){
            if ($admin::destroy($id)){
                $this->success('删除成功','lis');
            }else{
                $this->error('删除失败');
            }
        }
        return $this->fetch();
    }

    public function logout(){
        session(null);
        $this->success('退出成功','Login/index');
    }
}