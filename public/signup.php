<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('greensight');
$logger->pushHandler(new StreamHandler('/greensight/logs/greensight.log', Level::Debug));

$users = [
	["id" => 0, "first_name" => "Widjan", "last_name" => "Gorton", "email" => "widj.go@arvinmeritor.info"],
	["id" => 1, "first_name" => "Lovell", "last_name" => "Blessing", "email" => "lovblessing@careful-organics.org"],
	["id" => 2, "first_name" => "Marieke", "last_name" => "Blessing", "email" => "mar-bl@diaperstack.com"],
];

class SignupFormValidator {
	private $fields = ["first_name", "last_name", "email", "password", "passwordConfirmation"];
	private $response = null;

	private function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	private function validatePassword($password, $password_confirmation)
	{
		return $password == $password_confirmation;
	}

	private function getField($data, $field_name)
	{
		return isset($data[$field_name]) ? $data[$field_name] : null;
	}

	public function validate($request) {
		global $logger, $users;

		$registration_data = array();
		foreach ($this->fields as $i => $value) {
			$registration_data[$value] = $this->getField($request, $value);
		}

		if (in_array(null, $registration_data)) {
			$this->response = json_encode([
				"status" => "error", "message" => "Please, fill all required fields"
			]);
			return;
		} 

		$email_column = array_column($users, "email");
		$found_key = array_search($registration_data["email"], $email_column);

		if (!$this->validateEmail($registration_data["email"])) {
			$this->response = json_encode([
				"status" => "error", "message" => "Please, enter valid email"
			]);
		} else if (!$this->validatePassword($registration_data["password"], $registration_data["passwordConfirmation"])) {
			$this->response = json_encode([
				"status" => "error", "message" => "Passwords do not match, please try again"
			]);
		} else if ($found_key !== false) {
			$logger->info("User with email " . $users[$found_key]["email"] . " was found:", $users[$found_key]);
			$this->response = json_encode([
				"status" => "error", "message" => "User with given email already exists"
			]);
		} else {
			$this->response = json_encode([ "status" => "success" ]);
		}
	}

	public function response(): string {
		return $this->response;
	}
}

$validator = new SignupFormValidator();
$validator->validate($_POST);
echo $validator->response();

?>