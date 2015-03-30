<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 10:49 PM
 */

namespace Model;

use MongoId;

class Friendship extends AbstractModel
{
    public function __construct($db) {
        parent::__construct($db);
    }

    public function request($targetId, $userId) {
        $targetMongoId = new MongoId($targetId);
        $userMongoId = new MongoId($userId);
        return $this->db->users->update(
            ['_id' => $userMongoId],
            ['$addToSet' => ['friendship' => $targetMongoId]]
        );
    }

    public function confirm($targetId, $userId) {
        if ($this->isRequestSent($targetId, $userId)) {
            return $this->request($targetId, $userId);
        }
        return false;
    }

    public function remove($targetId, $userId) {
        $targetMongoId = new MongoId($targetId);
        $userMongoId = new MongoId($userId);
        return $this->db->users->update(
            ['_id' => $userMongoId],
            ['$pull' => ['friendship' => $targetMongoId]]
        );
    }

    public function show($userId) {
        $userMongoId = new MongoId($userId);
        //should use mapReduce
        $requests = $this->db->users->findOne(['_id'=>$userMongoId], ['friendship'=>true]);

        return $this->showAll($this->db->users->find([
            'friendship' => $userMongoId,
            '_id' => ['$nin'=>$requests['friendship']]
        ]));
    }

    private function isRequestSent($targetId, $userId) {
        $targetMongoId = new MongoId($targetId);
        $userMongoId = new MongoId($userId);
        return $this->db->users->find(['_id'=>$targetMongoId, 'friendship'=>$userMongoId])->count() > 0;
    }

}