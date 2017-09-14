<?php
namespace Home\Controller;
use Think\Controller;

class CityLianController extends Controller{
	public function index(){
		$this->display();
	}
	public function city_lian(){
        $regionList = M('Mall_region')->where(['parent_id'=>I('request.parent_id')])->select();
        $this->ajaxReturn(['error'=>0,'data'=>$regionList?$regionList:[]]);
            
		// $this->display();
	}

}
