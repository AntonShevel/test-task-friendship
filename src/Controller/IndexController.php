<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 2:21 PM
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

class IndexController implements ControllerProviderInterface
{
    public function __construct() {}
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers->get('/', array($this, 'index'));
        return $controllers;
    }

    public function index(Application $app) {
        return $app->json($app['db']->command(array('dbStats' => 1)));
    }
}