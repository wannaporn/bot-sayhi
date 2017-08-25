<?php

require __DIR__.'/vendor/autoload.php';

use LineMob\Core\QuickStart;
use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Socket\Server as SocketServer;
use React\Http\Server as HttpServer;

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
            new ImagemapMiddleware(),
            new VideoMiddleware(),
            new AudioMiddleware(),
            new StickerMiddleware(),
            new LocationMiddleware(),
        ]);

        $receiver = $quickStart
            ->addCommand(SayHiCommand::class, true)
            ->addCommand(HelloImageCommand::class)
            ->addCommand(ImagemapCommand::class)
            ->addCommand(VideoCommand::class)
            ->addCommand(AudioCommand::class)
            ->addCommand(StickerCommand::class)
            ->addCommand(LocationCommand::class)
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
