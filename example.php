<?php

require __DIR__.'/vendor/autoload.php';

require_once 'src/SayHiCommand.php';
require_once 'src/SayHiMiddleware.php';

use LineMob\Core\QuickStart;
use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Socket\Server as SocketServer;
use React\Http\Server as HttpServer;

$port = '8888';
$config = [
    'line_channel_token' => 'jUvE46JVqWrP8zLOxfmVx+AznUp18g3ExX0tBgdAmNfmFCKHrw4EXGBUCPVf8+Fj60fN4FgRjdmY8AFEHCYrhTDOXGiq9L/nelkBp5l68pArnDMAQdOAYswbbcnE6MPUSLM1uRVSVJSmR8VoS5D2fwdB04t89/1O/w1cDnyilFU=',
    'line_channel_secret' => '3aec579fe57eaa96398cbed86068e11a',
];

$app = function (Request $request, Response $response) use ($config) {
    $request->on('data', function ($data) use ($request, $config) {

        $quickStart = new QuickStart([
            new SayHiMiddleware(),
        ]);

        $receiver = $quickStart
            ->addCommand(SayHiCommand::class, true)
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
