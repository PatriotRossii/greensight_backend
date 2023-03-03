<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('greensight');
$logger->pushHandler(new StreamHandler('/greensight/app.log', Level::Debug));

$users = [
	["id" => 0, "first_name" => "Widjan", "last_name" => "Gorton", "email" => "widj.go@arvinmeritor.info"],
	["id" => 1, "first_name" => "Lovell", "last_name" => "Blessing", "email" => "lovblessing@careful-organics.org"],
	["id" => 2, "first_name" => "Marieke", "last_name" => "Blessing", "email" => "mar-bl@diaperstack.com"],
];

function validateEmail($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password, $password_confirmation)
{
	return $password == $password_confirmation;
}

function getField($data, $field_name)
{
	return isset($data[$field_name]) ? $data[$field_name] : null;
}

$fields = ["first_name", "last_name", "email", "password", "passwordConfirmation"];
$registration_data = array();
foreach ($fields as $i => $value) {
	$registration_data[$value] = getField($_POST, $value);
}

if (in_array(null, $registration_data)) {
	echo json_encode([
		"status" => "error", "message" => "Please, fill all required fields"
	]);
	exit(1);
}
if (!validateEmail($registration_data["email"])) {
	echo json_encode([
		"status" => "error", "message" => "Please, enter valid email"
	]);
	exit(1);
}
if (!validatePassword($registration_data["password"], $registration_data["passwordConfirmation"])) {
	echo json_encode([
		"status" => "error", "message" => "Passwords do not match, please try again"
	]);
	exit(1);
}

$email_column = array_column($users, "email");
$found_key = array_search($registration_data["email"], $email_column);
if ($found_key !== false) {
	$logger->info("User with email " . $users[$found_key]["email"] . " was found:", $users[$found_key]);
	echo json_encode([
		"status" => "error", "message" => "User with given email already exists"
	]);
	exit(1);
}

echo json_encode([ "status" => "success" ]);

?>