<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/30/15
 * Time: 2:36 AM
 */

namespace Model;

use MongoId;

class Friends extends AbstractModel
{
    public function __construct($db) {
        parent::__construct($db);
    }

    public function show($userId, $depth = 0) {
        $userMongoId = new MongoId($userId);
        $ids = is_array($userId) ? $userId : [$userMongoId];
        $requests = $this->db->users->findOne(['_id'=>['$in'=>$ids]], ['friendship'=>true]);

        return $this->showAll($this->db->users->find([
            'friendship' => $userMongoId,
            '_id' => ['$in'=>$requests['friendship']]
        ]));
    }

}