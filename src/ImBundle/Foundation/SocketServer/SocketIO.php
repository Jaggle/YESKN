<?php

/**
 * this file is part of Maxcho Project
 *
 */
namespace ImBundle\Foundation\SocketServer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Workerman\Worker;
use Workerman\Lib\Timer;
use PHPSocketIO\Socket;
use Workerman\Connection\ConnectionInterface;

/**
 * Class SocketIO
 * @package ImBundle\Foundation\SocketServer
 */
class SocketIO
{
    public static function connect(Socket $socket, ContainerInterface $container)
    {
        
        var_dump($container);
        /**
         * 用户登录事件
         *
         */
        $socket->on('login', function ($data) use ($socket) {
            global $uidConnectionMap, $last_online_count, $last_online_page_count;
            global $socketIO;

            if (isset($socket->uid)) {
                return;
            }

            $data = (string)$data;
            if (!isset($uidConnectionMap[$data])) {
                $uidConnectionMap[$data] = 0;
            }

            ++$uidConnectionMap[$data];

            //$socket->join($data);
            $socket->uid = $data;

            $socketIO->emit('broadcast_join', $data);


            $socketIO->emit('update_online_count', "当前<b>{$last_online_count}</b>人在线，共打开<b>{$last_online_page_count}</b>个页面");
        });
    
        /**
         * 用户注册
         *
         */
        $socket->on('register', function ($data) {
        
        });
    
        /**
         * 用户发言
         *
         */
        $socket->on('say', function ($content) use ($socket) {
            global $socketIO;
            $socketIO->emit('broadcast_say', $content);
        });
    
        /**
         * 退出登录
         *
         */
        $socket->on('disconnect', function () use ($socket) {
            if (!isset($socket->uid)) {
                return;
            }
            global $uidConnectionMap;

            if (--$uidConnectionMap[$socket->uid] <= 0) {
                unset($uidConnectionMap[$socket->uid]);
            }
        });
    }
    
    /**
     * 启动一个web server, 用来主动推送消息给用户
     *
     */
    public static function workerStart()
    {
        $inner_http_worker = new Worker('http://0.0.0.0:2121');

        $inner_http_worker->onMessage = function (ConnectionInterface $connection) {
            global $uidConnectionMap;
            $_POST = $_POST ? $_POST : $_GET;

            switch (@$_POST['type']) {
                case 'publish':
                    global $socketIO;
                    $to               = @$_POST['to'];
                    $_POST['content'] = htmlspecialchars(@$_POST['content']);

                    if ($to) {
                        $socketIO->to($to)->emit('broadcast_say', $_POST['content']);

                    } else {
                        $socketIO->emit('broadcast_say', @$_POST['content']);
                    }

                    if ($to && !isset($uidConnectionMap[$to])) {
                        return $connection->send('offline');
                    } else {
                        return $connection->send('ok6666666666666666');
                    }
            }
            return $connection->send('fail');
        };

        $inner_http_worker->listen();


        Timer::add(1, function () {
            global $uidConnectionMap, $socketIO, $last_online_count, $last_online_page_count;
            $online_count_now      = count($uidConnectionMap);
            $online_page_count_now = array_sum($uidConnectionMap);

            if ($last_online_count != $online_count_now || $last_online_page_count != $online_page_count_now) {
                $socketIO->emit('update_online_count', "当前<b>{$online_count_now}</b>人在线，共打开<b>{$online_page_count_now}</b>个页面");
                $last_online_count      = $online_count_now;
                $last_online_page_count = $online_page_count_now;
            }
        });
    }

}
