<?php

final class ProductSpecificationView {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc = array(), $input = array(), $modules = array(), $errors = array(), $messages = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages = $messages;

	}

	public function adminProductSpecificationForm($productID) {

		$product = new Product($productID);
		$newSpecification = new ProductSpecification();

		$hpv = new ProductView();
		$form = $hpv->adminProductFormTabs('update', $productID, 'specifications');

		$hpfl = new ProductSpecificationList($productID);
		$specifications = $hpfl->specifications();
		if (!empty($specifications)) {
			$form .= '<ul id="admin_product_specification_list" class="list-group">';
			foreach ($specifications as $productSpecificationID) {
				$specification = new ProductSpecification($productSpecificationID);
				$form .= '
					<li class="list-group-item admin-product-specification-list-item d-flex justify-content-between align-items-center" data-product-specification-id="' . $productSpecificationID . '">
						<span class="drag-handle btn btn-outline-secondary mr-3"><span class="fas fa-grip-lines"></span></span>
						<span class="flex-grow-1 d-block">
								<span class="admin-product-specification-name d-block">' . $specification->productSpecificationName() . '</span>
								<span class="admin-product-specification-description d-none d-md-block"><small>' . $specification->productSpecificationDescription() . '</small></span>
						</span>
						<button type="button" class="btn btn-danger delete-product-specification ml-3"><span class="far fa-trash-alt"></span></button>
					</li>';
			}
			$form .= '</ul>';
			$form .= '<hr />';
		}

		$form .= '

			<form id="product_specification_manager_form" method="post" action="/' . Lang::prefix() . 'product/admin/product/update/' . $productID . '/specifications/">

				<div class="form-row">
				
					<div class="form-group col-12 col-lg-4 col-xl-3">
						<label for="productSpecificationNameEnglish">' . Lang::getLang('productSpecificationNameEnglish') . '</label>
						<input type="text" class="form-control" name="productSpecificationNameEnglish" value="' . $newSpecification->productSpecificationNameEnglish . '"">
					</div>

					<div class="form-group col-12 col-lg-8 col-xl-9">
						<label for="productSpecificationDescriptionEnglish">' . Lang::getLang('productSpecificationDescriptionEnglish') . '</label>
						<input type="text" class="form-control" name="productSpecificationDescriptionEnglish" value="' . $newSpecification->productSpecificationDescriptionEnglish . '">
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">

					<div class="form-group col-12 col-lg-4 col-xl-3">
						<label for="productSpecificationNameJapanese">' . Lang::getLang('productSpecificationNameJapanese') . '</label>
						<input type="text" class="form-control" name="productSpecificationNameJapanese" value="' . $newSpecification->productSpecificationNameJapanese . '">
					</div>

					<div class="form-group col-12 col-lg-8 col-xl-9">
						<label for="productSpecificationDescriptionJapanese">' . Lang::getLang('productSpecificationDescriptionJapanese') . '</label>
						<input type="text" class="form-control" name="productSpecificationDescriptionJapanese" value="' . $newSpecification->productSpecificationDescriptionJapanese . '">
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 sm-6 offset-sm-6 offset-md-10 col-md-2">
						<button type="submit" name="add-product-specification" class="btn btn-block btn-success"><span class="fas fa-plus"></span></button>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('productSpecificationManager') . ' ['.$product->productName().']';
		$card = new CardView('product_specification_manager',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

}

?>