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
    public function __construct($db)
    {
        parent::__construct($db);
    }

    /**
     * shows friends of user
     * @param $userId
     * @return array
     */
    public function show($userId)
    {
        $userMongoId = new MongoId($userId);
        $ids = is_array($userId) ? $userId : [$userMongoId];
        $requests = $this->db->users->findOne(['_id'=>['$in'=>$ids]], ['friendship'=>true]);

        return $this->showAll($this->db->users->find([
            'friendship' => $userMongoId,
            '_id' => ['$in'=>$requests['friendship']]
        ]));
    }

    /**
     * shows friends of friends (if depth=1)
     * @param $userId
     * @param int $depth
     * @return array of MongoId
     */
    public function showDeeper($userId, $depth = 1)
    {
        // should try to use mapReduce...
        $ids = is_array($userId) ? $userId : [new MongoId($userId)];
        $ops = [
            ['$match' => ['_id'=>['$in'=>$ids]]],
            ['$project' => ['friendship'=>true, '_id'=>false]],
            ['$unwind' => '$friendship'],
            ['$group' => ['friendship'=>['$addToSet'=>'$friendship'], '_id'=>false]]
        ];
        $requests = $this->db->users->aggregate($ops);

        $friendship = $requests['result'][0]['friendship'];
        $ops = [
            ['$match' => ['_id'=>['$in'=>$friendship]]],
            ['$project' => ['_id'=>true]],
            ['$group' => ['friendship'=>['$addToSet'=>'$_id'], '_id'=>false]]
        ];
        $ids = $this->db->users->aggregate($ops);
        $ids = $ids['result'][0]['friendship'];
        if ($depth > 0) {
            return $this->showDeeper($ids, $depth-1);
        } else {
            return $ids;
        }

    }
}
