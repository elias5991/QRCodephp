<?php

class Account
{
    public $id,         // int
        $email,         // string
        $type,  
        $typeID        // int
        $password,      // string
        $firstName,     // string
        $lastName,      // string
        $role,          // string
        $roleID,
        $phoneNumber;   // string

    public function __construct($id, $email,$type,$typeID,$password,$firstName, $lastName, $role,$roleID, $phoneNumber)
    {
        $this-> id = $id;
        $this->email = $email;
        $this->type = $type;
        $this->typeID =$typeID;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->roleID =$roleID;
        $this->phoneNumber =$phoneNumber;
    }

    public static function getByEmail($mysqli, $email)
    {
        $query = "select 
        a.user_id,
        a.email,
        t.type,
        a.password,
        a.firstName,
        a.lastName,
        r.role,
        a.phone_number
        from account a, role r, account_type t where email = '" . $email . "' and a.role_id=r.id and a.type_id=t.id;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return null;
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $result = $result[0];
        return new Account(
            $result['user_id'], $result['email'], $result['type'],null, $result['password'],
            $result['firstName'], $result['lastName'], $result['role'],null, $result['phone_number']
        );
    }

    public static function getAllUsers($mysqli)
    {
        $values = array();
        $query = "select 
        a.user_id,
        a.email,
        t.type,
        a.password,
        a.firstName,
        a.lastName,
        r.role,
        a.phone_number
        from account a, role r, account_type t where  a.role_id=r.id and a.type_id=t.id;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($values, new Account(
                $result['user_id'], $result['email'], $result['type'],null, $result['password'],
                $result['firstName'], $result['lastName'], $result['role'],null, $result['phone_number']
            ));
        }
        return $values;
    }


    public function create($mysqli)
    {
        $query = "insert into account set email ='". $this->email ."', type_id ='". $this->typeID ."', password= '" . $this->password ."', firstName='" . $this->firstName . "',lastName ='". $this->lastName."', role_id='" . $this->roleID ."', phone_number='" . $this->phoneNumber . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }
    
    public function valueExists($mysqli)
    {
        $query = "select * from account where email ='". $this->email ."'and type_id ='". $this->typeID ."'and firstName='" . $this->firstName . "'andlastName ='". $this->lastName."'and role_id='" . $this->roleID ."'and phone_number='" . $this->phoneNumber . "';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function idExists($mysqli)
    {
        $query = "select * from account where id ='".$this->id ."';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function edit($mysqli)
    {
        $query = "update account  set email ='". $this->email ."', type_id ='". $this->typeID ."', password= '" . $this->password ."', firstName='" . $this->firstName . "',lastName ='". $this->lastName."', role_id='" . $this->roleID ."', phone_number='" . $this->phoneNumber . "' where user_id=".$this->id.";";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }

    public function sameValue($mysqli)
    {
        $query = "select * from acount where user_id =" .$this->id ." and email ='". $this->email ."'and type_id ='". $this->typeID ."'and firstName='" . $this->firstName . "'andlastName ='". $this->lastName."'and role_id='" . $this->roleID ."'and phone_number='" . $this->phoneNumber . "';";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return false;
        return true;
    }

    public function delete($mysqli)
    {
        $query = "delete from account where user_id = '" . $this->id . "';";
        if (mysqli_query($mysqli, $query)) return true;
        return false;
    }


}