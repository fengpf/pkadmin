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

class JJl extends API_Controller {

    public function __construct() {
        parent::__construct();
        $this -> load -> library('pagination');
        $this -> load -> model('article_model', 'ac');
    }

    /**
     * Pkadmin 前台 api action
     * @param int $offset 偏移量，用于分页
     */
    public function index() {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $data = $this -> data;
        //配置分页信息
        $config['base_url'] = site_url('API/JJl/index/');
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
            $article_list[$k]['article_pic'] = base_url($v['article_pic']);
        }
        $data['article_list'] = $article_list;
        echo json_encode($data);
    }

}
