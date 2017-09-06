<?php

namespace Middleware;

use Command\ButtonsCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\ButtonsTemplate;

class ButtonsMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof ButtonsCommand) {
            return $next($command);
        }

        $command->message = new ButtonsTemplate();
        $command->message->thumbnail = 'https://via.placeholder.com/300x300';
        $command->message->addMessageAction('Click Me!', 'Clicked');
        $command->message->addUriAction('Search', 'https://www.google.co.th');
        $command->message->addPostbackAction('Action', 'action');

        return $next($command);
    }
}
