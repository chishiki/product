<?php

final class ProductExportController {

	private $loc;
	private $input;
	private $modules;
	
	private $filename;
	private $columns;
	private $rows;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;

		$this->filename = 'export';
		$this->columns = array();
		$this->rows = array();
		
		if ($loc[0] == 'csv' && $loc[1] == 'product') {

			$this->filename = 'product_' . date('Ymd-His');

			$this->columns[0] = Lang::getLang('productID');
			$this->columns[1] = Lang::getLang('productCategoryEnglish');
			$this->columns[2] = Lang::getLang('productCategoryJapanese');
			$this->columns[3] = Lang::getLang('productNameEnglish');
			$this->columns[4] = Lang::getLang('productDescriptionEnglish');
			$this->columns[5] = Lang::getLang('productNameJapanese');
			$this->columns[6] = Lang::getLang('productDescriptionJapanese');
			$this->columns[7] = Lang::getLang('priceLevel') . '1';
			$this->columns[8] = Lang::getLang('priceLevel') . '2';
			$this->columns[9] = Lang::getLang('priceLevel') . '3';
			$this->columns[10] = Lang::getLang('priceLevel') . '4';
			$this->columns[11] = Lang::getLang('productNotes');
			$this->columns[12] = Lang::getLang('productPublished');
			$this->columns[13] = Lang::getLang('productURL');
			$this->columns[14] = Lang::getLang('productFeatured');

			$arg = new ProductListParameters();
			$pl = new ProductList($arg);
			$products = $pl->products();

			foreach ($products AS $productID) {

				$data = array();
				$thisProduct = new Product($productID);
				$thisCategory = new ProductCategory($thisProduct->productCategoryID);

				$data[0] = $thisProduct->productID;
				$data[1] = $thisCategory->productCategoryNameEnglish;
				$data[2] = $thisCategory->productCategoryNameJapanese;
				$data[3] = $thisProduct->productNameEnglish;
				$data[4] = $thisProduct->productDescriptionEnglish;
				$data[5] = $thisProduct->productNameJapanese;
				$data[6] = $thisProduct->productDescriptionJapanese;
				$data[7] = $thisProduct->productUnitPrice1;
				$data[8] = $thisProduct->productUnitPrice2;
				$data[9] = $thisProduct->productUnitPrice3;
				$data[10] = $thisProduct->productUnitPrice4;
				$data[11] = $thisProduct->productNotes;
				$data[12] = $thisProduct->productPublished;
				$data[13] = $thisProduct->productURL;
				$data[14] = $thisProduct->productFeatured;
				$this->rows[] = $data;

			}

		}

	}

	public function filename() {

		return $this->filename;
		
	}
	
	public function columns() {

		return $this->columns;
		
	}
	
	public function rows() {

		return $this->rows;
		
	}

}

?>