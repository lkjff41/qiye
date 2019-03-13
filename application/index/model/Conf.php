<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 14:05
 */
namespace app\index\model;
use think\Model;
//use app\admin\model\Conf as confAdmin;

class Conf extends Model{
    function getAllConf(){
        $data = db('conf')->field('enname,value')->select();
        return $data;
    }
}
