<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\VideoTemplate;

class VideoMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof VideoCommand) {
            return $next($command);
        }

        $command->message = new VideoTemplate;
        $command->message->videoUrl = 'https://www.w3schools.com/html/mov_bbb.mp4';
        $command->message->videoPosterUrl = 'https://img.youtube.com/vi/MZ2tq0F8-ww/3.jpg';

        return $next($command);
    }
}
