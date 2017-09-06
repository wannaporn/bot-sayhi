<?php

namespace Middleware;

use Command\SayHiCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\TextTemplate;

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

        $command->message = new TextTemplate;
        $command->message->text = 'Say, Hi!';

        return $next($command);
    }
}
