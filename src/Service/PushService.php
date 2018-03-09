<?php


namespace webSocket\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use webSocket\Facades\Queue;

class PushService
{
    /**
     *   清空缓存数据
     */
    static public function clean()
    {
    }

    /**
     * 清理fd下原来的数据
     * @param $fd
     */
    static public function cleanFdChannel($fd)
    {
        Queue::clean(self::getFdChannel($fd));
    }

    /**
     * push
     * @param $fd
     * @param $data
     */
    static public function pushToFdAsync($fd, $data)
    {
        Queue::push(self::getFdChannel($fd), $data);
    }

    /**
     * 获取当前用户的channel
     * @param $fd
     * @return string
     */
    static public function getFdChannel($fd)
    {
        return "webSocket.fd." . $fd;
    }

    /**
     * 反馈需要Push的数据
     * @param $action
     * @param $status
     * @param array $message
     * @return array
     */
    static public function results($action, $status, $message = array())
    {
        return [
            'action' => $action,
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * 执行成功消息
     * @param $action
     * @param array $message
     * @return array
     */
    static public function success($action, $message = array())
    {
        return [
            'action' => $action,
            'status' => 1,
            'message' => $message
        ];
    }

    /**
     * 执行失败消息
     * @param $action
     * @param array $message
     * @return array
     */
    static public function error($action, $message = array())
    {
        return [
            'action' => $action,
            'status' => 0,
            'message' => $message
        ];
    }
}