<?php

namespace bong\service\queue\traits;

use Kcloze\Jobs\JobObject;
use Kcloze\Jobs\Logs;

trait TopicQueue
{

    public $topics = [];

    //private $logger =null;

    public static function getConnection(array $config, Logs $logger)
    {
        return container('queue')->driver();
    }

    public function getTopics()
    {
        //根据key大到小排序，并保持索引关系
        arsort($this->topics);

        return array_values($this->topics);
    }

    public function setTopics(array $topics)
    {
        $this->topics = $topics;
    }

    /*
    public function push($topic, JobObject $job): string
    {
        throw new \Exception('not support!');
    }
    */

    public function pop($topic)
    {
        return self::pop($topic);
    }

    public function len($topic): int
    {
        return self::size($topic);
    }

    public function close()
    {
        //nothing
    }

    public function isConnected()
    {
        return true;
    }

}
