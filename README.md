# laravel-websocket

基于 laravel + swoole + redis 的WebSocket开发库。适合开发中小型webSocket程序。

无需关注webSocket的细节，专注业务。

可同步、异步处理请求，发送数据。

## 安装方法
1. 安装laravel.

2. 添加websocket库: composer require btccom/laravel-websocket

3. 添加laravel command类，继承 webSocket\Commands\WebSocketCommand.

## Demo
在目录/demo/laravel中是一个简单的Demo程序。

### 使用方法

1. 将Demo目录中的文件覆盖到laravel程序中。
2. 配置redis。
3. 打开app/config/app.php,将默认的Redis服务提供器修改为websocket的Redis服务提供器，将Illuminate\Redis\RedisServiceProvider替换为\webSocket\Redis\RedisServiceProvider
4. 打开app/config/websocket.php 文件，修改websocket的监听ip、端口和工作进程数量。
5. 命令行执行:**php artisan websocket:start** 开启websocket服务。

## 基本概念

当客户端与服务端建立webSocket连接后，服务端会生成一个fd,该fd表示当前链接，通过该fd服务端可以发送消息给客户端。
    
### 数据交互

    客户端发送给服务端结构如下：{type:type,data:data}
    其中如果type为login,服务端接受程序信息后会调用message_login方法，处理信息。
    
### 常用API
   
#### webSocket\Service\PushService

    PushService::pushToFdAsync($fd,$data) 发送消息给某个客户端
    PushService::success($action,$message = array()) 反馈成功的数据结构
    PushService::error($action,$message = array()) 反馈失败的数据结构


## Nginx 配置

```
map $http_upgrade $connection_upgrade {
    default upgrade;
    '' close;
}

upstream websocket {
    server xxx;
}

server {
    listen                 443 ssl http2;
    server_name            ws.xxx.com;
    access_log             logs/ws.xxx.com-access.log;
    error_log              logs/ws.xxx.com-error.log;

    ssl                    on;
    ssl_certificate        ssl/xxx.com.crt;
    ssl_certificate_key    ssl/xxx.com.key;

    location / {
        proxy_pass http://websocket;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;

        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto https;
    #    proxy_redirect off;
    }
}
```