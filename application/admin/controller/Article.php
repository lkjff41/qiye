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
use app\admin\model\Article as articleModel;
use app\admin\model\Cate as cateModel;
class Article extends Base {
    public function lis(){
        $list = db('article')
            ->alias('a')
            ->join('cate b','a.cateid=b.id')
            ->field('a.*,b.catename')
            ->order('a.id desc')
            ->paginate(5);
        $this->assign('list',$list);
       return $this->fetch('list');
    }

    public function add(){
        $cate = new cateModel();
        $pid = $cate->catetree();
        $art = new articleModel();
        if (request()->isPost()){
            $info = input('post.');
            $validate = Loader::validate('Article');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }

            if ($art->save($info)){
                $this->success('添加成功','lis');
            }else{
                $this->error('添加失败');
            }
        }
        $this->assign('pid',$pid);
        return $this->fetch('add');
    }

//    public function add(){
//        $cate = new cateModel();
//        $pid = $cate->catetree();
//        if (request()->isPost()){
//            $info = input('post.');
//            $info['time'] = time();
//            $info['keywords'] = str_replace('，',',',input('keywords'));
//            if ($_FILES['pic']['tmp_name']){
//                $file = request()->file('pic');
//                $pic = $file->validate(['fileSize'=>2048000])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
//                $info['pic'] = '/uploads/' . $pic->getSavename();
//            }
////            var_dump($info);die;
//            $validate = Loader::validate('Article');
//            if (!$validate->check($info)){
//                $this->error($validate->getError());die;
//            }
//            if (db('article')->insert($info)){
//                $this->success('添加成功','lis');
//            }else{
//                $this->error('添加失败');
//            }
//        }
//        $this->assign('pid',$pid);
//        return $this->fetch('add');
//    }



    public function edit(){
        $id=input('id');
        $cate = new cateModel();
        $pid = $cate->catetree();
        $artmodel = new articleModel();
        $art = db('article')->find($id);
        if (request()->isPost()) {
            $info = input('post.');
            $validate = Loader::validate('Article');
            if (!$validate->check($info)){
                $this->error($validate->getError());die;
            }
            if (empty($info['rec'])){
                $info['rec'] = 0;
            }
            $up = $artmodel->update($info);
            if ($up!==false){
                $this->success('修改成功','lis');
            }else{
                $this->error('修改失败');
            }

        }
//        var_dump($art);die;
        $this->assign('art',$art);
        $this->assign('pid',$pid);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        $art = new articleModel();
        if ($art::destroy($id)){
            $this->success('删除成功','lis');
        }else{
            $this->error('删除失败');
        }
        return;
    }

}