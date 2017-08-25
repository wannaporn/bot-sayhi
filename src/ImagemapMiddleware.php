<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\Imagemap\ImagemapTemplate;
use LineMob\Core\Template\Imagemap\ActionArea;

class ImagemapMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof ImagemapCommand) {
            return $next($command);
        }

        $command->message = new ImagemapTemplate();
        $command->message->baseUrl = 'https://via.placeholder.com/1040x1040';
        $command->message->width = 1040;
        $command->message->height = 1040;

        $command->message->addLinkAction(new ActionArea(0, 0, 520, 1040), 'https://www.youtube.com/');
        $command->message->addMessageAction(new ActionArea(0, 0, 1040, 1040), 'xxxxx');

        return $next($command);
    }
}
