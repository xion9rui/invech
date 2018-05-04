<?php 
namespace app\v1\controller;
use app\v1\Base;
use think\Cache;
use think\Session;

class Lottery extends Base {
    public $config = array(
        'csc' => array(
            'time_table' => 'c_opentime_2',
            'data_table' => 'c_auto_2',
            'odds_table' => 'c_odds_2',
        ),
        'csc_1' => array(
            'time_table' => 'c_opentime_2',
            'data_table' => 'c_auto_2',
            'odds_table' => 'c_odds_2',
        ),
        'cqssc' => array(
            'time_table' => 'c_opentime_2',
            'data_table' => 'c_auto_2',
            'odds_table' => 'c_odds_2',
        ),
        'cqssc_1' => array(
            'time_table' => 'c_opentime_2',
            'data_table' => 'c_auto_2',
            'odds_table' => 'c_odds_2',
        ),
        'csf' => array(
            'time_table' => 'c_opentime_4',
            'data_table' => 'c_auto_4',
            'odds_table' => 'c_odds_4',
        ),
        'csf_1' => array(
            'time_table' => 'c_opentime_4',
            'data_table' => 'c_auto_4',
            'odds_table' => 'c_odds_4',
        ),
        'xyft' => array(
            'time_table' => 'c_opentime_9',
            'data_table' => 'c_auto_9',
            'odds_table' => 'c_odds_9',
        ),
        'xyft_1' => array(
            'time_table' => 'c_opentime_9',
            'data_table' => 'c_auto_9',
            'odds_table' => 'c_odds_9',
        ),
        'gsf' => array(
            'time_table' => 'c_opentime_1',
            'data_table' => 'c_auto_1',
            'odds_table' => 'c_odds_1',
        ),
        'Gdsf_1' => array(
            'time_table' => 'c_opentime_1',
            'data_table' => 'c_auto_1',
            'odds_table' => 'c_odds_1',
        ),
        'Gdsf_2' => array(
            'time_table' => 'c_opentime_1',
            'data_table' => 'c_auto_1',
            'odds_table' => 'c_odds_1',
        ),
        'xsc' => array(
            'time_table' => 'c_opentime_7',
            'data_table' => 'c_auto_7',
            'odds_table' => 'c_odds_7',
        ),
        'xsc_1' => array(
            'time_table' => 'c_opentime_7',
            'data_table' => 'c_auto_7',
            'odds_table' => 'c_odds_7',
        ),
        'xjssc' => array(
            'time_table' => 'c_opentime_7',
            'data_table' => 'c_auto_7',
            'odds_table' => 'c_odds_7',
        ),
        'xjssc_1' => array(
            'time_table' => 'c_opentime_7',
            'data_table' => 'c_auto_7',
            'odds_table' => 'c_odds_7',
        ),
        'pk10' => array(
            'time_table' => 'c_opentime_3',
            'data_table' => 'c_auto_3',
            'odds_table' => 'c_odds_3',
        ),
        'pk10_1' => array(
            'time_table' => 'c_opentime_3',
            'data_table' => 'c_auto_3',
            'odds_table' => 'c_odds_3',
        ),
        'gxsf' => array(
            'time_table' => 'c_opentime_5',
            'data_table' => 'c_auto_5',
            'odds_table' => 'c_odds_5',
        ),
        'jsk3' => array(
            'time_table' => 'c_opentime_6',
            'data_table' => 'c_auto_6',
            'odds_table' => 'c_odds_6',
        ),
    );
    
    public function odds($type = 'cqssc'){
        if($type == 'xjssc'){
            $type = 'xsc';
        }

        $odds = new \app\logic\odds();
        $info = $odds->$type();
        $info = json_decode($info);
        
        //return $info;
        return ['status'=>0,'data'=>$info,];
    }
    
    /**
     * 获取
     * @param string $type
     * @return unknown
     */
    public function auto($type='cqssc')
    {
        $auto = new \app\logic\auto() ;
        $info = $auto->$type() ;
        $info = json_decode($info,true) ;

        foreach ($info['hms'] as $k => $v) {
            $info['hms'][$k] = str_replace('总和', '', $v) ;
        }

        //获取赔率相关数据
        if ($type == 'xjssc') {
            $type = 'xsc';
        }

        $odds     = new \app\logic\odds() ;
        $oddsInfo = json_decode($odds->$type(),true) ;

        $info['next_number'] = $oddsInfo['number'] ;
        $info['end_time']    = $oddsInfo['endtime'] ;

        $info['open_time']   = $oddsInfo['opentime'] ;
        unset($oddsInfo) ;

        $key = $type.'_odds_time'; //记录赔率更新时间戳缓存key
        $info['odds_time'] =  (@Cache::get($key)) ? Cache::get($key) : '' ;
        $key2 = 'hg_gfwf_types_time';
        $info['gfwf_time'] =  (@Cache::get($key2)) ? Cache::get($key2) : '' ;

        return ['status'=>0,'data'=>$info];
    }

    public function auto_six(){
        date_default_timezone_set('PRC');
        $lottery_time = time();
        $ctime = date('Y-m-d H:i:s',$lottery_time);
        $qs = db('c_auto_0') -> where('opentime','<=',$ctime)->where('endtime','>=',$ctime) -> order('id asc') -> find();
        if($qs){
            $qishu  = $qs['qishu'];
            $close  = strtotime($qs['endtime'])-$lottery_time;
        }else{
            $qishu  = -1;
            $close  = -1;
        }
        $rs = db('c_auto_0') -> where('ok',1)->order('id desc')->limit(1) -> find();
        $k_qi       = $rs['qishu'];
        $k_hm[]     = str_pad($rs['ball_1'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_2'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_3'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_4'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_5'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_6'],2,'0',STR_PAD_LEFT);
        $k_hm[]     = str_pad($rs['ball_7'],2,'0',STR_PAD_LEFT);

        
        include_once APP_PATH .'../common/lottery/auto_class.php';
        $sx[] = Get_ShengXiao($rs['ball_1']);
        $sx[] = Get_ShengXiao($rs['ball_2']);
        $sx[] = Get_ShengXiao($rs['ball_3']);
        $sx[] = Get_ShengXiao($rs['ball_4']);
        $sx[] = Get_ShengXiao($rs['ball_5']);
        $sx[] = Get_ShengXiao($rs['ball_6']);
        $sx[] = Get_ShengXiao($rs['ball_7']);

        $arr = array(   
            'number' => $qishu, 
            'close' => $close, 
            'k_number' => $k_qi,
            'k_hm' => $k_hm,
            'k_sx' => $sx,
        );  
        $arr['odds_time'] =  Cache::get('six_odds_time') ;

        return ['status'=>0,'data'=>$arr,];
    }

    public function odds_six_bak(){
        date_default_timezone_set("PRC");
        //开始读取赔率
        $sixodds = Cache::get('sixodds');
        if(!$sixodds){
            $s = 1;
            $data = db('c_odds_0')->order('id asc')->select();
            
            foreach ($data as $k => $odds){
                for($i = 1; $i < 87; $i++){
                    $list['ball'][$s][$i] = $odds['h'.$i] ?? 0;
                }
                $s++ ;
            }

            $sixodds = ['oddslist' => $list,];

            Cache::set('six_odds_time',time()) ;
            Cache::set('sixodds', $sixodds);
        }
        return ['status'=>0,'data'=>$sixodds,];
    }

    public function odds_six(){
        date_default_timezone_set("PRC");
        //开始读取赔率
        $sixodds = Cache::get('sixodds');
        if(!$sixodds){
            
            $odds_str = file_get_contents(APP_PATH.'../public/odds/6hc.txt');

            $sixodds = json_decode($odds_str);

            Cache::set('six_odds_time',time()) ;
            Cache::set('sixodds', $sixodds);
        }
        return ['status'=>0,'data'=>$sixodds,];
    }
    

    /**
     *  开奖历史记录
     *  @param   string $type
     *  @return  mixed
     */
    public function history()
    {
       $data = [] ; //数据
       try {
           include_once APP_PATH .'../common/lottery/auto_class.php' ;
           $t    = intval($this->request->param('t')) ; //天数
           $t    = ($t &&($t<7)) ? $t : 1             ; //默认一天
           $type = $this->request->param('type')      ; //类型
           $type = ($type) ? $type : 'cqssc'          ; //默认重庆时时彩
           $lottery_time = time() ;

           if ($type == 'xsc') { $gid = 'xjssc' ; }
           $table = $this->config[$type]['data_table'] ;

           $da   = date('Y-m-d H:i:s',$lottery_time) ;
           $tday = date("Ymd",$lottery_time-($t-1)*24*3600) ;

           $rows = db($table)->where('datetime','between',[date('Y-m-d 00:00:00',$lottery_time-($t-1)*24*3600),date('Y-m-d 23:59:59',$lottery_time-($t-1)*24*3600)])
               ->order("qishu desc")
               ->select() ;

           $history = new \app\logic\history() ;
           $data = $history->$type($rows);

       } catch (\Exception $e) {
       }
       return ['status'=>0,'data'=>$data,];
    }
    
    public function history_six()
    {
        include_once APP_PATH .'../common/lottery/auto_class.php';
   
        $list = db('c_auto_0')->where('ok',1)->order('id desc')->limit(50)->select();
        foreach ($list as $k => $v){
            $list[$k]['dx']     = Six_DaXiao($v['ball_7']);
            $list[$k]['ds']     = Six_DanShuang($v['ball_7']);
            $list[$k]['hsdx']   = Six_HeShuDaXiao($v['ball_7']);
            $list[$k]['hsds']   = Six_HeShuDanShuang($v['ball_7']);
            $list[$k]['wsdx']   = Six_WeiShuDaXiao($v['ball_7']);
            $list[$k]['ws']     = Six_WeiShu($v['ball_7']);
            $list[$k]['bs']     = Six_Bose($v['ball_7']);
            $list[$k]['sx']     = Get_ShengXiao($v['ball_7']);
            $list[$k]['zhdx'] = Six_ZongHeDaXiao($v['ball_1']+$v['ball_2']+$v['ball_3']+$v['ball_4']+$v['ball_5']+$v['ball_6']+$v['ball_7']);
            $list[$k]['zhds'] = Six_ZongHeDanShuang($v['ball_1']+$v['ball_2']+$v['ball_3']+$v['ball_4']+$v['ball_5']+$v['ball_6']+$v['ball_7']);
        }
        return ['status'=>0,'data'=>$list,];
    } 
}