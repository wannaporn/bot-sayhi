<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\ImageMap\ImageMapTemplate;
use LineMob\Core\Template\ImageMap\ActionArea;

class ImageMapMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof ImageMapCommand) {
            return $next($command);
        }

        $command->message = new ImageMapTemplate();
        $command->message->baseUrl = 'https://via.placeholder.com/1040x1040';
        $command->message->width = 1040;
        $command->message->height = 1040;

        $command->message->addLinkAction('https://www.youtube.com/', new ActionArea(0, 0, 520, 1040));
        $command->message->addMessageAction('xxxxx', new ActionArea(0, 0, 1040, 1040));

        return $next($command);
    }
}
