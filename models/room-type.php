<?php

class RoomType
{
    public $id,         // int
           $value;      // string

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    
    public static function getRoomType($mysqli)
    {
        $values = array();
        $query = "select * from room_type;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($values, new RoomType($r["id"], $r["type"]));
        }
        return $values;
    }


    public function create($mysqli)
    {
        $query = "insert into room_type set type='". $this->value ."';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }
    
    public function valueExists($mysqli)
    {
        $query = "select * from room_type where type = '" . $this->value ."';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function edit($mysqli)
    {
        $query = "update room_type set type =  '" . $this->value . "' where id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

    public function sameValue($mysqli)
    {
        $query = "select * from room_type where type = '" . $this->value ."'and id = '" . $this->id . "';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function delete($mysqli)
    {
        $query = "delete from room_type where id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

}
