<?php

namespace Middleware;

use Command\CarousalCommand;
use League\Tactician\Middleware;
use LineMob\Core\Command\AbstractCommand;
use LineMob\Core\Template\Action;
use LineMob\Core\Template\Carousel\CarouselTemplate;

class CarousalMiddleware implements Middleware
{
    /**
     * @param AbstractCommand $command
     *
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof CarousalCommand) {
            return $next($command);
        }

        $command->message = new CarouselTemplate;

        $command->message->addItem('Item 1', 'Item 1 Text', 'https://via.placeholder.com/300x300', [
            new Action('Click Me!', 'clicked'),
            new Action('Search', 'https://www.google.co.th', Action::TYPE_URI),
            new Action('Action', 'action', Action::TYPE_POSTBACK)
        ]);

        $command->message->addItem('Item 2', 'Item 2 Text', 'https://via.placeholder.com/300x300', [
            new Action('Click Me!', 'clicked'),
            new Action('Search', 'https://www.google.co.th', Action::TYPE_URI),
            new Action('Action', 'action', Action::TYPE_POSTBACK)
        ]);

        $command->message->addItem('Item 3', 'Item 3 Text', 'https://via.placeholder.com/300x300', [
            new Action('Click Me!', 'clicked'),
            new Action('Search', 'https://www.google.co.th', Action::TYPE_URI),
            new Action('Action', 'action', Action::TYPE_POSTBACK)
        ]);

        return $next($command);
    }
}
