<?php

final class ProductMainViewController implements ViewControllerInterface {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules, $errors, $messages) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages =  $messages;

	}
	
	public function getView() {

		if ($this->loc[0] == 'product' && !empty($this->loc[1])) {

			$productID = ProductUtilities::getProductWithURL($this->loc[1]);
			if (!is_null($productID)) {
				$view = new ProductView();
				return $view->productView($productID);
			}

		}

	}

}

?>