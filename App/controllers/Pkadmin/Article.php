<?php

/**
 * ==========================================
 * Created by test.
 * Author: test <test@foxmail.com>
 * Date: 2016/12/1 00226
 * Time: 下午 2:21
 * Project: Pkadmin后台管理系统
 * Version: 1.0.0
 * Power: 后台文章管理控制器
 * ==========================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends Pkadmin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> library('pagination');
		//$this -> load -> library('Imgupload');
		$this -> load -> model('article_model', 'ac');
	}

	/**
	 * 文章管理首页
	 */
	public function index($offset = '') {
		$data = $this -> data;
		//配置分页信息
		$config['base_url'] = site_url('Pkadmin/Article/index/');
		$config['total_rows'] = $this -> ac -> get_article_count();
		$config['per_page'] = 10;
		//初始化分类页
		$this -> pagination -> initialize($config);
		//生成分页信息
		$data['pageinfo'] = $this -> pagination -> create_links();
		$article_list = $this -> ac -> get_article_list($config['per_page'], $offset);
		foreach ($article_list as $k => $v) {
			$catrgory = $this -> ac -> get_category_info($v['category_id']);
			$article_list[$k]['category_name'] = $catrgory['category_name'];
		}
		$data['article_list'] = $article_list;
		$this -> load -> view('article.html', $data);
	}

	/**
	 * 新增文章
	 */
	public function add() {
		$data = $this -> data;
		$data['category_list'] = $this -> ac -> get_category_list();
		$this -> load -> view('article_add.html', $data);
	}

	/**
	 * 修改文章
	 */
	public function edit($id) {
		$data = $this -> data;
		$data['category_list'] = $this -> ac -> get_category_list();
		$article = $this -> ac -> get_article_info($id);
		$arr =  json_decode($article['article_pic'], true);
        if (!empty($arr)) {
            foreach ($arr as $kk => $vv) {
                if (strstr($vv, 'http')){
                    $arr[$kk] = $vv;
                } else {
                    $arr[$kk] = base_url($vv);
                }
            }
        }
		$article['article_pic'] = $arr;
		$data['article'] = $article;
		$this -> load -> view('article_edit.html', $data);
	}

	/**
	 * 删除文章
	 */
	public function del($id) {
		$data = $this -> data;
		if ($this -> ac -> del_article($id)) {
			$this -> pk -> add_log('删除文章，ID：' . $id, $this -> ADMINISTRSTORS['admin_id'], $this -> ADMINISTRSTORS['username']);
			$success['msg'] = "删除文章操作成功！";
			$success['url'] = site_url("Pkadmin/Article/index");
			$success['wait'] = 3;
			$data['success'] = $success;
			$this -> load -> view('success.html', $data);
		} else {
			$error['msg'] = "删除文章操作失败！";
			$error['url'] = site_url("Pkadmin/Article/index");
			$error['wait'] = 3;
			$data['error'] = $error;
			$this -> load -> view('error.html', $data);
		}
	}

	/**
	 * 新增修改文章内容
	 */
	public function update() {
		$id = $this -> input -> post('id');
		$params['category_id'] = $this -> input -> post('category_id');
		$params['article_title'] = $this -> input -> post('article_title');
		$params['keywords'] = $this -> input -> post('keywords');
		$params['article_desc'] = $this -> input -> post('article_desc');
		$params['content'] = $this -> input -> post('content');
        $params['article_pic'] = $this -> input -> post('article_pic');
		$params['edit_time'] = time();
		if ($id) {
			//修改文章
			if ($this -> ac -> update_article($id, $params)) {
				$this -> pk -> add_log('修改文章：' . $params['article_title'], $this -> ADMINISTRSTORS['admin_id'], $this -> ADMINISTRSTORS['username']);
                $data['code']=0;
                $data['msg']="修改文章成功！";
            } else {
                $data['code']=-1;
                $data['msg']="修改文章失败！";
			}
		} else {
			//插入文章
			$params['issue_time'] = time();
			if ($this -> ac -> insert_article($params)) {
				$this -> pk -> add_log('新增文章：' . $params['article_title'], $this -> ADMINISTRSTORS['admin_id'], $this -> ADMINISTRSTORS['username']);
                $data['code']=0;
                $data['msg']="新增文章成功！";
			} else {
                $data['code']=-1;
                $data['msg']="新增文章失败！";
			}
		}
        header("Access-Control-Allow-Origin: * ");
        echo json_encode($data);
	}

	function upload(){
        $file = $_FILES['article_pic'];  //得到传输的数据,以数组的形式
        $size = $file['size'];
        $name = trim($file['name']);      //得到文件名称，以数组的形式
        $upload_path = "Data/upload/article_pic"; //上传文件的存放路径//当前位置
        $type = strtolower(substr($name,strrpos($name,'.')+1));//得到文件类型，并且都转化成小写
        $allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
        $url = "";
        if ($size > (10 * 1024 *1024)) {
            $code = -1 ;
            $msg = "图片大小已超过10M!";
        } elseif (!in_array($type, $allow_type)){//把非法格式的图片去除
            $code = -1 ;
            $msg = "图片类型不合法!";
        } elseif (move_uploaded_file($file['tmp_name'],$upload_path.time().$name)){
            $code = 0;
            $msg = "图片上传成功!";
            $url = base_url($upload_path.time().$name);
        } else{
            $code = -1 ;
            $msg = "图片上传失败!";
        }
        //print_r($file);
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['url'] = $url;
        header("Access-Control-Allow-Origin: * ");
        echo json_encode($data);
    }

}
