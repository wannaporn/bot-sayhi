<?php

namespace Middleware;

use Command\AudioCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\AudioTemplate;

class AudioMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof AudioCommand) {
            return $next($command);
        }

        $command->message = new AudioTemplate;
        $command->message->url = 'https://auphonic.com/media/audio-examples/auphonic-denoise-3-unprocessed.m4a';
        $command->message->duration = 46000;

        return $next($command);
    }
}
