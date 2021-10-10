<?php

final class ProductPDF {

	private $doc;
	private $fileObject;
	private $fileObjectID;

	public function __construct($loc, $input) {

		if ($loc[2] == 'product' && ctype_digit($loc[3])) {
			$sov = new ProductsView($loc, $input);
			$doc = $sov->productPrint($loc[3]);
			$fileObject = 'Product';
			$fileObjectID = $loc[3];
		}

		$this->doc = $doc;
		$this->fileObject = $fileObject;
		$this->fileObjectID = $fileObjectID;

	}

	public function doc() {

		return $this->doc;

	}

	public function getFileObject() {

		return $this->fileObject;

	}

	public function getFileObjectID() {

		return $this->fileObjectID;

	}

}

?>