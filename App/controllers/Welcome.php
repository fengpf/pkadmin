<?php

/**
 * ==========================================
 * Created by test.
 * Author: test <test@foxmail.com>
 * Date: 2017/07/05 0039
 * Time: 上午 11:13
 * Project: Pkadmin后台管理系统
 * Version: 1.0.0
 * Power: PKDMIN系统欢迎使用控制器
 * ==========================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index() {
        redirect('Pkadmin/Login/index');
		//$this -> load -> view('welcome.html');
	}

}
