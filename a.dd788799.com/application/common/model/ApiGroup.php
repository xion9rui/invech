<?php
namespace app\common\model;
use think\Model;

class ApiGroup extends Base{

    protected $table = 'gygy_api_group';

    public static function getList(){

        $params = request()->param();

        $query = self::order('id');

        $data = $query->paginate(10);
        
        return $data;
    }

    public function apis()
    {
        return $this->hasMany('Api','group_id')->where('enable',1)->order('sort');
    }
}
