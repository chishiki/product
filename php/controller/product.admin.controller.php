<?php

final class ProductAdminController implements StateControllerInterface {

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

		// let's only allow logged in users to view product pages
		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;

		if ($loc[0] == 'product' && $loc[1] == 'admin') {

			if ($loc[2] == 'product') {

				// /product/admin/product/create/
				if ($loc[3] == 'create' && isset($input['product-create'])) {

					$this->validateProductURL($input['productURL'], 'create');

					if (empty($this->errors)) {

						$product = new Product();
						foreach ($input as $property => $value) {
							if (isset($product->$property)) {
								$product->$property = $value;
							}
						}
						Product::insert($product, false, 'product_');
						$successURL = '/' . Lang::prefix() . 'product/admin/product/';
						header("Location: $successURL");

					}

				}

				// /product/admin/product/update/<productID>/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && isset($input['product-update'])) {

					$productID = $loc[4];

					$this->validateProductURL($input['productURL'], 'update', $productID);

					if (empty($this->errors)) {

						$product = new Product($productID);
						$product->updated = date('Y-m-d H:i:s');
						foreach ($input as $property => $value) {
							if (isset($product->$property)) {
								$product->$property = $value;
							}
						}
						$conditions = array('productID' => $productID);
						Product::update($product, $conditions, true, false, 'product_');
						$this->messages[] = Lang::getLang('productUpdateSuccessful');

					}

				}

				// /product/admin/product/update/<productID>/features/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && $loc[5] == 'features' && isset($input['add-product-feature'])) {

					$productID = $loc[4];

					// $this->errors (add validation here: ok to update?)
					// $this->errors[] = array('product-update' => Lang::getLang('thereWasAProblemUpdatingYourProductFeature'));

					if (empty($this->errors)) {

						$feature = new ProductFeature();
						$feature->productID = $productID;
						$feature->productFeaturePublished = 1;
						$feature->productFeatureDisplayOrder = 1;
						foreach ($input as $property => $value) {
							if (isset($feature->$property)) {
								$feature->$property = $value;
							}
						}
						ProductFeature::insert($feature, false, 'product_');

					}

				}

				// /product/admin/product/update/<productID>/specifications/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && $loc[5] == 'specifications' && isset($input['add-product-specification'])) {

					$productID = $loc[4];

					// $this->errors (add validation here: ok to update?)
					// $this->errors[] = array('product-update' => Lang::getLang('thereWasAProblemUpdatingYourProductSpecification'));

					if (empty($this->errors)) {

						$specification = new ProductSpecification();
						$specification->productID = $productID;
						$specification->productSpecificationPublished = 1;
						$specification->productSpecificationDisplayOrder = 1;
						foreach ($input as $property => $value) {
							if (isset($specification->$property)) {
								$specification->$property = $value;
							}
						}
						ProductSpecification::insert($specification, false, 'product_');

					}

				}

				// /product/admin/product/update/<productID>/images/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && $loc[5] == 'images' && isset($input['submitted-images'])) {

					$productID = $loc[4];
					// $this->errors (add validation here: ok to upload?)
					// $this->errors[] = array('product-update' => Lang::getLang('thereWasAProblemAddingYourProductImages'));
					Image::uploadImages($_FILES['images-to-upload'], 'Product', $productID, false);

				}

				// /product/admin/product/update/<productID>/files/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && $loc[5] == 'files' && isset($input['submitted-files'])) {

					$productID = $loc[4];
					// $this->errors (add validation here: ok to upload?)
					// $this->errors[] = array('product-update' => Lang::getLang('thereWasAProblemAddingYourProductFiles'));
					File::uploadFiles($_FILES['files-to-upload'], 'Product', $productID, $input['fileTitleEnglish'], $input['fileTitleJapanese']);

				}

				// /product/admin/product/delete/<productID>/
				if ($loc[3] == 'delete' && is_numeric($loc[4]) && isset($input['product-delete'])) {

					$productID = $loc[4];

					if ($input['productID'] != $productID) {
						$this->errors[] = array('product-delete' => Lang::getLang('thereWasAProblemDeletingYourProduct'));
					}

					if (empty($this->errors)) {

						$product = new Product($productID);
						$product->markAsDeleted();
						$this->messages[] = Lang::getLang('productDeleteSuccessful');

					}

				}

			}

			if ($loc[2] == 'category') {

				// /product/admin/category/create/
				if ($loc[3] == 'create' && isset($input['product-category-create'])) {

					// $this->errors (add validation here: ok to create?)
					// $this->errors[] = array('product-category-create' => Lang::getLang('thereWasAProblemCreatingYourHardwareProductCategory'));

					if (empty($this->errors)) {

						$category = new ProductCategory();
						foreach ($input AS $property => $value) { if (isset($category->$property)) { $category->$property = $value; } }
						ProductCategory::insert($category, false, 'product_');
						$successURL = '/' . Lang::prefix() . 'product/admin/category/';
						header("Location: $successURL");

					}

				}

				// /product/admin/category/update/<productID>/
				if ($loc[3] == 'update' && is_numeric($loc[4]) && isset($input['product-category-update'])) {

					$productCategoryID = $loc[4];

					// $this->errors (add validation here: ok to update?)
					// $this->errors[] = array('product-category-update' => Lang::getLang('thereWasAProblemUpdatingYourHardwareProductCategory'));

					if (empty($this->errors)) {

						$category = new ProductCategory($productCategoryID);
						$category->updated = date('Y-m-d H:i:s');
						foreach ($input AS $property => $value) { if (isset($category->$property)) { $category->$property = $value; } }
						$conditions = array('productCategoryID' => $productCategoryID);
						ProductCategory::update($category, $conditions, true, false, 'product_');
						$this->messages[] = Lang::getLang('productCategoryUpdateSuccessful');

					}

				}

				// /product/admin/category/delete/<categoryID>/
				if ($loc[3] == 'delete' && is_numeric($loc[4]) && isset($input['product-category-confirm-delete'])) {

					$productCategoryID = $loc[4];

					if ($input['productCategoryID'] != $productCategoryID) {
						$this->errors[] = array('product-category-delete' => Lang::getLang('thereWasAProblemDeletingYourHardwareProductCategory'));
					}

					if (empty($this->errors)) {

						$category = new ProductCategory($productCategoryID);
						$category->markAsDeleted();
						$successURL = '/' . Lang::prefix() . 'product/admin/category/';
						header("Location: $successURL");

					}

				}


			}

		}

	}

	private function validateProductURL($productURL, $type, $productID = null) {

		if (empty($productURL)) {
			$this->errors[] = array('productURL' => Lang::getLang('productUrlMustBeSet'));
		} else {
			if (ProductUtilities::productUrlExists($productURL)) {
				if ($type == 'update' && is_numeric($productID)) {
					$product = new Product($productID);
					if ($product->productURL != $productURL) {
						$this->errors[] = array('productURL' => Lang::getLang('newsUrlAlreadyUsedByAnotherNewsItem'));
					}
				} else {
					$this->errors[] = array('productURL' => Lang::getLang('productUrlAlreadyExists'));
				}
			}
			if (!preg_match('/^[A-Za-z0-9-]+$/D', $productURL)) {
				$this->errors[] = array('productURL' => Lang::getLang('onlyAlphanumericAndHyphenInputAreAllowedInTheUrlField'));
			}
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