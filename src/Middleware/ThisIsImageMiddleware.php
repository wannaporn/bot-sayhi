<?php

namespace Middleware;

use Command\HelloImageCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\ImageTemplate;

class ThisIsImageMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof HelloImageCommand) {
            return $next($command);
        }

        $command->message = new ImageTemplate();
        $command->message->url = 'https://cdn-enterprise.discourse.org/codecademy/user_avatar/discuss.codecademy.com/godoakbrutal/240/2077559_1.png';
        $command->message->previewUrl = 'https://avatars2.githubusercontent.com/u/10972026?v=4&s=400';

        return $next($command);
    }
}
