<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\ApplicationError;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class LogApplicationError implements Consumer
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(Consumer $consumer, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->consumer = $consumer;
    }

    public function consume(AMQPMessage $amqpMessage)
    {
        try {
            return $this->consumer->consume($amqpMessage);
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
