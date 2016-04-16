<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\ApplicationError;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class LogApplicationError implements Consumer
{
    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Consumer $consumer, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->consumer = $consumer;
    }

    public function consume(AMQPMessage $amqpMessage, EventDrivenConsumer $eventDrivenConsumer)
    {
        try {
            $this->consumer->consume($amqpMessage, $eventDrivenConsumer);
        } catch (ApplicationError $exception) {
            $this->logger->critical(
                'An application error occurred while processing a message',
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                    'amqp_message' => $amqpMessage
                ]
            );

            throw $exception;
        }
    }
}
