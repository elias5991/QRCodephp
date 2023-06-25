<?php

class Faculty
{
    public $id,         // int
           $value;      // string

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    
    public static function getFaculties($mysqli)
    {
        $values = array();
        $query = "select * from faculty;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($values, new Faculty($r["id"], $r["name"]));
        }
        return $values;
    }

}
