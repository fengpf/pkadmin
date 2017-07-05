<?php

/**
 * ==========================================
 * Created by test.
 * Author: test <test@foxmail.com>
 * Date: 2017/07/05
 * Time: 上午 9:19
 * Project: Pkadmin后台管理系统
 * Version: 1.0.0
 * Power:  加载器扩展
 * ==========================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PK_Loader extends CI_Loader {

	/**
	 * 设置前台视图路径
	 */
	public function set_home_view_dir() {
		$this -> _ci_view_paths = array(APPPATH . HOME_VIEW_DIR => TRUE);
	}

	/**
	 * 设置后台视图路径
	 */
	public function set_admin_view_dir() {
		$this -> _ci_view_paths = array(APPPATH . ADMIN_VIEW_DIR => TRUE);
	}

}
