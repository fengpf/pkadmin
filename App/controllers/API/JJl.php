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
     * 获取分类列表
     * @return mixeds
     */
    public function catrgory()
    {
        $catrgory = $this -> ac -> get_category_list();
        header("Access-Control-Allow-Origin: * ");
        echo json_encode($catrgory);
    }

    /**
     * @param int cid 文章分类id
     */
    public function articles() {
        $cid = isset($_GET['cid']) ? $_GET['cid'] : 1;
        $article_list = $this -> ac -> get_article_list_of_category($cid);
        foreach ($article_list as $k => $v) {
            $catrgory = $this -> ac -> get_category_info($v['category_id']);
            $article_list[$k]['category_name'] = $catrgory['category_name'];
            $arr =  json_decode($v['article_pic'], true);
            if (!empty($arr)) {
                foreach ($arr as $kk => $vv) {
                    if (strstr($vv, 'http')){
                        $arr[$kk] = $vv;
                    } else {
                        $arr[$kk] = base_url($vv);
                    }
                }
            }
            $article_list[$k]['article_pic'] = $arr;
        }
        header("Access-Control-Allow-Origin: * ");
        echo json_encode($article_list);
    }

    /**
     * 获取文章详情
     * @return mixeds
     */
    public function detail()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
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
        header("Access-Control-Allow-Origin: * ");
        echo json_encode($article);
    }



}
