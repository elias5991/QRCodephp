<?php

class Department
{
    public $id,         // int
           $value;      // string

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    
    public static function getDepartment($mysqli)
    {
        $values = array();
        $query = "select * from department;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($values, new Department($r["id"], $r["name"]));
        }
        return $values;
    }


    public function create($mysqli)
    {
        $query = "insert into department set name='". $this->value ."';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }
    
    public function valueExists($mysqli)
    {
        $query = "select * from department where name = '" . $this->value ."';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function edit($mysqli)
    {
        $query = "update department set name =  '" . $this->value . "' where id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

    public function sameValue($mysqli)
    {
        $query = "select * from department where name = '" . $this->value ."'and id = '" . $this->id . "';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function delete($mysqli)
    {
        $query = "delete from department where id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

}
