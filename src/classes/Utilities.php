<?php
namespace KanbanBoard;

class Utilities
{
  const SETTINGS = [
    'GH_REPOSITORIES' => 'Kinomatix',
    'GH_ACCOUNT' => 'drupalmk',
    'GH_CLIENT_ID' => 'd6b970b8a9c42c1b32b9',
    'GH_CLIENT_SECRET' => '61be6c4ba46ac7a02e7f42ccc1a70aa82794633f',
  ];

	private function __construct() {
	}

	public static function env($name, $default = NULL) {

	  if (array_key_exists($name, self::SETTINGS)) {
	    return self::SETTINGS[$name];
    }

		$value = getenv($name);
		if($default !== NULL) {
			if(!empty($value))
				return $value;
			return $default;
		}
		return (empty($value) && $default === NULL) ? die('Environment variable ' . $name . ' not found or has no value') : $value;
	}

	public static function hasValue($array, $key) {
		return is_array($array) && array_key_exists($key, $array) && !empty($array[$key]);
	}

	public static function dump($data) {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}
}