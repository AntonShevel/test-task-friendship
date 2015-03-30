<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 10:49 PM
 */

namespace Controller;

use Model\Friendship;
use Silex\Application;
use Silex\ControllerProviderInterface;

class FriendshipController implements ControllerProviderInterface
{
    private $friendship;

    public function connect(Application $app)
    {
        $this->friendship = new Friendship($app['db']);
        $controllers = $app['controllers_factory'];
        $controllers->post('/{targetId}/', array($this, 'requestFriendship'));
        $controllers->put('/{targetId}/', array($this, 'confirmFriendship'));
        $controllers->delete('/{targetId}/', array($this, 'removeFriendship'));
        $controllers->get('/', array($this, 'showRequests'));
        return $controllers;
    }

    public function requestFriendship(Application $app, $targetId)
    {

        $userId = $app['request']->get('userId');
        if ($userId == $targetId) {
            $app->abort(400, 'Don\'t be so selfish');
        }
        return $app->json($this->friendship->request($targetId, $userId));
    }

    public function confirmFriendship(Application $app, $targetId)
    {

        $userId = $app['request']->get('userId');
        $result = $this->friendship->confirm($targetId, $userId);
        if (!$result) {
            $app->abort(400, 'No friendship request to confirm');
        }
        return $app->json($result);
    }

    public function removeFriendship(Application $app, $targetId)
    {

        $userId = $app['request']->get('userId');
        return $app->json($this->friendship->remove($targetId, $userId));
    }

    public function showRequests(Application $app)
    {
        $userId = $app['request']->get('userId');
        return $app->json($this->friendship->show($userId));
    }
}
