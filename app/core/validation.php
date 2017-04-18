<?php

class Validation {
	static function login($e){
		$error = false;

		if(!preg_match("/^[a-zA-Zа-яА-ЯіІєЄїЇьЬ0-9 ]+$/", $e)){
			$error .= "Ім'я містить недопустимі символи. ";
		}

		if(strlen($e) < 2 or strlen($e) > 30){
			$error .= "Ім'я повинне бути не менше 2-х символів та не більше 30. ";
		}

		return $error;
	}

	static function password($e){
		$error = false;

		if(strlen($e) < 4 or strlen($e) > 20){
			$error .= "Пароль повинен бути не менше 4-х символів та не більше 20. ";
		}

		if(!preg_match("/^[a-zA-Zа-я0-9]+$/", $e)){
			$error .= "Пароль може містити лише англійські букви та цифри. ";
		}

		return $error;
	}
}