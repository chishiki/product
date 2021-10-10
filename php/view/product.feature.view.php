<?php

final class ProductFeatureView {

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

	public function adminProductFeatureForm($productID) {

		$product = new Product($productID);
		$newFeature = new ProductFeature();

		$hpv = new ProductView();
		$form = $hpv->adminProductFormTabs('update', $productID, 'features');

		$hpfl = new ProductFeatureList($productID);
		$features = $hpfl->features();
		if (!empty($features)) {
			$form .= '<ul id="admin_product_feature_list" class="list-group">';
			foreach ($features as $productFeatureID) {
				$feature = new ProductFeature($productFeatureID);
				$form .= '
					<li class="list-group-item admin-product-feature-list-item d-flex justify-content-between align-items-center" data-product-feature-id="' . $productFeatureID . '">
						<span class="drag-handle btn btn-outline-secondary mr-3"><span class="fas fa-grip-lines"></span></span>
						<span class="admin-product-feature-name flex-grow-1 d-block">' . $feature->productFeatureName() . '</span>
						<button type="button" class="btn btn-danger delete-product-feature ml-3"><span class="far fa-trash-alt"></span></button>
					</li>
				';
			}
			$form .= '</ul>';
			$form .= '<hr />';
		}

		$form .= '

			<form id="product_feature_manager_form" method="post" action="/' . Lang::prefix() . 'product/admin/product/update/' . $productID . '/features/">

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productFeatureNameEnglish">' . Lang::getLang('productFeatureNameEnglish') . '</label>
						<input type="text" class="form-control" name="productFeatureNameEnglish" value="' . $newFeature->productFeatureNameEnglish . '" placeholder="' . Lang::getLang('addNewFeatureHere', 'en') . '">
					</div>
					
				</div>
				
				<div class="form-row">

					<div class="form-group col-12">
						<label for="productFeatureNameJapanese">' . Lang::getLang('productFeatureNameJapanese') . '</label>
						<input type="text" class="form-control" name="productFeatureNameJapanese" value="' . $newFeature->productFeatureNameJapanese . '" placeholder="' . Lang::getLang('addNewFeatureHere', 'ja') . '">
					</div>
				
				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12 sm-6 offset-sm-6 offset-md-10 col-md-2">
						<button type="submit" name="add-product-feature" class="btn btn-block btn-success"><span class="fas fa-plus"></span></button>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('productFeatureManager') . ' ['.$product->productName().']';
		$card = new CardView('product_feature_manager',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

}

?>