<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;

class SayHiMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof SayHiCommand) {
            return $next($command);
        }

        $command->message = 'Say, Hi!';

        return $next($command);
    }
}
