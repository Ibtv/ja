<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class UserController extends AdminbaseController{
	protected $users_obj,$role_obj,$users_obj_cmf,$users_obj_tw,$users_obj_en,$users_obj_ar,$users_obj_fr,$users_obj_es,$users_obj_ru,$users_obj_pt,$users_obj_de,$users_obj_kr,$users_obj_it,$users_obj_ja;
	
	function _initialize() {
		parent::_initialize();
		$this->users_obj = D("Common/Users");
		$this->users_obj_cmf = D("Common/ibtv_cmf.Users","i_");
		$this->users_obj_tw = D("Common/ibtv_tw.Users","i_");
		$this->users_obj_en = D("Common/ibtv_en.Users","i_");
		$this->users_obj_ar = D("Common/ibtv_ar.Users","i_");
		$this->users_obj_fr = D("Common/ibtv_fr.Users","i_");
		$this->users_obj_es = D("Common/ibtv_es.Users","i_");
		$this->users_obj_ru = D("Common/ibtv_ru.Users","i_");
		$this->users_obj_pt = D("Common/ibtv_pt.Users","i_");
		$this->users_obj_de = D("Common/ibtv_de.Users","i_");
		$this->users_obj_kr = D("Common/ibtv_kr.Users","i_");
		$this->users_obj_it = D("Common/ibtv_it.Users","i_");
		$this->users_obj_ja = D("Common/ibtv_ja.Users","i_");
		$this->role_obj = D("Common/Role");
	}
	function index(){
		$count=$this->users_obj->where(array("user_type"=>1))->count();
		$page = $this->page($count, 20);
		$users = $this->users_obj
		->where(array("user_type"=>1))
		->order("user_status DESC")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
		$roles_src=$this->role_obj->select();
		$roles=array();
		foreach ($roles_src as $r){
			$roleid=$r['id'];
			$roles["$roleid"]=$r;
		}
		$this->assign("page", $page->show('Admin'));
		$this->assign("roles",$roles);
		$this->assign("users",$users);
		$this->display();
	}
	
	
	function add(){
		$roles=$this->role_obj->where("status=1")->order("id desc")->select();
		$this->assign("roles",$roles);
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
			if(!empty($_POST['role_id']) && is_array($_POST['role_id'])){
				$role_ids=$_POST['role_id'];
				unset($_POST['role_id']);
				$cmf = $this->users_obj_cmf->create();
				$tw = $this->users_obj_tw->create();
				$en = $this->users_obj_en->create();
				$ar = $this->users_obj_ar->create();
				$fr = $this->users_obj_fr->create();
				$es = $this->users_obj_es->create();
				$ru = $this->users_obj_ru->create();
				$pt = $this->users_obj_pt->create();
				$de = $this->users_obj_de->create();
				$kr = $this->users_obj_kr->create();
				$it = $this->users_obj_it->create();
				$ja = $this->users_obj_ja->create();
				if ($this->users_obj->create() && $cmf && $tw && $en && $ar && $fr && $es && $ru && $pt && $de && $kr && $it && $ja) {
					if ($this->users_obj->add()!==false && 
					$this->users_obj_cmf->add()!==false && 
					$this->users_obj_tw->add()!==false && 
					$this->users_obj_en->add()!==false && 
					$this->users_obj_ar->add()!==false && 
					$this->users_obj_fr->add()!==false && 
					$this->users_obj_es->add()!==false && 
					$this->users_obj_ru->add()!==false && 
					$this->users_obj_pt->add()!==false && 
					$this->users_obj_de->add()!==false && 
					$this->users_obj_kr->add()!==false && 
					$this->users_obj_it->add()!==false && 
					$this->users_obj_ja->add()!==false) {
						$role_user_model=M("RoleUser");
						foreach ($role_ids as $role_id){
							$role_user_model->add(array("role_id"=>$role_id,"user_id"=>$result));
						}
						$this->success("添加成功！", U("user/index"));
					} else {
						$this->error("添加失败！");
					}
				} else {
					$this->error($this->users_obj->getError());
				}
			}else{
				$this->error("请为此用户指定角色！");
			}
			
		}
	}
	
	
	function edit(){
		$id= intval(I("get.id"));
		$roles=$this->role_obj->where("status=1")->order("id desc")->select();
		$this->assign("roles",$roles);
		$role_user_model=M("RoleUser");
		$role_ids=$role_user_model->where(array("user_id"=>$id))->getField("role_id",true);
		$this->assign("role_ids",$role_ids);
			
		$user=$this->users_obj->where(array("id"=>$id))->find();
		$this->assign($user);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if(!empty($_POST['role_id']) && is_array($_POST['role_id'])){
				if(empty($_POST['user_pass'])){
					unset($_POST['user_pass']);
				}
				$role_ids=$_POST['role_id'];
				unset($_POST['role_id']);
				$cmf = $this->users_obj_cmf->create();
				$tw = $this->users_obj_tw->create();
				$en = $this->users_obj_en->create();
				$ar = $this->users_obj_ar->create();
				$fr = $this->users_obj_fr->create();
				$es = $this->users_obj_es->create();
				$ru = $this->users_obj_ru->create();
				$pt = $this->users_obj_pt->create();
				$de = $this->users_obj_de->create();
				$kr = $this->users_obj_kr->create();
				$it = $this->users_obj_it->create();
				$ja = $this->users_obj_ja->create();
				if ($this->users_obj->create() && $cmf && $tw && $en && $ar && $fr && $es && $ru && $pt && $de && $kr && $it && $ja) {
					if ($this->users_obj->save()!==false && 
						$this->users_obj_cmf->save()!==false && 
						$this->users_obj_tw->save()!==false && 
						$this->users_obj_en->save()!==false && 
						$this->users_obj_ar->save()!==false && 
						$this->users_obj_fr->save()!==false && 
						$this->users_obj_es->save()!==false && 
						$this->users_obj_ru->save()!==false && 
						$this->users_obj_pt->save()!==false && 
						$this->users_obj_de->save()!==false && 
						$this->users_obj_kr->save()!==false && 
						$this->users_obj_it->save()!==false && 
						$this->users_obj_ja->save()!==false){
						$uid=intval($_POST['id']);
						$role_user_model=M("RoleUser");
						$role_user_model->where(array("user_id"=>$uid))->delete();
						foreach ($role_ids as $role_id){
							$role_user_model->add(array("role_id"=>$role_id,"user_id"=>$uid));
						}
						$this->success("保存成功！");
					} else {
						$this->error("保存失败！");
					}
				} else {
					$this->error($this->users_obj->getError());
				}
			}else{
				$this->error("请为此用户指定角色！");
			}
			
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = intval(I("get.id"));
		if($id==1){
			$this->error("最高管理员不能删除！");
		}
		
		if ($this->users_obj->where("id=$id")->delete()!==false &&
		 $this->users_obj_cmf->where("id=$id")->delete()!==false &&
		 $this->users_obj_tw->where("id=$id")->delete()!==false &&
		 $this->users_obj_en->where("id=$id")->delete()!==false && 
		 $this->users_obj_ar->where("id=$id")->delete()!==false && 
		 $this->users_obj_fr->where("id=$id")->delete()!==false && 
		 $this->users_obj_es->where("id=$id")->delete()!==false && 
		 $this->users_obj_ru->where("id=$id")->delete()!==false && 
		 $this->users_obj_pt->where("id=$id")->delete()!==false && 
		 $this->users_obj_de->where("id=$id")->delete()!==false &&
		 $this->users_obj_kr->where("id=$id")->delete()!==false &&
		 $this->users_obj_it->where("id=$id")->delete()!==false &&
		 $this->users_obj_ja->where("id=$id")->delete()!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	
	function userinfo(){
		$id=get_current_admin_id();
		$user=$this->users_obj->where(array("id"=>$id))->find();
		$this->assign($user);
		$this->display();
	}
	
	function userinfo_post(){
		if (IS_POST) {
			$_POST['id']=get_current_admin_id();
			$create_result=$this->users_obj
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$cmf=$this->users_obj_cmf
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$tw=$this->users_obj_tw
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$en=$this->users_obj_en
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$ar=$this->users_obj_ar
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$fr=$this->users_obj_fr
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$es=$this->users_obj_es
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$ru=$this->users_obj_ru
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$pt=$this->users_obj_pt
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$de=$this->users_obj_de
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$kr=$this->users_obj_kr
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$it=$this->users_obj_it
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() &&
			$ja=$this->users_obj_ja
			->field("user_login,user_email,last_login_ip,last_login_time,create_time,user_activation_key,user_status,role_id,score,user_type",true)//排除相关字段
			->create() ;
			if ($create_result && $cmf && $tw && $en && $ar && $fr && $es && $ru && $pt && $de && $kr && $it && $ja) {
				if ($this->users_obj->save()!==false && 
					$this->users_obj_cmf->save()!==false && 
					$this->users_obj_tw->save()!==false && 
					$this->users_obj_en->save()!==false && 
					$this->users_obj_ar->save()!==false && 
					$this->users_obj_fr->save()!==false && 
					$this->users_obj_es->save()!==false && 
					$this->users_obj_ru->save()!==false && 
					$this->users_obj_pt->save()!==false && 
					$this->users_obj_de->save()!==false && 
					$this->users_obj_kr->save()!==false && 
					$this->users_obj_it->save()!==false && 
					$this->users_obj_ja->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_obj->getError());
			}
		}
	}
	
	    function ban(){
        $id=intval($_GET['id']);
    	if ($id) {
    		$rst = $this->users_obj ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$cmf = $this->users_obj_cmf ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$tw = $this->users_obj_tw ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$en = $this->users_obj_en ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$ar = $this->users_obj_ar ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$fr = $this->users_obj_fr ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$es = $this->users_obj_es ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$ru = $this->users_obj_ru ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$pt = $this->users_obj_pt ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$de = $this->users_obj_de ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$kr = $this->users_obj_kr ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$it = $this->users_obj_it ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		$ja = $this->users_obj_ja ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','0');
    		if ($rst && $cmf && $tw && $en && $ar && $fr && $es && $ru && $pt && $de && $kr && $it && $ja ) {
    			$this->success("管理员停用成功！", U("user/index"));
    		} else {
    			$this->error('管理员停用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    
    function cancelban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = $this->users_obj ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$cmf = $this->users_obj_cmf ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$tw = $this->users_obj_tw ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$en = $this->users_obj_en ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$ar = $this->users_obj_ar ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$fr = $this->users_obj_fr ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$es = $this->users_obj_es ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$ru = $this->users_obj_ru ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$pt = $this->users_obj_pt ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$de = $this->users_obj_de ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$kr = $this->users_obj_kr ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$it = $this->users_obj_it ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		$ja = $this->users_obj_ja ->where(array("id"=>$id,"user_type"=>1))->setField('user_status','1');
    		if ($rst && $cmf && $tw && $en && $ar && $fr && $es && $ru && $pt && $de && $kr && $it && $ja)  {
    			$this->success("管理员启用成功！", U("user/index"));
    		} else {
    			$this->error('管理员启用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
	
	
	
}