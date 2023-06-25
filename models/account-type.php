<?php

class AccountType
{
    public $id,     // int
        $value;      // string

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Returns an array of answer types.
     */
    public static function getAccTypes($mysqli)
    {
        $accTypes = array();
        $query = "select * from account_type;";
        $result = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($result) < 1) return [];
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($result as $r) {
            array_push($accTypes, new AccountType($r["id"], $r["type"]));
        }
        return $accTypes;
    }
    
}
