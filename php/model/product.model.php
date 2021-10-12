<?php

/*

CREATE TABLE `product_Product` (
  `productID` int NOT NULL AUTO_INCREMENT,
  `productCategoryID` int NOT NULL,
  `siteID` int NOT NULL,
  `creator` int NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int NOT NULL,
  `productNameEnglish` varchar(255) NOT NULL,
  `productDescriptionEnglish` text NOT NULL,
  `productNameJapanese` varchar(255) NOT NULL,
  `productDescriptionJapanese` text NOT NULL,
  `productUnitPrice1` decimal(13,4) NOT NULL,
  `productUnitPrice2` decimal(13,4) NOT NULL,
  `productUnitPrice3` decimal(13,4) NOT NULL,
  `productUnitPrice4` decimal(13,4) NOT NULL,
  `productNotes` text NOT NULL,
  `productPublished` int NOT NULL,
  `productURL` varchar(100) NOT NULL,
  `productFeatured` int NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

*/

final class Product extends ORM {

	public $productID;
	public $productCategoryID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $productNameEnglish;
	public $productDescriptionEnglish;
	public $productNameJapanese;
	public $productDescriptionJapanese;
	public $productUnitPrice1;
	public $productUnitPrice2;
	public $productUnitPrice3;
	public $productUnitPrice4;
	public $productNotes;
	public $productPublished;
	public $productURL;
	public $productFeatured;

	public function __construct($productID = null) {

		$dt = new DateTime();

		$this->productID = 0;
		$this->productCategoryID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->productNameEnglish = '';
		$this->productDescriptionEnglish = '';
		$this->productNameJapanese = '';
		$this->productDescriptionJapanese = '';
		$this->productUnitPrice1 = '';
		$this->productUnitPrice2 = '';
		$this->productUnitPrice3 = '';
		$this->productUnitPrice4 = '';
		$this->productNotes = '';
		$this->productPublished = 1;
		$this->productURL = '';
		$this->productFeatured = 0;


		if ($productID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'productID = :productID';

			$query = 'SELECT * FROM product_Product WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':productID', $productID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function productName() {
		$productName = $this->productNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productNameJapanese)) {
			$productName = $this->productNameJapanese;
		}
		return $productName;
	}

	public function productDescription() {
		$productDescription = $this->productDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productDescriptionJapanese)) {
			$productDescription = $this->productDescriptionJapanese;
		}
		return $productDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('productID' => $this->productID);
		self::update($this, $conditions, true, false, 'hardware_');

	}

}

final class ProductList {

	private $products;

	public function __construct(ProductListParameters $arg) {

		$this->products = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		if ($arg->productID) { $where[] = 'productID = :productID'; }
		if ($arg->productCategoryID) { $where[] = 'productCategoryID = :productCategoryID'; }
		if ($arg->productURL) { $where[] = 'productURL = :productURL'; }
		if ($arg->productPublished === true) { $where[] = 'productPublished = 1'; }
		if ($arg->productPublished === false) { $where[] = 'productPublished = 0'; }
		if ($arg->productFeatured === true) { $where[] = 'productFeatured = 1'; }
		if ($arg->productFeatured === false) { $where[] = 'productFeatured = 0'; }

		$orderBy = array();
		foreach ($arg->orderBy AS $field => $sort) { $orderBy[] = $field . ' ' . $sort; }

		switch ($arg->resultSet) {
			case 'robust':
				$selector = '*';
				break;
			default:
				$selector = 'productID';
		}

		$query = 'SELECT ' . $selector . ' FROM product_Product WHERE ' . implode(' AND ',$where) . ' ORDER BY ' . implode(', ',$orderBy);
		if ($arg->limit) { $query .= ' LIMIT ' . (!is_null($arg->offset)?$arg->offset.', ':'') . $arg->limit; }

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);

		if ($arg->productID) { $statement->bindParam(':productID', $arg->productID, PDO::PARAM_INT); }
		if ($arg->productCategoryID) { $statement->bindParam(':productCategoryID', $arg->productCategoryID, PDO::PARAM_INT); }
		if ($arg->productURL) { $statement->bindParam(':productURL', $arg->productURL, PDO::PARAM_STR); }

		$statement->execute();

		while ($row = $statement->fetch()) {
			if ($arg->resultSet == 'robust') {
				$this->products[] = $row;
			} else {
				$this->products[] = $row['productID'];
			}
		}

	}

	public function products() {

		return $this->products;

	}

	public function productCount() {

		return count($this->products);

	}

}

final class ProductListParameters {

	// list filters
	public $productID;
	public $productCategoryID;
	public $productPublished;
	public $productFeatured;
	public $productURL;

	// view parameters
	public $title;
	public $descriptionConcat;

	public $currentPage;
	public $numberOfPages;

	public $resultSet;
	public $orderBy;
	public $limit;
	public $offset;

	public function __construct() {

		$this->productID = null;
		$this->productCategoryID = null;
		$this->productPublished = null; // [null => either; true => published only; false => not published only]
		$this->productFeatured = null; // [null => either; true => featured only; false => not featured only]
		$this->productURL = null;

		$this->title = array('langKey' => 'hardwareProducts', 'langSelector' => 'session');
		$this->descriptionConcat = null; // ^null$|(^[0-9]+)$

		$this->currentPage = null;
		$this->numberOfPages = null;

		$this->resultSet = 'id'; // [id|robust]
		$this->orderBy = array('created' => 'DESC');
		$this->limit = null;
		$this->offset = null;

	}

}

final class ProductUtilities {

	public static function productUrlExists($productURL) {

		$arg = new ProductListParameters();
		$arg->productURL = $productURL;
		$productList = new ProductList($arg);

		if ($productList->productCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public static function getProductWithURL($productURL) {

		$productID = null;

		$arg = new ProductListParameters();
		$arg->productURL = $productURL;
		$productList = new ProductList($arg);
		$products = $productList->products();

		if (count($products)) {
			$productID = $products[0];
		}

		return $productID;

	}

}

final class ProductModalParameters {

	public $productID;
	public $size;
	public $fieldName;
	public $includeModal;
	public $placeholder;
	public $required;
	public $productModalButtonAnchor;
	public $modalKey;

	public function __construct() {

		$this->productID = null;
		$this->size = null;
		$this->fieldName = 'productID';
		$this->includeModal = true;
		$this->placeholder = 'product';
		$this->required = false;
		$this->productModalButtonAnchor = 'productModalButtonAnchor';
		$this->modalKey = 'product_modal';

	}

}

?>