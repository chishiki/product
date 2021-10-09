<?php

final class ProductCategoryView {

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

	public function adminProductCategoryList() {

		$body = '

			<div class="row">
				<div class="col-12 col-sm-6 offset-sm-6 col-md-3 offset-md-9 col-lg-2 offset-lg-10">
					<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/create/" class="btn btn-block btn-outline-success">' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mt-2">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('hardwareProductCategoryID') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('hardwareProductCategoryName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminProductCategoryListRows() . '</tbody>
					</table>
				</div>
			</div>

	';

		$card = new CardView('hardware_product_category_list',array('container'),'',array('col-12'),Lang::getLang('hardwareProductCategoryList'),$body);
		return $card->card();

	}

	public function adminProductCategoryForm($type, $productCategoryID = null) {

		$category = new ProductCategory($productCategoryID);
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($category->$key)) { $category->$key = $value; } }
		}

		$form = '

			<form id="product_category_form_' . $type . '" method="post" action="/' . Lang::prefix() . 'hardware/admin/product-categories/' . $type . '/' . ($productCategoryID?$productCategoryID.'/':'') . '">
				
				' . ($productCategoryID?'<input type="hidden" name="productCategoryID" value="' . $productCategoryID . '">':'') . '

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryNameEnglish">' . Lang::getLang('productCategoryNameEnglish') . '</label>
						<input type="text" class="form-control" name="productCategoryNameEnglish" value="' . $category->productCategoryNameEnglish . '">
					</div>
					
				</div>

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productCategoryDescriptionEnglish">' . Lang::getLang('productCategoryDescriptionEnglish') . '</label>
						<textarea class="form-control" name="productCategoryDescriptionEnglish">' . $category->productCategoryDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryNameJapanese">' . Lang::getLang('productCategoryNameJapanese') . '</label>
						<input type="text" class="form-control" name="productCategoryNameJapanese" value="' . $category->productCategoryNameJapanese . '">
					</div>
					
				</div>

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productCategoryDescriptionJapanese">' . Lang::getLang('productCategoryDescriptionJapanese') . '</label>
						<textarea class="form-control" name="productCategoryDescriptionJapanese">' . $category->productCategoryDescriptionJapanese . '</textarea>
					</div>

				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="product-category-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('hardwareProductCategory'.ucfirst($type)).($type=='update'?' ['.$category->productCategoryName().']':'');
		$card = new CardView('hardware_product_category_confirm_'.$type,array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function adminProductCategoryConfirmDelete($productCategoryID) {

		$category = new ProductCategory($productCategoryID);

		$form = '

			<form id="product_form_delete" method="post" action="/' . Lang::prefix() . 'hardware/admin/product-categories/delete/' . $productCategoryID . '/">
				
				<input type="hidden" name="productCategoryID" value="' . $productCategoryID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryNameEnglish">' . Lang::getLang('productCategoryNameEnglish') . '</label>
						<input type="text" class="form-control" value="' . $category->productCategoryNameEnglish . '" disabled>
					</div>

				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productCategoryDescriptionEnglish">' . Lang::getLang('productCategoryDescriptionEnglish') . '</label>
						<textarea class="form-control" disabled>' . $category->productCategoryDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryNameJapanese">' . Lang::getLang('productCategoryNameJapanese') . '</label>
						<input type="text" class="form-control" value="' . $category->productCategoryNameJapanese . '" disabled>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productCategoryDescriptionJapanese">' . Lang::getLang('productCategoryDescriptionJapanese') . '</label>
						<textarea class="form-control" disabled>' . $category->productCategoryDescriptionJapanese . '</textarea>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" name="product-category-confirm-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('productCategoryConfirmDelete').' ['. $category->productCategoryName() .']';
		$card = new CardView('hardware_product_category_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	private function adminProductCategoryListRows() {

		$hpcl = new ProductCategoryList();
		$categories = $hpcl->productCategories();

		$rows = '';

		foreach ($categories AS $productCategoryID) {

			$category = new ProductCategory($productCategoryID);

			$rows .= '
				<tr id="product_category_id_' . $productCategoryID . '" class="product-category-list-row">
					<th scope="row" class="text-center">' . $productCategoryID . '</th>
					<td class="text-left">' . $category->productCategoryName() . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/update/' . $productCategoryID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'hardware/admin/product-categories/confirm-delete/' . $productCategoryID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

	public function productCategoryDropdown($name = 'productCategoryID', $selectedProductCategoryID = null, $required = true, $disabled = false, $size = null) {

		$hpcl = new ProductCategoryList();
		$categories = $hpcl->productCategories();

		$d = '<select class="form-control' . ($size?' form-control-'.$size:'') . '" name="' . $name . '"' . ($disabled?' disabled':'') . '>';
		if (!$required) { $d .= '<option value="0">----</option>'; }
		foreach ($categories AS $thisProductCategoryID) {
			$category = new ProductCategory($thisProductCategoryID);
			$d .= '<option value="' . $thisProductCategoryID . '"' . ($thisProductCategoryID==$selectedProductCategoryID?' selected':'') . '>' . $category->productCategoryName() . '</option>';
		}
		$d .= '</select>';

		return $d;

	}

}

?>