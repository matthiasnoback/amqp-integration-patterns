<?php

namespace AMQPIntegrationPatterns\Amqp;

final class ConsumptionFlag
{
    /**
     * Flag for message ack
     */
    const MSG_ACK = 1;

    /**
     * Flag single for message nack and requeue
     */
    const MSG_SINGLE_NACK_REQUEUE = 2;

    /**
     * Flag for reject and requeue
     */
    const MSG_REJECT_REQUEUE = 0;

    /**
     * Flag for reject and drop
     */
    const MSG_REJECT = -1;

    /**
     * @var int
     */
    private $flag;

    private function __construct($flag)
    {
        $this->flag = $flag;
    }

    public static function acknowledge()
    {
        return new self(self::MSG_ACK);
    }

    public static function reject()
    {
        return new self(self::MSG_REJECT);
    }

    public function asInteger()
    {
        return $this->flag;
    }
}
