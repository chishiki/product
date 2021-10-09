<?php

final class ProductView {

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

	public function adminProductList(ProductListParameters $arg) {

		$body = '

			<div class="row mb-3">
				<div class="col-12 col-md-8 col-lg-6">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'hardware/admin/products/') . '
				</div>
				<div class="col-12 col-md-4 col-lg-2 offset-lg-4">
					<a href="/' . Lang::prefix() . 'hardware/admin/products/create/" class="btn btn-block btn-outline-success btn-sm"><span class="fas fa-plus"></span> ' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mb-3">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('hardwareProductName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('hardwareProductPublished') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('hardwareProductFeatured') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminProductListRows($arg) . '</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 col-md-8 col-lg-6">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'hardware/admin/products/') . '
				</div>
			</div>
			

		';

		$card = new CardView('hardware_product_list',array('container'),'',array('col-12'),Lang::getLang('hardwareProductList'),$body);
		return $card->card();

	}

	public function adminProductForm($type, $productID = null) {

		$product = new Product($productID);
		$pcv = new ProductCategoryView();
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($product->$key)) { $product->$key = $value; } }
		}

		$form = $this->adminProductFormTabs($type, $productID) . '

			<form id="productForm' . ucfirst($type) . '" method="post" action="/' . Lang::prefix() . 'hardware/admin/products/' . $type . '/' . ($productID?$productID.'/':'') . '">
				
				' . ($productID?'<input type="hidden" name="productID" value="' . $productID . '">':'') . '
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryID">' . Lang::getLang('productCategory') . '</label>
						' . $pcv->productCategoryDropdown('productCategoryID', $product->productCategoryID) . '
					</div>
					
				</div>
				
				<hr />
				
				<div class="row">
				
					<div class="col-12 col-md-6">
					
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="productNameEnglish">' . Lang::getLang('productNameEnglish') . '</label>
								<input type="text" class="form-control" name="productNameEnglish" value="' . $product->productNameEnglish . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="productDescriptionEnglish">' . Lang::getLang('productDescriptionEnglish') . '</label>
								<textarea id="hardware_admin_product_form_description_english" class="form-control" name="productDescriptionEnglish">' . $product->productDescriptionEnglish . '</textarea>
							</div>
		
						</div>
					
					</div>
					
					<div class="col-12 col-md-6">

						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="productNameJapanese">' . Lang::getLang('productNameJapanese') . '</label>
								<input type="text" class="form-control" name="productNameJapanese" value="' . $product->productNameJapanese . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="productDescriptionJapanese">' . Lang::getLang('productDescriptionJapanese') . '</label>
								<textarea id="hardware_admin_product_form_description_japanese" class="form-control" name="productDescriptionJapanese">' . $product->productDescriptionJapanese . '</textarea>
							</div>
		
						</div>
				
					</div>
				
				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/products/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="product-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/products/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('hardwareProduct'.ucfirst($type)).($type=='update'?' ['.$product->productName().']':'');
		$card = new CardView('hardware_product_confirm_'.ucfirst($type),array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function adminProductConfirmDelete($productID) {

		$product = new Product($productID);
		$pcv = new ProductCategoryView();

		$form = '

			<form id="product_form_delete" method="post" action="/' . Lang::prefix() . 'hardware/admin/products/delete/' . $productID . '/">
				
				<input type="hidden" name="productID" value="' . $productID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productCategoryID">' . Lang::getLang('productCategory') . '</label>
						' . $pcv->productCategoryDropdown('', $product->productCategoryID, true, true, null) . '
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productNameEnglish">' . Lang::getLang('productNameEnglish') . '</label>
						<input type="text" class="form-control" value="' . $product->productNameEnglish . '" disabled>
					</div>

				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productDescriptionEnglish">' . Lang::getLang('productDescriptionEnglish') . '</label>
						<textarea class="form-control" disabled>' . $product->productDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="productNameJapanese">' . Lang::getLang('productNameJapanese') . '</label>
						<input type="text" class="form-control" value="' . $product->productNameJapanese . '" disabled>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="productDescriptionJapanese">' . Lang::getLang('productDescriptionJapanese') . '</label>
						<textarea class="form-control" disabled>' . $product->productDescriptionJapanese . '</textarea>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" name="product-confirm-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'hardware/admin/products/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('productConfirmDelete').' ['. $product->productName .']';
		$card = new CardView('hardware_product_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function productList(ProductListParameters $arg) {

		$hpl = new ProductList($arg);
		$products = $hpl->products();

		$productList = '<div class="container mt-3">';

		$productList .= '<h3 class="hardware-h">' .  Lang::getLang($arg->title['langKey'], $arg->title['langSelector']) . '</h3>';

		foreach ($products AS $productID) {

			$img = '';
			$imageFetch = new ImageFetch('Product', $productID, null, true);
			if ($imageFetch->imageExists()) {
				$img = '<span class="product-list-item-image-span">';
					$img .= '<img src="' . $imageFetch->getImageSrc() . '" class="product-list-item-image">';
				$img .= '</span>';
			}

			$product = new Product($productID);
			$productList .= '
				<div class="product-list-item row clickable" data-url="/' . Lang::prefix() . 'hardware/products/' . $product->productURL . '/">
					<div class="product-list-item-image col-12 col-md-3 col-lg-2">' . $img . '</div>
					<div class="product-list-item-product col-12 col-md-9 col-lg-10">
						<span class="product-list-item-product-name">' . $product->productName() . '</span>
						<br />
						<span class="product-list-item-product-description">' . mb_substr($product->productDescription(), 0, $arg->descriptionConcat) . '...</span>
					</div>
				</div>
			';
		}

		$productList .= '</div>';

		return $productList;

	}

	public function productView($productID) {

		$product = new Product($productID);

		$view = '
		
			<div class="product-view container-fluid">

				<div class="row">
					
					<div class="col-12 col-sm-6 mb-3">' . $this->productCarousel($productID) . '</div>
					
					<div class="col-12 col-sm-6 mb-3">
						<h1 class="hardware-h">' . $product->productName() . '</h1>
						<p>' . nl2br(htmlentities($product->productDescription()),true) . '</p>
					</div>

					<div class="col-12 mb-3">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="product_view_features_nav" data-toggle="tab" href="#product_view_features_panel" role="tab" aria-controls="home" aria-selected="true">' . Lang::getLang('hardwareProductFeatures') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="product_view_specifications_nav" data-toggle="tab" href="#product_view_specifications_panel" role="tab" aria-controls="profile" aria-selected="false">' . Lang::getLang('hardwareProductSpecifications') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="product_view_downloads_nav" data-toggle="tab" href="#product_view_downloads_panel" role="tab" aria-controls="contact" aria-selected="false">' . Lang::getLang('hardwareProductDownloads') . '</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="product_view_features_panel" role="tabpanel" aria-labelledby="home-tab">' . $this->productViewFeatures($productID) . '</div>
							<div class="tab-pane fade" id="product_view_specifications_panel" role="tabpanel" aria-labelledby="profile-tab">' . $this->productViewSpecifications($productID) . '</div>
							<div class="tab-pane fade" id="product_view_downloads_panel" role="tabpanel" aria-labelledby="contact-tab">' . $this->productViewDownloads($productID) . '</div>
						</div>
					</div>
					
				</div>
				
			</div>

		';

		return $view;

	}

	private function productViewFeatures($productID) {

		$featureList = new ProductFeatureList($productID);
		$features = $featureList->features();

		$view = '<div id="hardware_product_features" class="container-fluid">';
			$view .= '<div class="row">';
				$view .= '<div class="col-12">';
					$view .= '<ul>';
						foreach ($features AS $productFeatureID) {
							$feature = new ProductFeature($productFeatureID);
							$view .= '<li>' . $feature->productFeatureName() . '</li>';
						}
					$view .= '</ul>';
				$view .= '</div>';
			$view .= '</div>';
		$view .= '</div>';

		return $view;

	}

	private function productViewSpecifications($productID) {

		$specList = new ProductSpecificationList($productID);
		$specs = $specList->specifications();

			$view = '<div id="hardware_product_specification" class="container-fluid">';
			foreach ($specs AS $productSpecificationID) {
				$spec = new ProductSpecification($productSpecificationID);
				$view .= '<div class="row">';
					$view .= '<div class="spec-name col-12 col-sm-5 col-md-3 border font-weight-bolder py-2">' . $spec->productSpecificationName() . '</div>';
					$view .= '<div class="spec-description col-12 col-sm-7 col-md-9 border py-2">' . $spec->productSpecificationDescription() . '</div>';
				$view .= '</div>';
			}
			$view .= '</div>';

		return $view;

	}

	private function productViewDownloads($productID) {

		$downloads = File::getObjectFileArray('Product', $productID);
		$view = '<div id="hardware_product_downloads" class="container-fluid">';
			$view .= '<div id="hardware_product_downloads_container" class="row">';
				foreach ($downloads AS $fileID) {
					$file = new File($fileID);
					$view .= '
						<div class="col-12 col-md-6 col-lg-3 my-3">
							<div class="card">
								<div class="card-header">' . $file->fileTitleEnglish . '</div>
								<div class="card-body">
									<a class="btn btn-primary btn-block" href="/file/' . $fileID . '/" download>
										' . Lang::getLang('download') . '<br />
										<span class="font-weight-lighter"><small>' . $file->fileOriginalName . ' ' . (number_format($file->fileSize/1000, '0')) . 'KB</small></span>
									</a>
								</div>
							</div>
						</div>
					';
				}
			$view .= '</div>';
		$view .= '</div>';
		return $view;

	}

	private function adminProductListRows(ProductListParameters $arg) {

		$productList = new ProductList($arg);
		$products = $productList->products();

		$rows = '';

		foreach ($products AS $productID) {

			$product = new Product($productID);

			$rows .= '
				<tr id="product_id_' . $productID . '" class="product-list-row">
					<th scope="row" class="text-left">' . $product->productName() . '</th>
					<td class="text-center">' . ($product->productPublished?'&#10004;':'') . '</td>
					<td class="text-center">' . ($product->productFeatured?'&#10004;':'') . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'hardware/admin/products/update/' . $productID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'hardware/admin/products/confirm-delete/' . $productID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

	public function adminProductFormTabs($type = 'create', $productID = null, $activeTab = 'product-form') {

		$productFormURL = '#';
		$updateOnly = true;

		if ($type == 'update' && ctype_digit($productID)) {
			$productFormURL = '/' . Lang::prefix() . 'hardware/admin/products/update/' . $productID . '/';
			$updateOnly = false;
		}

		$t = '

			<ul id="admin_product_form_nav_tabs" class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link' . ($activeTab=='product-form'?' active':'') . '" href="' . $productFormURL . '">' . Lang::getLang('hardwareProduct') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='features'?' active':'') . '" href="' . $productFormURL . 'features/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('hardwareProductFeatures') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='specifications'?' active':'') . '" href="' . $productFormURL . 'specifications/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('hardwareProductSpecifications') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='images'?' active':'') . '" href="' . $productFormURL . 'images/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('hardwareProductImages') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='files'?' active':'') . '" href="' . $productFormURL . 'files/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('hardwareProductFiles') . '</a>
				</li>
			</ul>
			
		';

		return $t;

	}

	private function productCarousel($productID) {

		$arg = new NewImageListParameters();
		$arg->imageObject = 'Product';
		$arg->imageObjectID = $productID;
		$nil = new NewImageList($arg);
		$images = $nil->images();

		$panels = '';
		for ($i = 0; $i < count($images); $i++) {
			$panels .= '
				<div class="carousel-item' . ($i==0?' active':'') . '">
					<img src="/image/' . $images[$i] . '" class="d-block w-100"">
				</div>
			';
		}

		$carousel = '
			<div id="hardware_product_carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">' . $panels . '</div>
				<a class="carousel-control-prev" href="#hardware_product_carousel" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#hardware_product_carousel" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		';

		return $carousel;

	}

}

?>