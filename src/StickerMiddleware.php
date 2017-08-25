<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\StickerTemplate;

class StickerMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof StickerCommand) {
            return $next($command);
        }

        $command->message = new StickerTemplate;

        $command->message->createMoon(102);

        return $next($command);
    }
}
