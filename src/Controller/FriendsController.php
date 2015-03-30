<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/30/15
 * Time: 3:21 AM
 */

namespace Controller;

use Model\Friends;
use Silex\Application;
use Silex\ControllerProviderInterface;

class FriendsController implements ControllerProviderInterface
{
    private $friends;

    public function connect(Application $app)
    {
        $this->friends = new Friends($app['db']);
        $controllers = $app['controllers_factory'];
        $controllers->get('/{depth}/', array($this, 'showFriendsDeeper'));
        $controllers->get('/', array($this, 'showFriends'));
        return $controllers;
    }

    public function showFriendsDeeper(Application $app, $depth)
    {
        $userId = $app['request']->get('userId');
        return $app->json($this->friends->showDeeper($userId, $depth));
    }

    public function showFriends(Application $app)
    {

        $userId = $app['request']->get('userId');
        return $app->json($this->friends->show($userId));
    }
}
