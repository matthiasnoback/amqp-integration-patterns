<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\ApplicationError;
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

    public function consume(AMQPMessage $amqpMessage)
    {
        try {
            $this->consumer->consume($amqpMessage);
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
