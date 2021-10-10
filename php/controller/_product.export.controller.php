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
		
		if ($loc[0] == 'csv' && $loc[1] == 'products') {

			if ($loc[2] == 'product') {

				$this->filename = 'order_products_' . date('Ymd-His');

				$this->columns[0] = Lang::getLang('id');							// ID
				$this->columns[1] = Lang::getLang('productName');					// 製品名
				$this->columns[2] = Lang::getLang('productDescriptionEnglish');		// 製品明細（英語）
				$this->columns[3] = Lang::getLang('productDescriptionJapanese');	// 製品明細（日本語）
				$this->columns[4] = Lang::getLang('descriptionOfPriceList');		// 価格表記載
				$this->columns[5] = Lang::getLang('priceLevel') . '1';				// 価格 1
				$this->columns[6] = Lang::getLang('priceLevel') . '2';				// 価格 2
				$this->columns[7] = Lang::getLang('priceLevel') . '3';				// 価格 3
				$this->columns[8] = Lang::getLang('priceLevel') . '4';				// 価格 4
				$this->columns[9] = Lang::getLang('productUnitPriceDollar');		// US単価
				$this->columns[10] = Lang::getLang('usCustomerUnitPrice');			// US仕入価格
				$this->columns[11] = Lang::getLang('productNumber');				// プロダクト番号

				$pl = new ProductList(false, null, 0, 10000);
				$products = $pl->products();

				foreach ($products AS $productID) {

					$data = array();
					$thisProduct = new Product($productID);

					$data[0] = $thisProduct->productID;						// ID
					$data[1] = $thisProduct->productName;				 	// 製品名
					$data[2] = $thisProduct->productDescriptionEnglish; 	// 製品明細（英語）
					$data[3] = $thisProduct->productDescriptionJapanese;	// 製品明細（日本語）
					$data[4] = $thisProduct->descriptionOfPriceList;    	// 価格表記載
					$data[5] = $thisProduct->productUnitPriceYen1;			// 価格 1
					$data[6] = $thisProduct->productUnitPriceYen2;			// 価格 2
					$data[7] = $thisProduct->productUnitPriceYen3;			// 価格 3
					$data[8] = $thisProduct->productUnitPriceYen4;			// 価格 4
					$data[9] = $thisProduct->productUnitPriceDollar;		// US単価
					$data[10] = $thisProduct->usCustomerUnitPrice;			// US仕入価格
					$data[11] = $thisProduct->productNumber;				// プロダクト番号
					$this->rows[] = $data;

				}

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