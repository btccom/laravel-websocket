<?php
/**
 * Created by PhpStorm.
 * User: pz
 * Date: 2017/6/11
 * Time: 21:10
 */

namespace webSocket;

abstract class RedisSubscribe
{
    protected $data;

    protected $fd;

    protected $channel;

    public function setData($channel, $data)
    {
        $this->channel = $channel;
        $this->fd = $data['fd'];
        $this->data = $data['data'];
    }

    public function reset()
    {
        $this->fd = null;
        $this->data = null;
        $this->channel = null;
    }

    abstract public function handle();
}
