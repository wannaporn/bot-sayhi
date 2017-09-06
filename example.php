<?php

require __DIR__.'/vendor/autoload.php';

use LineMob\Core\QuickStart;
use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Socket\Server as SocketServer;
use React\Http\Server as HttpServer;
use Middleware\SayHiMiddleware;
use Middleware\ThisIsImageMiddleware;
use Middleware\ImageMapMiddleware;
use Middleware\VideoMiddleware;
use Middleware\AudioMiddleware;
use Middleware\StickerMiddleware;
use Middleware\LocationMiddleware;
use Middleware\ButtonsMiddleware;
use Middleware\CarousalMiddleware;
use Middleware\ConfirmMiddleware;
use Command\SayHiCommand;
use Command\HelloImageCommand;
use Command\ImageMapCommand;
use Command\VideoCommand;
use Command\AudioCommand;
use Command\StickerCommand;
use Command\LocationCommand;
use Command\ButtonsCommand;
use Command\CarousalCommand;
use Command\ConfirmCommand;

$port = '8888';
$config = [
    'line_channel_token' => 'your_own_bot_token',
    'line_channel_secret' => 'your_own_bot_secret',
];

$app = function (Request $request, Response $response) use ($config) {
    $request->on('data', function ($data) use ($request, $config) {

        $quickStart = new QuickStart([
            new SayHiMiddleware(),
            new ThisIsImageMiddleware(),
            new ImageMapMiddleware(),
            new VideoMiddleware(),
            new AudioMiddleware(),
            new StickerMiddleware(),
            new LocationMiddleware(),
            new ButtonsMiddleware(),
            new CarousalMiddleware(),
            new ConfirmMiddleware(),
        ]);

        $receiver = $quickStart
            ->addCommand(SayHiCommand::class, true)
            ->addCommand(HelloImageCommand::class)
            ->addCommand(ImageMapCommand::class)
            ->addCommand(VideoCommand::class)
            ->addCommand(AudioCommand::class)
            ->addCommand(StickerCommand::class)
            ->addCommand(LocationCommand::class)
            ->addCommand(ButtonsCommand::class)
            ->addCommand(CarousalCommand::class)
            ->addCommand(ConfirmCommand::class)
            ->setup($config['line_channel_token'], $config['line_channel_secret'], ['verify' => false])
        ;

        $signature = $request->getHeaderLine('X-Line-Signature');

        var_dump($data);

        if ($receiver->validate($data, $signature)) {
            var_dump($receiver->handle($data));
        } else {
            throw new \RuntimeException("Invalid signature: ".$signature);
        }
    });

    $response->writeHead(200, array('Content-Type' => 'text/plain'));
    $response->end("Hello World hot\n");
};

$loop = Factory::create();
$socket = new SocketServer($loop);
$http = new HttpServer($socket, $loop);

$http->on('request', $app);

echo("Server running at http://127.0.0.1:".$port);

$socket->listen($port);
$loop->run();
