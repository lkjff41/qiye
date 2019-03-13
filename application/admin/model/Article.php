<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 19:18
 */
namespace  app\admin\model;
use think\Model;
use think\Db;
use think\Loader;
use think\captcha;
class Article extends Model{

    protected static function init(){
        Article::event('before_insert',function ($info){
            $info['time'] = time();
            $info['keywords'] = str_replace('，',',',input('keywords'));
            if ($_FILES['pic']['tmp_name']){
                $file = request()->file('pic');
                $pic = $file->validate(['fileSize'=>2048000])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                $info['pic'] = '/uploads/' . $pic->getSavename();
            }
        });

        Article::event('before_update',function ($info){
            $info['keywords'] = str_replace('，',',',input('keywords'));
            if ($_FILES['pic']['tmp_name']){
                //删除图片----------------------------------------------
                $arts = Article::find($info->id);
                $picpath = $_SERVER['DOCUMENT_ROOT'].'/public/static'.$arts['pic'];
                if (file_exists($picpath)){
                    @unlink($picpath);
                }
                //删除图片----------------------------------------------
                $file = request()->file('pic');
                $pic = $file->validate(['fileSize'=>2048000])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                if ($pic){
                    $info['pic'] = '/uploads/' . $pic->getSavename();
                }

            }
        });

        Article::event('before_delete',function ($info){
                //删除图片----------------------------------------------
                $arts = Article::find($info->id);
                $picpath = $_SERVER['DOCUMENT_ROOT'].'/public/static'.$arts['pic'];
                if (file_exists($picpath)){
                    @unlink($picpath);
                }
                //删除图片----------------------------------------------
        });

    }
}