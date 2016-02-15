## Laravel PHP 框架

服务器要求

Laravel 框架对系统有一些要求. 当然, 如果使用 Laravel Homestead 虚拟机已经满足这些要求。

PHP >= 5.5.9  
OpenSSL PHP Extension  
PDO PHP Extension  
Mbstring PHP Extension  
Tokenizer PHP Extension

数据库使用Mysql  
最好使用apache作为http服务  

## 安装
请参考[这篇文章](http://www.cnblogs.com/yanqing/p/5183556.html)  

## laravel安装
执行 composer install  
创建数据库内的数据表,执行 php artisan migrate  
遇到错误提示百度解决  

将.env.example复制成.env  
.env为配置文件  

>这是数据库配置  

DB_HOST=localhost  
DB_DATABASE=game  
DB_USERNAME=root  
DB_PASSWORD=root  

>wechat配置对应公众平台的appid、appsecret、token  

WECHAT_APP_ID=wxff4248454f4747c2  
WECHAT_APP_Secret=54ff252ebfbf896b0d2fb1c3783d0f79  
WECHAT_TOKEN=qbtest

>下面是游戏配置 .整个游戏的点击数量是下面所有点击数的和.所以,按下面这个配置,集齐所有卡片要10个点击 

players_num=4000 #没用
winner_num=2 #中奖人数.到达中奖人数后活动自动结束  
card_num=10 #卡片的数量  
card_1_hits=1 #卡片1所需点击数量  
card_2_hits=1 #卡片2所需点击数量.以此类推  
card_3_hits=1  
card_4_hits=1  
card_5_hits=1  
card_6_hits=1  
card_7_hits=1  
card_8_hits=1  
card_9_hits=1  
card_10_hits=1  
