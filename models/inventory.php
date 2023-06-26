<?php

class Inventory
{
    public $id,        // int
        $type_id, 
        $type,     // int
        $description;  // string

    public function __construct($id, $type_id,$type, $description)
    {
        $this->id = $id;
        $this->type_id = $type_id;
        $this->type = $type;
        $this->description =$description;
    }

    /**
     * Returns an array of answer types.
     */
    public static function getInventories($mysqli)
    {
        $inventories = array();
        $query = "select i.id,i.type_id,it.type,i.description from inventory i join inventory_type it on i.type_id=it.id;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($inventories, new Inventory($r["id"], $r["type_id"],$r["type"], $r["description"]));
        }
        return $inventories;
    }
    
}
