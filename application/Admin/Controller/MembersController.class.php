<?php
	//会员处理页面,所涉及的验证问题今后维护添加，比如邮箱，电话，还有从表单接受到的数据（id）等；由靳思远（以后简称J_SY）开发20
//2015年4月1日 王志新优化M方法调用以及分页等功能14-10.3
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MembersController extends AdminbaseController {
	
    protected $Members_model;
    
    function _initialize() {
        parent::_initialize();
        $this->members_model = D("Approve");
    }
//以下有的使用属性名，有的使用原始的方法创建的对象，以后优化！
    public function addm(){

		$this->display();
	}

	public function addact(){
		echo "<meta http-equiv='Content-Type' content='text/html;charset='utf8'/>";
		$data = $_POST;
        $id = $_POST['hyecat'];
        $hname = M("Hyecat") -> where("id=$id")->find();
        $data['hangye'] = $hname['hname']; 
		$data['mlogo'] = $this -> proimg();
		$data['createtime'] = date("Y-m-d H:i:s");
		if(M("Approve")->add($data)){
			$this->success("添加成功!");
		}else{
			$this->error("添加失败!");
		}

	}

	public function memberslist(){
		$mem_list = M('Approve');
		$count = $mem_list->count();
    	$page = $this->page($count, 20);
    	$lists = $mem_list
    	->where("ustatus=3")
    	->order("createtime DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
		$this -> display();
    
	}

    public function edit(){

        $id = $_GET['id'];
        $mm = M('Approve')->where("id=$id")->find();
        $this->assign('mm',$mm);
        $this->display();
    }

    public function update(){

        $id = $_POST['id'];
        $data = $_POST;
        $hid = $_POST['hyecat'];
        $hname = M("Hyecat") -> where("id=$hid")->find();
        $data['hangye'] = $hname['hname']; 
        $data['mlogo'] = $this->proimg();
        $data['updatetime'] = date("Y-m-d H:i:s");
        if(M("Approve")->where("id=$id")->save($data)){
            $this->success("修改成功!");
        }else{
            $this->error("修改失败!");
        }
    }

    public function delete(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if(M('Approve')->where("id=$id")->delete()){
                $this -> success("删除成功!");
            }else{
                $this -> error("删除失败!");
            }
        }else{
            $this -> error("参数错误!");
        }
    }

    public function addwuf(){
        $m = M("Users");
        $mlist = $m -> select();

        $this -> assign('mlist',$mlist);
        $this->display();
    }

    public function addimgact(){

        $data = $_POST;
        $data['simg'] = $this -> proimg();
        $data['createtime'] = date("Y-m-d H:i:s");
        if(M("Mbersimg")->add($data)){
            $this->success('添加成功!');
        }else{
            $this->error("添加失败!");
        }
    }

    public function editsimg(){
        $id = $_GET['id'];
        $ls = M("Mbersimg")->where("id=$id")->find();
        $m = M('Approve');
        $mlist = $m -> select();

        $this -> assign('mlist',$mlist);
        $this->assign('ls',$ls);
        $this->display();
    }

    public function wuflist(){

		$mem_list = M('Mbersimg');
		$count = $mem_list->count();
    	$page = $this->page($count,20);
    	$lists = $mem_list
    	->where()
    	->order("createtime DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
        $this->display();
    }

    public function updatesimg(){

        $data = $_POST;
        $data['simg'] = $this->proimg();
        $data['updatetime']=date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if(M("Mbersimg")->where("id=$id")->save($data)){
            $this->success("修改成功!");
        }else{
            $this->error("修改失败!");
        }
    }

    public function deletesimg(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if(M("Mbersimg")->where("id=$id")->delete()){
                $this->success("删除成功!");
            }else{
                $this->error("删除失败!");
            }
        }else{
            $this->error("参数错误!");
        }

    }

    public function toaudit(){
		$toa_list = M('Approve');
		$count = $toa_list->count();
    	$page = $this->page($count, 20);
    	$lists = $toa_list
    	->where("ustatus=2")
    	->order("createtime DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
        $this->display();
    }

    //查看提交审核的信息
    public function toview(){
        $id = intval($_GET['id']);
        $msg = M("Approve")->where("id=$id")->find();
        $this->assign('msg',$msg);
        $this->display();
    }

    //目前approve数据表里的utype字段暂无作用，ustatus字段表示是否确定会员通过与否。
    function passaudit(){
        $id = intval($_GET['id']);
        $mid = intval($_GET['mid']);
        if($id){
            $rst = M("Users")->where(array("id"=>$mid,"user_type"=>2))->setField("user_status","3");
            $rst1 = M("Approve")->where(array("id"=>$id,"utype"=>2))->setField("ustatus","3");
            if($rst&$rst1){
                $this->success('通过审核!');
            }else{
                $this->error('审核失败!');
            }
        }else{
            $this->error("参数错误!");
        }
    }

    public function cancelaudit(){
        $id = intval($_GET['id']);
        $mid = intval($_GET['mid']);
        if($id){
            $rst=M("Users")->where(array("id"=>$mid,"user_type"=>"2"))->setField("user_status","1");
            $rst1=M("Approve")->where(array("id"=>$id,"utype"=>"2"))->setField("ustatus","2");
            if($rst&$rst1){
                $this->success("操作成功！");
            }else{
                $this->error("操作失败！");
            }
        }else{
            $this->error("参数错误!");
        }

    }

    public function tuij(){
        $mid = intval($_GET['mid']);
        if($mid){
            $rst = $this->members_model->where(array("mid"=>$mid))->setField("tuij","1");
            if($rst){
                $this->success("操作成功！");
            }else{
                $this->error("操作失败！");
            }
        }else{
            $this->error("参数错误！");
        }
    }

	public function proimg() {
        if (!is_uploaded_file($_FILES["img"]['tmp_name'])) {
            return '';
        }

        $path = SITE_PATH . '__UPLOAD__shop/';
        $tp = array("image/gif", "image/pjpeg", "image/jpeg", "image/png", "image/jpg");


        if (in_array($_FILES["img"]["type"], $tp)) {

            if (!in_array($_FILES["img"]["type"], $tp)) {
                return '';
            }
            $filetype = $_FILES['img']['type'];
            if ($filetype == 'image/png') {
                $type = '.png';
            }
            if ($filetype == 'image/jpeg') {
                $type = '.jpg';
            }
            if ($filetype == 'image/jpg') {
                $type = '.jpg';
            }
            if ($filetype == 'image/pjpeg') {
                $type = '.jpg';
            }
            if ($filetype == 'image/gif') {
                $type = '.gif';
            }

            $today = date('YmdHis');
            $file2 = $path . $today . $type;
            $img = '__UPLOAD__shop/' . $today . $type; 

            $result = move_uploaded_file($_FILES["img"]["tmp_name"], $file2);
            return $img;
        } else {
            return '';
        }
    }
}