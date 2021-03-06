<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 3:46 PM
 */

namespace Model;

class User extends AbstractModel
{

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function create($user)
    {
        return $this->db->users->save($user);
    }

    public function get($userId)
    {
        $mongoId = new \MongoId($userId);
        return $this->db->users->findOne(['_id' => $mongoId]);
    }

    public function all()
    {
        return $this->db->users->find();
    }
}
