<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 2:21 PM
 */

namespace Controller;

use Model\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class IndexController implements ControllerProviderInterface
{
    public function __construct() {}
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers->get('/', array($this, 'index'));
        return $controllers;
    }

    public function index(Application $app) {
//        $foo = $app['db'];
//        $foo = new \MongoClient();
//        $user = new User($app['db']);
//        $user->create([
//            'name' => 'Tester',
//            'description' => 'lorem'
//        ]);
        return $app->json([$app['db']]);
    }
}