<?php
abstract class ConfigurationItem {

	protected $key;

	public function __construct($key) {
		$this->key = $key;
	}

	public function getKey() {
		return $this->key;
	}

}
?>
