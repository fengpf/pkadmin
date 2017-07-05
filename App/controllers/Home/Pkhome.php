<?php

/**
 * ==========================================
 * Created by test.
 * Author: test <test@foxmail.com>
 * Date: 2017/07/05
 * Time: 上午 9:10
 * Project: Pkadmin后台管理系统
 * Version: 1.0.0
 * Power:  前台首页控制器
 * ==========================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Pkhome extends Home_Controller {

	public function index() {
		$this -> load -> view('home.html');
	}

}
