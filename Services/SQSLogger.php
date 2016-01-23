<?php


namespace AmazonWebServicesBundle\Services;

use Symfony\Component\DependencyInjection\Container;

/**
 * Send messages to AWS SQS queues
 *
 * $SQS->log($message);
 * $SQS->error($message);
 * $SQS->critical($message);
 * @package Core\AWSBundle\Service
 * @author El Mehdi Mouddene <mouddene@gmail.com>
 **/

class SQSLogger{

    // Logging level
    const LEVEL_DEBUG     = 'DEBUG';     //0
    const LEVEL_INFO      = 'INFO';      //1
    const LEVEL_ERROR     = 'ERROR';     //2
    const LEVEL_CRITICAL  = 'CRITICAL';  //3
    const LEVEL_EMERGENCY = 'EMERGENCY'; //4
    const LEVEL_EXCEPTION = 'EXCEPTION'; //5

    private $container;
    private $client;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->client = $this->container->get('aws_sqs');
    }

    /**
     * @param $level
     * @return mixed
     */
    private function getQueueUrl($level){
        $result = $this->client->createQueue('project_logging_queue_'.$level);
        return $result->body->CreateQueueResult->QueueUrl;
    }

    /**
     * @param $message
     * @return mixed|void
     */
    public function info($message){
        $this->sendMessage($message, $this->getQueueUrl(self::LEVEL_INFO));
    }

    public function debug($message){
        $this->sendMessage($message, $this->getQueueUrl(self::LEVEL_DEBUG));
    }

    public function error($message){
        $this->sendMessage($message, $this->getQueueUrl(self::LEVEL_ERROR));
    }

    public function critical($message){
        $this->sendMessage($message, $this->getQueueUrl(self::LEVEL_CRITICAL));
    }

    public function emergency($message)
    {
        $this->sendMessage($message, $this->getQueueUrl(self::LEVEL_EMERGENCY));
    }

    public function exception(\Exception $e){
        $this->sendMessage($e->getMessage(), self::LEVEL_EXCEPTION);
    }


    public function sendMessage($message, $queueUrl){
        $this->client->sendMessage($queueUrl, $message);
    }


}