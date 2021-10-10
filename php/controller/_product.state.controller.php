<?php

final class ProductController implements StateControllerInterface {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = array();
		$this->messages =  array();

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;

		if ($this->loc[0] == 'product') {

			if ($loc[1] == 'admin') { $controller = new ProductAdminController($loc,$input,$modules); }
			else { $controller = new ProductMainController($loc,$input,$modules); }

		}

		if (isset($controller)) {
			$controller->setState();
			$this->errors = $controller->getErrors();
			$this->messages = $controller->getMessages();
		}

	}

	public function getErrors() {
		return $this->errors;
	}

	public function getMessages() {
		return $this->messages;
	}

}

?>