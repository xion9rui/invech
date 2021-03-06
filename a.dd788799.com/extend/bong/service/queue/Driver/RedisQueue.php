<?php

namespace bong\service\queue\Driver;

use bong\service\queue\Queue;
use bong\service\queue\Contracts\Queue as QueueContract;

use bong\service\queue\Driver\RedisClient;
use bong\service\queue\LuaScripts;
use bong\service\queue\Jobs\RedisJob;
use bong\foundation\Str;

use bong\service\queue\traits\TopicQueue;
use Kcloze\Jobs\Queue\TopicQueueInterface;
use think\Cache;
use \Redis;
use think\Exception;

class RedisQueue extends Queue implements QueueContract ,TopicQueueInterface
{
    use TopicQueue;

    protected $queue_name;//队列名
    protected $client;
    protected $retryAfter;

    public function __construct($config)
    {
        $this->queue_name = $config['queue_name']??'default';        
        $this->client = new RedisClient($config);
        $this->retryAfter = $config['retry_after']??60;
    }


    protected function createPayloadArray($job, $data = '')
    {
        return array_merge(parent::createPayloadArray($job, $data), [
            'id' => $this->getRandomId(),
            'attempts' => 0,
        ]);
    }

    public function size($queue = null)
    {
        $queue = $this->getQueue($queue);

        $size = $this->client->eval(
            LuaScripts::size(), 3, $queue, $queue.':delayed', $queue.':reserved'
        );
        /*
        $length = $this->handler->lLen($queue);
        $delayed = $this->handler->zCard($queue.':delayed');
        $reserved = $this->handler->zCard($queue.':reserved');
        $size = $length + $delayed + $reserved;
        if(!is_int($size)){
            file_put_contents(LOG_PATH.'/get_size_error', date('Y-m-d H:i:s').":error_{$queue}: {$length},{$delayed},{$reserved}\n", FILE_APPEND);
            $size = 0;
        }
        */
        return $size;
    }

    public function push($job, $data = '', $queue = null)
    {
        return $this->pushRaw($this->createPayload($job, $data), $queue);
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        //$this->client->rpush($this->getQueue($queue), $payload);

        $this->client->eval(
            LuaScripts::rpush(), 1, 
            $this->getQueue($queue),  $payload
        );

        return json_decode($payload, true)['id'] ?? null;
    }

    
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->laterRaw($delay, $this->createPayload($job, $data), $queue);
    }

    protected function laterRaw($delay, $payload, $queue = null)
    {
        /*
        $this->client->zadd(
            $this->getQueue($queue).':delayed', $this->availableAt($delay), $payload
        );
        */
        $queue = $this->getQueue($queue);
        $this->client->eval(
            LuaScripts::zadd(), 1, $queue.':delayed',
            $payload,$this->availableAt($delay)
        );
        return json_decode($payload, true)['id'] ?? null;
    }       
      

    public function pop($queue = null)
    {
        $this->migrate($prefixed = $this->getQueue($queue));

        list($job, $reserved) = $this->retrieveNextJob($prefixed);

        if ($reserved) {
            return new RedisJob(
                $this, $job,
                $reserved, $queue ?: $this->default
            );
        }
    }

    protected function migrate($queue)
    {
        $this->migrateExpiredJobs($queue.':delayed', $queue);

        if (! is_null($this->retryAfter)) {
            $this->migrateExpiredJobs($queue.':reserved', $queue);
        }
    }

    public function migrateExpiredJobs($from, $to)
    {
        return $this->client->eval(
            LuaScripts::migrateExpiredJobs(), 2, $from, $to, time()
        );
    }

    protected function retrieveNextJob($queue)
    {
/*
        $job = $this->handler->lPop($queue);
        $reserved = json_decode($job, true);
        if($reserved){
            $reserved['attempts'] = $reserved['attempts'] + 1;
            $reserved = json_encode($reserved);
            $this->handler->zAdd($queue.':reserved',$this->availableAt($this->retryAfter),$reserved);
        }else{
            $reserved = false;
        }

        return [$job, $reserved];
*/
        return $this->client->eval(
            LuaScripts::pop(), 2, $queue, $queue.':reserved',
            $this->availableAt($this->retryAfter)
        );
    }

    public function deleteReserved($queue, $job)
    {
        //$this->client->zrem($this->getQueue($queue).':reserved', $job->getReservedJob());

        $queue = $this->getQueue($queue);

        $this->client->eval(
            LuaScripts::zrem(), 1, $queue.':reserved',
            $job->getReservedJob()
        );

    }

    public function deleteAndRelease($queue, $job, $delay)
    {
        $queue = $this->getQueue($queue);

        $this->client->eval(
            LuaScripts::release(), 2, $queue.':delayed', $queue.':reserved',
            $job->getReservedJob(), $this->availableAt($delay)
        );
    }
    
    protected function getRandomId()
    {
        return Str::random(32);
    }

    public function getQueue($queue)
    {
        return 'queues:'.($queue ?: $this->queue_name);
    }



}
