<?php

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require __DIR__ . '/../../../bootstrap.php';

$pidFile = __DIR__ . '/consume.php.pid';

file_put_contents($pidFile, getmypid());

define('AMQP_DEBUG', true);

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest', '/');

$declaredExchange = ExchangeBuilder::create($connection->channel(), md5(uniqid()))
    ->declareExchange();

$declaredQueue = $declaredExchange->buildQueue('events_of_specific_type')
    ->withBinding('events_of_specific_type')
    ->declareQueue();

class ConsoleLoggingConsumer implements Consumer
{
    public function consume(AMQPMessage $amqpMessage)
    {
        echo $amqpMessage->body;
    }
}

$eventDrivenConsumer = $declaredQueue->consume(new ConsoleLoggingConsumer());

pcntl_signal(SIGINT, function () use (&$eventDrivenConsumer) {
    $eventDrivenConsumer->stopWaiting();
});

$eventDrivenConsumer->wait();

unlink($pidFile);
