<?php

class Role
{
    public $id,     // int
        $role;      // string

    public function __construct($id, $role)
    {
        $this->id = $id;
        $this->role = $role;
    }

    /**
     * Returns an array of answer types.
     */
    public static function getRoles($mysqli)
    {
        $roleTypes = array();
        $query = "select * from role;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($roleTypes, new Role($r["id"], $r["role"]));
        }
        return $roleTypes;
    }
    
}
