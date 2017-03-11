<?php
//2015年4月1日 王志新优化M方法调用以及分页等功能
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MessageController extends AdminbaseController {

	//后台消息类
	public function add(){

		$this->display();
	} 

	public function addact(){

		$data = $_POST;
		$data['createtime']=date('Y-m-d H:i:s');
		if(M('Message')->add($data)){
			$this -> success('添加短消息成功!');
		}else{
			$this -> error('添加短消息失败!');
		}
	}

	public function messagelist(){
		$mes_list = M('Message');
		$count = $mes_list->count();
    	$page = $this->page($count, 20);
    	$lists = $mes_list
    	->where()
    	->order("createtime DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
		$this->display();
	}
	
	
	
	public function edit(){
		$id = $_GET['id'];
		$msg = M('Message')->where("id=$id")->find();
		$this -> assign('msg',$msg);
		$this->display();

	}

	public function update(){

		$data = $_POST;
		$data['updatetime'] = date('Y-m-d H:i:s');
		if(M('Message')->save($data)){
			$this -> success('修改成功!');
		}else{
			$this -> error('修改失败!');
		}
	}

	public function delete(){

		$id = $_GET['id'];
		if(M('Message')->where("id=$id")->delete()){
			$this -> success('删除成功!');
		}else{
			$this -> error('删除失败!');
		}
	}
}