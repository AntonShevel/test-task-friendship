<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 4:58 PM
 */

namespace Controller;

use Model\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Tests\ControllerCollectionTest;
use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{
    /* @var User */
    private $user;

    public function connect(Application $app)
    {
        $this->user = new User($app['db']);
        /* @var \Silex\ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', array($this, 'showUsers'));
        $controllers->post('/', array($this, 'createUser'));
        $controllers->get('/{userId}/', array($this, 'showUser'));
        return $controllers;
    }

    public function showUsers(Application $app)
    {
        $users = [];
        foreach ($this->user->all() as $user) {
            $users[] = $user;
        }
        return $app->json($users);
    }

    public function showUser(Application $app, $userId)
    {
        $user = $this->user->get($userId);
        return $app->json($user);
    }

    public function createUser(Application $app)
    {
        return $app->json($this->user->create([
            'name' => $app['request']->get('name'),
            'description' => $app['request']->get('description'),
        ]));
    }
}
