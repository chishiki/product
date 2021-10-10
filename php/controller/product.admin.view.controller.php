<?php

final class ProductAdminViewController implements ViewControllerInterface {

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

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;
		$errors = $this->errors;
		$messages = $this->messages;

		if ($loc[0] == 'product' && $loc[1] == 'admin') {

			if ($loc[2] == 'product') {

				$view = new ProductView($loc, $input, $modules, $errors, $messages);

				if ($loc[3] == 'create') { return $view->adminProductForm('create'); }

				if ($loc[3] == 'update' && is_numeric($loc[4])) {

					$productID = $loc[4];

					if ($loc[5] == 'features') {

						$view = new ProductFeatureView($loc, $input, $modules, $errors, $messages);
						return $view->adminProductFeatureForm($productID);

					}

					if ($loc[5] == 'specifications') {

						$view = new ProductSpecificationView($loc, $input, $modules, $errors, $messages);
						return $view->adminProductSpecificationForm($productID);

					}

					if ($loc[5] == 'images') {

						$view = new ImageView($loc, $input, $errors);
						$product = new Product($productID);
						$pv = new ProductView();

						$arg = new NewImageViewParameters();
						$arg->cardHeader = $arg->cardHeader . ' [' . $product->productName() . ']';
						$arg->navtabs = $pv->adminProductFormTabs('update', $productID, 'images');
						$arg->cardContainerDivClasses = array('container');
						$arg->imageObject = 'Product';
						$arg->imageObjectID = $productID;
						$arg->displayDefaultRadio = true;

						return $view->newImageManager($arg);

					}

					if ($loc[5] == 'files') {

						$view = new FileView($loc, $input, $errors);
						$product = new Product($productID);
						$pv = new ProductView();

						$arg = new NewFileViewParameters();
						$arg->cardHeader = $arg->cardHeader . ' [' . $product->productName() . ']';
						$arg->navtabs = $pv->adminProductFormTabs('update', $productID, 'files');
						$arg->cardContainerDivClasses = array('container');
						$arg->fileObject = 'Product';
						$arg->fileObjectID = $productID;

						return $view->newFileManager($arg);

					}

					return $view->adminProductForm('update', $productID);

				}

				if ($loc[3] == 'confirm-delete' && is_numeric($loc[4])) { return $view->adminProductConfirmDelete($loc[4]); }

				$productID = null;
				$arg = new ProductListParameters();
				if (isset($_SESSION['product']['admin']['product']['productID'])) { $arg->productID = $_SESSION['product']['admin']['product']['productID']; }
				return $view->adminProductList($arg);

			}

			if ($loc[2] == 'category') {

				$view = new ProductCategoryView();

				// /product/admin/category/create/
				if ($loc[3] == 'create') { return $view->adminProductCategoryForm('create'); }
	
				// /product/admin/category/update/<productCategoryID>/
				if ($loc[3] == 'update' && is_numeric($loc[4])) { return $view->adminProductCategoryForm('update',$loc[4]); }
	
				// /product/admin/category/confirm-delete/<productCategoryID>/
				if ($loc[3] == 'confirm-delete' && is_numeric($loc[4])) { return $view->adminProductCategoryConfirmDelete($loc[4]); }
	
				// /product/admin/category/
				return $view->adminProductCategoryList();
				
			}

		}

	}

}

?>