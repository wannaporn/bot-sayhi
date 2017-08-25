<?php

use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\Carousel\CarouselTemplate;

class TemplateCarouselMiddleware implements Middleware
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

        $command->message = new CarouselTemplate;

        $command->message->addRow(
            'This is a book !',
            'lol lol lol lol lol ',
            'https://www.xn--12ccq6csbl8c8d2a3bcs8qc7iho.com/images/IMG_0342.jpg'
        );

        return $next($command);
    }
}
