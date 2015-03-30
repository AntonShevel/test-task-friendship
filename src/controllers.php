<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 1:50 PM
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* @var $app Silex\Application */

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->error(function (\Exception $e, $code) use ($app) {
//    if ($app['debug']) {
//        return;
//    }
        $output = new \stdClass();
        $output->code = $code;
        $output->error = $e->getMessage();
        return $app->json($output, $code);
});

$app->mount('/', new Controller\IndexController());
$app->mount('/user', new Controller\UserController());
$app->mount('/friendship', new Controller\FriendshipController());
$app->mount('/friends', new Controller\FriendsController());

return $app;