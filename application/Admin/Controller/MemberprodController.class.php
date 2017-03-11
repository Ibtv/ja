<?php
//会员产品处理页面
namespace Admin\Controller;
use Common\Controller\HomeBaseController;
class MemberprodController extends HomeBaseController {

//以后整合到一个二维数组，现在不做优化；由靳思远（以后简称J_SY）开发2014-10.5
//前端模板输出头部没有放入Public内，待优化！
//2015年4月1日 王志新优化M方法调用以及分页等功能
	public function more(){

		$mb = M('Approve');
		$this -> display(":index");
	}

	public function all(){

		$mm = M('Approve');
		$allm = $mm->select();
		$tuimember = $mm->where("status=1")->select();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('allm',$allm);
		$this->assign('tuimember',$tuimember);
		$this->display(":all");
	}

	public function allprod(){

		$pro = M("Produce");
		$allprod = $pro->select();
		$tuiprod = $pro -> where("status=1")->limit(6)->select();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('allprod',$allprod);
		$this->assign('tuiprod',$tuiprod);
		$this->display(":allprod");
	}

	public function memberinfo(){
		$id = $_GET['id'];
		$m = M("Approve");
		if($id){
		$mb = $m -> where("id=$id")->find();
		}elseif($_GET['mn']){
		$mn = $_GET['mn'];
		$mb = $m -> where("mname='$mn'") -> find();	
		}

		$mm = $mb['mname'];
		$mpro = M("Produce")->where("mname='$mm'")->select();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('mb',$mb);
		$this->assign('mpro',$mpro);
		$this->display(":memberinfo");
	}

	public function productinfo(){
		$id = $_GET['id'];
		$pro = M("Produce")->where("id=$id")->find();
		$mn = $pro['mname'];
		$mns = M("Approve")->where("mname='$mn'")->find();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('pro',$pro);
		$this->assign('mns',$mns);
		$this->display(":productinfo");
	}

	public function activity(){
		$m = M("mbersimg");
		$hd = $m -> order("id desc")->select();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('hd',$hd); 
		$this->display(":activity");
	}

	public function activityinfo(){
		$id = $_GET['id'];
		$m = M("mbersimg");
		$hd = $m -> where("id=$id")->find();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('hd',$hd);
		$this->display(":activityinfo");
	}

	public function allmsg(){
		$m = M("Message");
		$mls = $m -> order("id desc") -> select();
		$tuimsg = $m -> where("status=1") ->limit(6) -> select();
		$tuimember = M("Approve") -> where("status=1") -> select();
		$tuiprod = M("Produce") -> where("status=1") -> select();

		$this->assign('mls',$mls);
		$this->assign("tuimessage",$tuimsg);
		$this->assign("tuimember",$tuimember);
		$this->assign("tuiprod",$tuiprod);
		$this->display(":allmsg");		
	}

	public function infoinfo(){
		$id = $_GET['id'];
		$m = M("Message");
		$sm = $m -> where("id=$id") -> find();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('sm',$sm);
		$this->display(":infoinfo");
	}

	public function search(){
		
		$typ = $_POST['type'];
		if($typ ==0){
			$pname = $_POST['sear'];
			$m = M("Produce");
			$where['pname'] = array('like','%'.$pname.'%');
			$search = $m -> where('"pname" like %$pname%') -> select();
			if(empty($search)){
				$arr['name']="没有搜索到符合条件的结果!";
				$this->assign('arr',$arr);
			}
			
		}elseif($typ==1){
			$mname = $_POST['sear'];
			$m = M("Approve");
			$where['mname'] = array('like','%'.$mname.'%');
			$search = $m -> where($where) -> select();
			$tuimember = $m -> where("status=1")->select();
			$this->assign("tuimsg",$tuimember);
			if(empty($search)){
				$arr['name']='没有搜索到符合条件的结果!';
				$this->assign('arr',$arr);
			}
		}
		$n = M("Message");
		$tuimg = $n -> where("status=1")->select();

		$this->assign('tuimessage',$tuimg);
		$this->assign('tuimsg',$tuimember);
		$this->assign("search",$search);
		$this->display(":search");
	}
}