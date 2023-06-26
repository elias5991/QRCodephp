<?php

class Room
{
    public $id,         // int
           $name,       // string
           $typeID,
           $type,
           $space,
           $departmentID,
           $department,
           $facultyID,
           $faculty;

    public function __construct($id, $name,$typeID,$type,$space,$departmentID,$department,$facultyID,$faculty)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeID = $typeID;
        $this->type = $type;
        $this->space = $space;
        $this->department = $department;
        $this->departmentID = $departmentID;
        $this->facultyID = $facultyID;
        $this->faculty = $faculty;
    }

    
    public static function getRoom($mysqli)
    {
        $values = array();
        $query = "select 
        r.id,
        r.name as room_name,
        r.type_id,
        rt.type,
        r.space,
        r.department_id,
        d.name as department_name,
        r.faculty_id,
        f.name as faculty_name
        from room r
        join room_type rt on r.type_id=rt.id
        join department d on d.id=r.department_id
        join faculty f on f.id =r.faculty_id;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($values, new Room($r["id"], $r["room_name"], 
            $r["type_id"], $r["type"],$r["space"],$r["department_id"],$r["department_name"]
            ,$r["faculty_id"],$r["faculty_name"]));
        }
        return $values;
    }


    public function create($mysqli)
    {
        $query = "insert into room set name ='". $this->name ."', type_id ='". $this->typeID ."', space= '" . $this->space ."', department_id='" . $this->departmentID . "',faculty_id ='". $this->facultyID."';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }
    
    public function valueExists($mysqli)
    {
        $query = "select * from room where name ='".$this->name ."' and type_id=". $this->typeID ." and space =".$this->space." and department_id=".$this->departmentID." and faculty_id='".$this->facultyID ."';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function idExists($mysqli)
    {
        $query = "select * from room where id ='".$this->id ."';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function edit($mysqli)
    {
        $query = "update room  set name ='". $this->name ."', type_id ='". $this->typeID ."', space= '" . $this->space ."' where id=".$this->id.";";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

    public function sameValue($mysqli)
    {
        $query = "select * from room where id =" .$this->id ." and name ='".$this->name ."' and type_id=". $this->typeID ." and space =".$this->space." and department_id=".$this->departmentID." and faculty_id=".$this->facultyID .";";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function delete($mysqli)
    {
        $query = "delete from room where id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

    public function getRoomById($mysqli)
    {
        $query = "select 
        r.id,
        r.name as room_name,
        r.type_id,
        rt.type,
        r.space,
        r.department_id,
        d.name as department_name,
        r.faculty_id,
        f.name as faculty_name
        from room r
        join room_type rt on r.type_id=rt.id
        join department d on d.id=r.department_id
        join faculty f on f.id =r.faculty_id
        where r.id=".$this->id.";";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $result = $result[0];
        return new Room($result["id"], $result["room_name"], 
            $result["type_id"], $result["type"],$result["space"],$result["department_id"],$result["department_name"]
            ,$result["faculty_id"],$result["faculty_name"]);
       
    }

}
