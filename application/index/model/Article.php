<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 11:13
 */
namespace app\index\model;
use think\Model;
use app\index\model\Cate;

class Article extends Model{
    public function getAllArticle($cateId){
        $cate = new Cate();
        $chi = $cate->getchilrenId($cateId);
        $list = db('article')->where("cateid IN($chi)")->order('id desc')->paginate(12);
        return $list;
    }

    public function getHotClick($cateId){
        $cate = new Cate();
        $chi = $cate->getchilrenId($cateId);
        $list = db('article')->field('id,pic,title')->where("cateid IN($chi)")->limit(5)->order('click desc')->select();

        return $list;
    }

    public function getNewArt(){
        $new =  db('article')
            ->alias('a')
            ->join('cate b','a.cateid=b.id')
            ->field('a.*,b.catename')
            ->limit(10)
            ->order('time desc')->select();
//        var_dump($new);
        return $new;
    }

    public function getAllClick(){
        $ac = $this->field('id,pic,title')->order('click desc')->limit(5)->select();
        return $ac;
    }

    public function getPic(){
        $pic = $this->field('id,pic,title')->where(['rec'=>1])->limit(4)->select();
        return $pic;
    }
}