<?php

class InventoryType
{
    public $id,     // int
        $type;      // string

    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Returns an array of answer types.
     */
    public static function getInvTypes($mysqli)
    {
        $invTypes = array();
        $query = "select * from inventory_type;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($invTypes, new InventoryType($r["id"], $r["type"]));
        }
        return $invTypes;
    }
    
}
