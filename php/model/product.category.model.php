<?php

/*

CREATE TABLE `product_ProductCategory` (
  `productCategoryID` int(12) NOT NULL AUTO_INCREMENT,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `productCategoryNameEnglish` varchar(255) NOT NULL,
  `productCategoryDescriptionEnglish` text NOT NULL,
  `productCategoryNameJapanese` varchar(255) NOT NULL,
  `productCategoryDescriptionJapanese` text NOT NULL,
  `productCategoryPublished` int(1) NOT NULL,
  `productCategoryURL` varchar(100) NOT NULL,
  `productCategoryDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`productCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class ProductCategory extends ORM {

	public $productCategoryID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $productCategoryNameEnglish;
	public $productCategoryDescriptionEnglish;
	public $productCategoryNameJapanese;
	public $productCategoryDescriptionJapanese;
	public $productCategoryPublished;
	public $productCategoryURL;
	public $productCategoryDisplayOrder;

	public function __construct($productCategoryID = null) {

		$dt = new DateTime();

		$this->productCategoryID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->productCategoryNameEnglish = '';
		$this->productCategoryDescriptionEnglish = '';
		$this->productCategoryNameJapanese = '';
		$this->productCategoryDescriptionJapanese = '';
		$this->productCategoryPublished = 0;
		$this->productCategoryURL = '';
		$this->productCategoryDisplayOrder = 0;

		if ($productCategoryID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'productCategoryID = :productCategoryID';

			$query = 'SELECT * FROM product_ProductCategory WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':productCategoryID', $productCategoryID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function productCategoryName() {
		$productCategoryName = $this->productCategoryNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productCategoryNameJapanese)) {
			$productCategoryName = $this->productCategoryNameJapanese;
		}
		return $productCategoryName;
	}

	public function productCategoryDescription() {
		$productCategoryDescription = $this->productCategoryDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productCategoryDescriptionJapanese)) {
			$productCategoryDescription = $this->productCategoryDescriptionJapanese;
		}
		return $productCategoryDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('productCategoryID' => $this->productCategoryID);
		self::update($this, $conditions, true, false, 'hardware_');

	}

}

final class ProductCategoryList {

	private $productCategories;

	public function __construct() {

		$this->productCategories = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		$query = 'SELECT productCategoryID FROM product_ProductCategory WHERE ' . implode(' AND ',$where) . ' ORDER BY productCategoryDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->productCategories[] = $row['productCategoryID'];
		}

	}

	public function productCategories() {

		return $this->productCategories;

	}

	public function productCategoryCount() {

		return count($this->productCategories);

	}

}

?>