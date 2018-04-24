<?php

$errors = array();
if(strlen($user) > 10 || is_numeric($user) || empty(trim($user)))
{
$errors[] = "FirstName must Be less than   <strong> 10 </strong> characters and not be integer and not be empty";
}


if(strlen($Lastname) > 7 || is_numeric($Lastname) || empty(trim($Lastname)))
{
$errors[] = "Lastname must Be less than   <strong> 7 </strong> characters and not be integer and not be empty";
}
if(strlen($Username) > 10 || empty(trim($Username)))
{
$errors[] = "Username must Be less than   <strong> 10 </strong> characters and not be empty";
}
if(strlen($Address) > 25 || empty(trim($Address)))
{
$errors[] = "Address must Be less than   <strong> 20 </strong> characters and not be empty";
}
if(strlen($Phone) > 18 || empty(trim($Phone)))
{
$errors[] = "Phone must Be less than   <strong> 15 </strong> characters and not be empty";

}
/*if(empty(trim($Mail))){
$errors[] = "Mail not be empty";
}
if($Password  != $PasswordAgain || empty(trim($Password)))
{
$errors[] = "password not mattach and not be empty";
}


if(in_array($Username,$usernamedb))
{
$errors[] = "username is Used";
}
if(in_array($Mail,$usermaildb)){
$errors[] = "Mail is not valid";
}
*/

