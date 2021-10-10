<?php

/*

CREATE TABLE `product_ProductFeature` (
  `productFeatureID` int(12) NOT NULL AUTO_INCREMENT,
  `productID` int(12) NOT NULL,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `productFeatureNameEnglish` varchar(255) NOT NULL,
  `productFeatureDescriptionEnglish` text NOT NULL,
  `productFeatureNameJapanese` varchar(255) NOT NULL,
  `productFeatureDescriptionJapanese` text NOT NULL,
  `productFeaturePublished` int(1) NOT NULL,
  `productFeatureDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`productFeatureID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class ProductFeature extends ORM {

	public $productFeatureID;
	public $productID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $productFeatureNameEnglish;
	public $productFeatureDescriptionEnglish;
	public $productFeatureNameJapanese;
	public $productFeatureDescriptionJapanese;
	public $productFeaturePublished;
	public $productFeatureDisplayOrder;

	public function __construct($productFeatureID = null) {

		$dt = new DateTime();

		$this->productFeatureID = 0;
		$this->productID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->productFeatureNameEnglish = '';
		$this->productFeatureDescriptionEnglish = '';
		$this->productFeatureNameJapanese = '';
		$this->productFeatureDescriptionJapanese = '';
		$this->productFeaturePublished = 0;
		$this->productFeatureDisplayOrder = 0;

		if ($productFeatureID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'productFeatureID = :productFeatureID';

			$query = 'SELECT * FROM product_ProductFeature WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':productFeatureID', $productFeatureID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function productFeatureName() {
		$productFeatureName = $this->productFeatureNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productFeatureNameJapanese)) {
			$productFeatureName = $this->productFeatureNameJapanese;
		}
		return $productFeatureName;
	}

	public function productFeatureDescription() {
		$productFeatureDescription = $this->productFeatureDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->productFeatureDescriptionJapanese)) {
			$productFeatureDescription = $this->productFeatureDescriptionJapanese;
		}
		return $productFeatureDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('productFeatureID' => $this->productFeatureID);
		self::update($this, $conditions, true, false, 'product_');

	}

}

final class ProductFeatureList {

	private $features;

	public function __construct($productID) {

		$this->features = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';
		$where[] = 'productID = :productID';

		$query = 'SELECT productFeatureID FROM product_ProductFeature WHERE ' . implode(' AND ',$where) . ' ORDER BY productFeatureDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->bindParam(':productID', $productID, PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->features[] = $row['productFeatureID'];
		}

	}

	public function features() {

		return $this->features;

	}

	public function featureCount() {

		return count($this->features);

	}

}

?>