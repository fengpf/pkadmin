# 后端接口

## 导航

<div class="toc">
<ul>
    <li><a href="#版本">版本</a></li>
    <li><a href="#说明">说明</a></li>
    <li><a href="#协议约定">协议约定</a></li>
    <li><a href="#公共字段">公共字段</a></li>
    <li><a href="#接口详情">接口详情</a>
        <ol><h4>接口</h1>
            <li><a href="#获取文章列表">获取文章列表</a></li>
            <li><a href="#获取文章详情">获取文章详情</a></li>
        </ol>
    </li>
</ul>
</div>


## 版本

| 版本        | 时间     |  备注            |
| --------    | -----:   | :---------:      |
| v1.0.0      | 2017.07.25 |   初始化文档     |


## 说明

此文档提供网站服务的详细信息

## 协议约定

1. 所有参数请注意url编码


## 公共字段

| 内部接口 参数名  | 必选  | 类型    | 说明           |
| :-----           | :---  | :---    | :---           |
| appkey           | true  | string  | 内部分配appkey |
| sign             | true  | string  | 计算得到的签名 |
| ts               | true  | int     | 当前时间戳     |

注：签名算法

1.当请求为GET时，把接口所有GET参数拼接（sign参数除外），如appkey=xx&ts=xx，按参数名称排序，最后再拼接上密钥AppSecret，做md5加密

2.当请求为POST时，把接口签名参数拼接（sign参数除外），如appkey=xx&ts=xx，按参数名称排序，最后再拼接上密钥AppSecret，做md5加密

| 跨域支持参数   | 必选  | 类型    | 说明                 |
| :-----         | :---  | :---    | :---                 |
| cross_domain   | true  | string  | 值为true      |
| jsonp          | true  | string  | 值为固定值jsonp      |
| callback       | true  | string  | WEB定义的方法名   |

注：cross_domain和jsonp二选其一

## 接口说明

### 获取文章列表

***请求URL***

http://jelleybrown.com.cn/myweb/index.php/API/JJl/index

***HTTP请求方式***

GET

***参数***

| 跨域支持参数   | 必选  | 类型    | 说明                 |
| :-----       | :---  | :---    | :---                 |
| pn   | false  | int  | 默认0 (页码)  |

***返回结果***

```json
{
    "pageinfo": "",
    "article_list": [
        {
            "article_id": "2",
            "category_id": "3",
            "article_title": "产品介绍",
            "keywords": "产品介绍",
            "article_desc": "产品介绍",
            "article_pic": "http://jelleybrown.com.cn/myweb/",
            "content": "界界乐 乳酸菌饮品",
            "issue_time": "1480753335",
            "edit_time": "1499264748",
            "click_num": "0",
            "category_name": "产品介绍"
        },
        {
            "article_id": "5",
            "category_id": "5",
            "article_title": "品牌动态",
            "keywords": "品牌动态",
            "article_desc": "品牌动态",
            "article_pic": "http://jelleybrown.com.cn/myweb/Data/upload/article_pic/2017-07-05/2017-07-05_14:22:37.jpg",
            "content": "建设中......",
            "issue_time": "1499264557",
            "edit_time": "1499264735",
            "click_num": "0",
            "category_name": "品牌动态"
        }
    ]
}
```
***字段说明***

| 返回值字段    | 字段类型      |  字段说明        |
| :----:      | :---:        | :-----:         |
| article_id     | string     | 文章id     |
| article_title  | string     | 文章标题    |
| article_desc   | string     | 文章描述    |
| article_pic    | string     | 文章图片    |
| content        | string     | 文章内容    |
| category_id    | string     | 分类id     |
| category_name  | string     | 分类名称    |



### 获取文章详情

***请求URL***

http://jelleybrown.com.cn/myweb/index.php/API/JJl/detail?id=5

***HTTP请求方式***

GET

***参数***

| 跨域支持参数   | 必选  | 类型    | 说明                 |
| :-----       | :---  | :---    | :---                 |
| id   | true  | int  | 文章id  |

***返回结果***

```json
{
    "article_id": "5",
    "category_id": "5",
    "article_title": "品牌动态",
    "keywords": "品牌动态",
    "article_desc": "品牌动态",
    "article_pic": "http://test.com/Data/upload/article_pic/2017-08-04_03:00:55.jpg",
    "content": "建设中......",
    "issue_time": "1499264557",
    "edit_time": "1501815655",
    "click_num": "0"
}
```
***字段说明***

| 返回值字段    | 字段类型      |  字段说明        |
| :----:      | :---:        | :-----:         |
| article_id     | string     | 文章id     |
| article_title  | string     | 文章标题    |
| article_desc   | string     | 文章描述    |
| article_pic    | string     | 文章图片    |
| content        | string     | 文章内容    |