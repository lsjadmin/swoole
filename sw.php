<?php
$server = new swoole_websocket_server("0.0.0.0", 9502);

$server->on('open', function($server, $req) {
    echo "connection open: {$req->fd}\n";
});

//$frame->data  数据
$server->on('message', function($server, $frame) {

    echo"<pre>";print_r($frame);echo"</pre>";
    //echo "received message: {$frame->data}\n";
    //$server->push($frame->fd, $frame->data);

    foreach($server->connections as $fds){     //给多个fd 发送数据
            if($server->isEstablished($fds)){
                $server->push($fds, $frame->data);
            }
    }
});

$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
});

$server->start();