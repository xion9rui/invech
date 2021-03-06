<?php
namespace app\common\model\admin;
use app\common\model\Apply;
use app\common\model\ManualMoney;
use app\common\model\BonusFlow;
use app\common\model\Bonus;
use app\common\model\Member;
use app\common\model\Config;

trait BasicTrait
{

    public function agree_audit(Apply $apply,$remark=''){
        return $apply->agree($remark,$this);
    }
    public function deny_audit(Apply $apply,$remark=''){
        return $apply->deny($remark,$this);
    }

    public function manual_money(){

		$params = request()->param();
    	$validate = validate('Manual')->scene('money');
    	if(!$validate->check($params)){
    		throw new \Exception($validate->getError());
    	}
    	$username = input('username/s');
    	$bonus_id = input('bonus_id/i');
    	$amount = floatval(input('amount'));
    	$remark = input('remark');

    	$user = Member::getByIdOrName($username);
    	if(!$user){
    		throw new \Exception('用户不存在!');
    	}

		if($bonus_id > 0){
			return $this->manual_bonus_money($user,$bonus_id,$amount,$remark);
		}else{
			return $this->manual_deposit_money($user,$bonus_id,$amount,$remark);
		}

    }    

    private function manual_bonus_money($user,$bonus_id,$amount,$remark){

    	return transaction(function() use ($user,$bonus_id,$amount,$remark){
			$bonus = Bonus::get($bonus_id);
			if(!$bonus){
				throw new \Exception('红利不存在!');
			}
			$flow = BonusFlow::create([
	            'uid'   =>  $user->uid,
	            'bonus_id' => $bonus->id,               
	            'amount'   => $amount,
	            'remark'   => $bonus->desc
	        ]);
			if(!$flow){
				throw new \Exception('红利流水创建失败!');
			}

			$user->incBalance($amount,'bonus',$flow->id,$bonus->desc);

	        if($bonus->is_audit){
	            $betFlowRate = empty($bonus->betFlowRate)?Config::getByName('betFlowRate'):$bonus->betFlowRate;
	            $audit = $betFlowRate * $amount;
	            $user->incAuditFlow($audit);
	        }

	        $manual   =   ManualMoney::create([
	        	'uid'	=>	$user->uid,
	        	'amount' => $amount,
	        	'remark' => $remark,
	        	'bonus_id' => $bonus_id,
	        	'bonus_flow_id' => $flow->id,
	        	'opt_uid' => $this->id,
	        ]);

	        return $flow;
    	});

    }
    
    private function manual_deposit_money($user,$bonus_id,$amount,$remark){

		return transaction(function() use ($user,$bonus_id,$amount,$remark){
			if(!in_array($bonus_id,[-1,0])){
				throw new \Exception('请选择存款或扣款!');
			}

	        $manual   =   ManualMoney::create([
	        	'uid'	=>	$user->uid,
	        	'amount' => $amount,
	        	'remark' => $remark,
	        	'bonus_id' => $bonus_id,
	        	'bonus_flow_id' => 0,
	        	'opt_uid' => $this->id,
	        ]);

	        if($bonus_id == -1){//扣款
				$user->decBalance($amount,'manual_withdraw',$manual->id,'手动扣款');
	        }else{
	        	$user->incBalance($amount,'manual_deposit',$manual->id,'手动存款');
		        if($audit_manual = Config::getByName('auditManual')){
		            $betFlowRate = Config::getByName('betFlowRate');
		            $audit = $betFlowRate * $amount;
		            $user->incAuditFlow($audit);
		        }       	
	        }
		});

    }

}
