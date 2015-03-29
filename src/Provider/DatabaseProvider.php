<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 3:24 PM
 */

namespace Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface {

    public function register(Application $app) {

        $app['db'] = $app->share(function ($app) {
            $uri = sprintf('mongodb://%s', $app['db.config']['host']);
            $client = new \MongoClient($uri);
            return $client->{$app['db.config']['name']};
        });

    }

    public function boot(Application $app) {
    }
}