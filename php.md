
## ubuntu 安装php

### 1.安装mysql

  sudo apt install mysql-server
  
  
### 2.安装nginx和php

   添加nginx和php的ppa源
   
   这个php ppa的源提供了几个版本的php 5.5  5.6  7.0 7.1  
   
   也就是说我们可以安装多个版本共存
   
  
   sudo apt-add-repository ppa:nginx/stable
   sudo apt-add-repository ppa:ondrej/php
   sudo apt update
   
   
### 3. 安装常用的扩展库
   
sudo apt install php-mysql php-curl php-mcrypt php-gd php-memcached php-redis  


## Debian 8上的PHP7 deb包的安装

修改source.list配置文件：

deb http://packages.dotdeb.org jessie all
deb-src http://packages.dotdeb.org jessie all

安装php7相关的组件：
wget https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

sudo apt-get update
sudo apt-get install php7.0 php7.0-fpm php7.0-memcached php7.0-common php7.0-dev php7.0-dbg php7.0-curl php7.0-intl php7.0-mysql php7.0-redis php7.0-json php7.0-curl


编译安装

```

cd ~
wget http://cn2.php.net/distributions/php-7.0.6.tar.bz2
cd php-7.0.6
'./configure'  '--prefix=/usr/local/php7' '--with-config-file-path=/usr/local/php7/etc' '--enable-opcache' '--enable-inline-optimization' '--disable-rpath' '--enable-shared' '--enable-fpm' '--with-fpm-user=www-data' '--with-fpm-group=www-data' '--with-gettext' '--with-iconv' '--with-mcrypt' '--with-mhash' '--with-openssl' '--with-iconv-dir' '--with-zlib' '--with-zlib-dir' '--enable-soap' '--enable-ftp' '--enable-mbstring' '--enable-exif' '--disable-ipv6' '--enable-xml' '--enable-zip' '--enable-bcmath' '--with-libxml-dir' '--enable-pcntl' '--enable-shmop' '--enable-sysvsem' '--enable-sysvmsg' '--enable-sysvshm' '--enable-sockets' '--with-curl' '--with-bz2' '--with-sqlite3' '--with-pdo-sqlite' '--with-pear' '--with-mysqli=mysqlnd' '--with-pdo-mysql=mysqlnd' '--with-xsl'
中间如果有系统以来的lib库，请麻烦自行google之后安装
make -j4
sudo make install

```

php.ini初始化

```

cp php.ini-production   /usr/local/php7/etc/php.ini
vi /usr/local/php7/etc/php.ini  修改时区设置 date.timezone=Asia/Shanghai

```

fpm pool 设置

```

[www-data]
listen = 0.0.0.0:9000
user = www-data
group = www-data
pm = dynamic
pm.max_children = 8
pm.start_servers = 2
pm.min_spare_servers = 2
pm.max_spare_servers = 4
pm.max_requests = 5000
request_terminate_timeout = 30s
request_slowlog_timeout = 25s
slowlog = /data/log/php-slow.log
php_admin_value[upload_tmp_dir] = /data/tmp/

```

PHP7的memcached扩展相关

```

wget https://codeload.github.com/php-memcached-dev/php-memcached/zip/php7
unzip php7
cd php-memcached-php7
/usr/local/php7/bin/phpize
./configure --with-php-config=/usr/local/php7/bin/php-config
make -j4
sudo make install
vi /usr/local/php7/etc/php.ini 添加一行 extension=memcached.so

```

nginx conf

```

server {
  listen 80;
  server_name test.com;
  root /data/app;
  index index.php;
  charset utf-8;
  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }
  client_body_buffer_size 32M;
  fastcgi_read_timeout 300;
  keepalive_timeout 5;
  location ~ \.php$ {
      fastcgi_split_path_info ^(.+\.php)(/.+)$;
      fastcgi_pass 127.0.0.1:9000;
      fastcgi_index index.php;
      include fastcgi_params;
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
      fastcgi_buffer_size 16k;
      fastcgi_buffers 4 16k;
  }
  access_log /data/logs/access_log main;
  error_log /data/logs/error_logger  error;
}

```