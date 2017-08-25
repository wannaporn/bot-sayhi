<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\LocationTemplate;

class LocationMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof LocationCommand) {
            return $next($command);
        }

        $command->message = new LocationTemplate;
        $command->message->title = 'Intbizth';
        $command->message->address = '2/119 Ratphattana Rd. Saphansung BKK 10240';
        $command->message->latitude = 13.7888518;
        $command->message->longitude = 100.702833;

        return $next($command);
    }
}
