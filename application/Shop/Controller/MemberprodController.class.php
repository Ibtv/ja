<?php

//会员产品处理页面,商城首页面

namespace Shop\Controller;
use Common\Controller\HomeBaseController;
class MemberprodController extends HomeBaseController {



//以后整合到一个二维数组，现在不做优化；由靳思远（以后简称J_SY）开发2014-10.5

//前端模板输出头部没有放入Public内，待优化！

	public function index(){

		$this -> display(":index");

	}

	public function member(){

		$this->display(":member");

	}



	public function product(){

		$this->display(":product");

	}



	public function memberinfo(){

		$id = $_GET['id'];

		$m =$this->approve_obj;

		if($id){

		$mb = $m -> where("id=$id")->find();

		}elseif($_GET['mn']){

		$mn = $_GET['mn'];

		$mb = $m -> where("mname='$mn'") -> find();	

		}

		$mm = $mb['mid'];
		$mpro = M("Produce")->where("mid='$mm'")->select();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);

		$this->assign('mb',$mb);

		$this->assign('mpro',$mpro);

		$this->display(":memberinfo");

	}



	public function productinfo(){

		$p = M("Produce");
		$id = $_GET['id'];
		$pro = $p -> where("id=$id")->find();
		$tuiprod = $p -> where("status=1")-> limit(5) ->select();
		$mn = $pro['mname'];
		$mns = M("Approve")->where("mname='$mn'")->find();
		$tuimessage=M("Message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('tuiprod',$tuiprod);

		$this->assign('pro',$pro);

		$this->assign('mns',$mns);

		$this->display(":productinfo");

	}



	public function activity(){

		$m = M("Mbersimg");

		$hd = $m -> order("id desc")->select();

		$tuimessage=M("Message")->where("status=1")->select();



		$this->assign('tuimessage',$tuimessage);

		$this->assign('hd',$hd);

		$this->display(":activity");

	}
 


	public function activityinfo(){

		$id = $_GET['id'];

		$m = M("Mbersimg");

		$hd = $m -> where("id=$id")->find();

		$tuimessage=M("Message")->where("status=1")->select();


		$latestnews = M("Message")->order("id desc")->limit(6)->select();
		$activities = $m->order("id desc")->limit(6)->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('latestnews',$latestnews);
		$this->assign('activities',$activities);

		$this->assign('hd',$hd);

		$this->display(":activityinfo");

	}



	public function info(){

		$m = M("Message");

		$mls = $m -> order("id desc") -> select();

		$tuimsg = $m -> where("status=1") ->limit(6) -> select();

		$tuimember = M("Approve") -> where("tuij=1") -> select();

		$tuiprod = M("Produce") -> where("status=1") -> select();



		$this->assign('mls',$mls);

		$this->assign("tuimessage",$tuimsg);

		$this->assign("tuimember",$tuimember);

		$this->assign("tuiprod",$tuiprod);

		$this->display(":info");		

	}



	public function infoinfo(){

		$id = $_GET['id'];

		$m = M("Message");

		$sm = $m -> where("id=$id") -> find();

		$tuimessage = $m->where("status=1")->select();
		$latestnews = $m->order("id desc")->limit(6)->select();
		$activities = M("Mbersimg")->order("id desc")->limit(6)->select();


		$this->assign('tuimessage',$tuimessage);
		$this->assign('latestnews',$latestnews);
		$this->assign('activities',$activities);

		$this->assign('sm',$sm);

		$this->display(":infoinfo");

	}



	public function search(){

		$typ = $_POST['type'];

		if($typ==0){

			$pname = $_POST['sear'];

			$m = M("Produce");

			$where['pname'] = array('like','%'.$pname.'%');

			$search = $m -> where($where) -> select();
			
			//$search['stype'] = "productinfo";
			$arr = array();
			$arr['types'] = 'productinfo';
			if(empty($search)){

				$arr['name']="没有搜索到符合条件的结果!";

			}
			$this->assign('arr',$arr);

		}else{

			$mname = $_POST['sear'];

			$m = M("Approve");

			$where['mname'] = array('like','%' .$mname. '%');

			$search = $m -> where($where) -> select();

			//$search['stype'] = "memberinfo";
			
			$tuimember = $m -> where("tuij=1")->select();

			$this->assign("tuimsg",$tuimember);

			$arr = array();
			$arr['types'] = 'memberinfo';
			if(empty($search)){

				$arr['name']='没有搜索到符合条件的结果!';

			}
			$this->assign('arr',$arr);

		}

		$n = M("Message");

		$tuimg = $n -> where("status=1")->select();

		$this->assign('tuimessage',$tuimg);

		$this->assign('tuimsg',$tuimember);

		$this->assign("search",$search);

		$this->display(":search");

	}

}
