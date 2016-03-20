<?php

namespace AMQPIntegrationPatterns\Amqp;

use PhpAmqpLib\Message\AMQPMessage;

interface Producer
{
    /**
     * @param AMQPMessage $message
     * @return void
     */
    public function publish(AMQPMessage $message);
}
