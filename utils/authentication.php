<?php

require_once('../models/account.php');

function isAdmin($mysqli, $userId)
{
    $account = Account::getById($mysqli, $userId);
    if ($account->type == "Admin") return true;
    return false;
}
