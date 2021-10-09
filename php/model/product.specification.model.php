<?php

/*

CREATE TABLE `product_ProductSpecification` (
  `productSpecificationID` int(12) NOT NULL AUTO_INCREMENT,
  `productID` int(12) NOT NULL,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `productSpecificationNameEnglish` varchar(255) NOT NULL,
  `productSpecificationDescriptionEnglish` text NOT NULL,
  `productSpecificationNameJapanese` varchar(255) NOT NULL,
  `productSpecificationDescriptionJapanese` text NOT NULL,
  `productSpecificationPublished` int(1) NOT NULL,
  `productSpecificationDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`productSpecificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class ProductSpecification extends ORM {

	public $productSpecificationID;
	public $productID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $productSpecificationNameEnglish;
	public $productSpecificationDescriptionEnglish;
	public $productSpecificationNameJapanese;
	public $productSpecificationDescriptionJapanese;
	public $productSpecificationPublished;
	public $productSpecificationDisplayOrder;

	public function __construct($productSpecificationID = null) {

		$dt = new DateTime();

		$this->productSpecificationID = 0;
		$this->productID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->productSpecificationNameEnglish = '';
		$this->productSpecificationDescriptionEnglish = '';
		$this->productSpecificationNameJapanese = '';
		$this->productSpecificationDescriptionJapanese = '';
		$this->productSpecificationPublished = 0;
		$this->productSpecificationDisplayOrder = 0;

		if ($productSpecificationID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'productSpecificationID = :productSpecificationID';

			$query = 'SELECT * FROM product_ProductSpecification WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':productSpecificationID', $productSpecificationID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function productSpecificationName() {
		$productSpecificationName = $this->productSpecificationNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productSpecificationNameJapanese)) {
			$productSpecificationName = $this->productSpecificationNameJapanese;
		}
		return $productSpecificationName;
	}

	public function productSpecificationDescription() {
		$productSpecificationDescription = $this->productSpecificationDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productSpecificationDescriptionJapanese)) {
			$productSpecificationDescription = $this->productSpecificationDescriptionJapanese;
		}
		return $productSpecificationDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('productSpecificationID' => $this->productSpecificationID);
		self::update($this, $conditions, true, false, 'hardware_');

	}

}

final class ProductSpecificationList {

	private $specifications;

	public function __construct($productID) {

		$this->specifications = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';
		$where[] = 'productID = :productID';

		$query = 'SELECT productSpecificationID FROM product_ProductSpecification WHERE ' . implode(' AND ',$where) . ' ORDER BY productSpecificationDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->bindParam(':productID', $productID, PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->specifications[] = $row['productSpecificationID'];
		}

	}

	public function specifications() {

		return $this->specifications;

	}

	public function specificationCount() {

		return count($this->specifications);

	}

}

?>