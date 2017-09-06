<?php

namespace Middleware;

use Command\ConfirmCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\ConfirmTemplate;

class ConfirmMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof ConfirmCommand) {
            return $next($command);
        }

        $command->message = new ConfirmTemplate();

        $command->message->addYesAction();
        $command->message->addNoAction();

        return $next($command);
    }
}
