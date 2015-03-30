<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 3/29/15
 * Time: 10:53 PM
 */

namespace Model;

abstract class AbstractModel
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    protected function showAll($cursor) {
        $result = [];
        foreach($cursor as $element) {
            $result[] = $element;
        }
        return $result;
    }
}