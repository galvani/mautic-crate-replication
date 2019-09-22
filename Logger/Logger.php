<?php

namespace MauticPlugin\CrateReplicationBundle\Logger;

use MauticPlugin\CrateReplicationBundle\CrateReplicationBundle;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements \Psr\Log\LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $this->logger->log($level, CrateReplicationBundle::BUNDLE_NAME . ' ' .$message, $context);
    }


}