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
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'product/admin/product/') . '
				</div>
				<div class="col-12 col-md-4 col-lg-2 offset-lg-4">
					<a href="/' . Lang::prefix() . 'product/admin/product/create/" class="btn btn-block btn-outline-success btn-sm"><span class="fas fa-plus"></span> ' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mb-3">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('productName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('category') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('productPublished') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('productFeatured') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminProductListRows($arg) . '</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 col-md-8 col-lg-6">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'product/admin/product/') . '
				</div>
			</div>
			

		';

		$card = new CardView('admin_product_list',array('container'),'',array('col-12'),Lang::getLang('productList'),$body);
		return $card->card();

	}

	public function adminProductForm($type, $productID = null) {

		$site = new Site($_SESSION['siteID']);

		$product = new Product($productID);
		$pcv = new ProductCategoryView();
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($product->$key)) { $product->$key = $value; } }
		}

		$form = $this->adminProductFormTabs($type, $productID) . '

			<form id="productForm' . ucfirst($type) . '" method="post" action="/' . Lang::prefix() . 'product/admin/product/' . $type . '/' . ($productID?$productID.'/':'') . '">
				
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
								<textarea id="admin_product_form_description_english" class="form-control" name="productDescriptionEnglish">' . $product->productDescriptionEnglish . '</textarea>
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
								<textarea id="admin_product_form_description_japanese" class="form-control" name="productDescriptionJapanese">' . $product->productDescriptionJapanese . '</textarea>
							</div>
		
						</div>
				
					</div>
				
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-xl-8">
						<label for="productURL">' . Lang::getLang('productURL') . ' (' . Lang::getLang('alphanumericHyphenOnly') . ')</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><span class="d-none d-md-inline">https://' . $site->siteURL . '</span>/' . Lang::prefix() . 'product/</div>
							</div>
							<input type="text" class="form-control" name="productURL" value="' . $product->productURL . '" required>
							<div class="input-group-append"><div class="input-group-text">/</div></div>
						</div>
					</div>

				</div>
				
				<hr />
				
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="productPublished" value="1"' . ($product->productPublished?' checked':'') . '>
					<label class="form-check-label" for="productPublished">' . Lang::getLang('productPublished') . '</label>
				</div>
				
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="productFeatured" value="1"' . ($product->productFeatured?' checked':'') . '>
					<label class="form-check-label" for="productFeatured">' . Lang::getLang('productFeatured') . '</label>
				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'product/admin/product/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="product-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'product/admin/product/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('product'.ucfirst($type)).($type=='update'?' ['.$product->productName().']':'');
		$card = new CardView('admin_product_form_'.ucfirst($type),array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function adminProductConfirmDelete($productID) {

		$product = new Product($productID);
		$pcv = new ProductCategoryView();

		$form = '

			<form id="product_form_delete" method="post" action="/' . Lang::prefix() . 'product/admin/product/delete/' . $productID . '/">
				
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
						<a href="/' . Lang::prefix() . 'product/admin/product/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('productConfirmDelete').' ['. $product->productName .']';
		$card = new CardView('admin_product_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function productList(ProductListParameters $arg) {

		$hpl = new ProductList($arg);
		$products = $hpl->products();

		$productList = '<div class="container mt-3">';

		$productList .= '<h3 class="product-h">' .  Lang::getLang($arg->title['langKey'], $arg->title['langSelector']) . '</h3>';

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
				<div class="product-list-item row clickable" data-url="/' . Lang::prefix() . 'product/' . $product->productURL . '/">
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
					
					<div class="col-12 col-md-6 mb-3">' . $this->productCarousel($productID) . '</div>
					
					<div class="col-12 col-md-6 mb-3">
						<h1 class="product-h">' . $product->productName() . '</h1>
						<p>' . nl2br(htmlentities($product->productDescription()),true) . '</p>
					</div>

					<div class="col-12 mb-3">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="product_view_features_nav" data-toggle="tab" href="#product_view_features_panel" role="tab" aria-controls="home" aria-selected="true">' . Lang::getLang('productFeatures') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="product_view_specifications_nav" data-toggle="tab" href="#product_view_specifications_panel" role="tab" aria-controls="profile" aria-selected="false">' . Lang::getLang('productSpecifications') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="product_view_downloads_nav" data-toggle="tab" href="#product_view_downloads_panel" role="tab" aria-controls="contact" aria-selected="false">' . Lang::getLang('productDownloads') . '</a>
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

		$view = '<div id="product_features" class="container-fluid">';
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

			$view = '<div id="product_specification" class="container-fluid">';
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
		$view = '<div id="product_downloads" class="container-fluid">';
			$view .= '<div id="product_downloads_container" class="row">';
				foreach ($downloads AS $fileID) {

					$file = new File($fileID);
					$fileTitle = $file->title();
					if (empty($fileTitle)) { $fileTitle = Lang::getLang('download'); }

					$view .= '
						<div class="col-12 col-md-6 col-lg-3 my-3">
							<div class="card">
								<div class="card-header">' . $fileTitle . '</div>
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
			$category = new ProductCategory($product->productCategoryID);

			$rows .= '
				<tr id="product_id_' . $productID . '" class="product-list-row">
					<th scope="row" class="text-center">' . $product->productName() . '</th>
					<td class="text-center">' . $category->productCategoryName() . '</td>
					<td class="text-center">' . ($product->productPublished?'&#10004;':'') . '</td>
					<td class="text-center">' . ($product->productFeatured?'&#10004;':'') . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'product/admin/product/update/' . $productID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'product/admin/product/confirm-delete/' . $productID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
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
			$productFormURL = '/' . Lang::prefix() . 'product/admin/product/update/' . $productID . '/';
			$updateOnly = false;
		}

		$t = '

			<ul id="admin_product_form_nav_tabs" class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link' . ($activeTab=='product-form'?' active':'') . '" href="' . $productFormURL . '">' . Lang::getLang('product') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='features'?' active':'') . '" href="' . $productFormURL . 'features/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('productFeatures') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='specifications'?' active':'') . '" href="' . $productFormURL . 'specifications/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('productSpecifications') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='images'?' active':'') . '" href="' . $productFormURL . 'images/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('productImages') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='files'?' active':'') . '" href="' . $productFormURL . 'files/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('productFiles') . '</a>
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
					<img src="/image/' . $images[$i] . '/600/">
				</div>
			';
		}

		$carousel = '
			<div id="product_carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">' . $panels . '</div>
				<a class="carousel-control-prev" href="#product_carousel" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#product_carousel" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		';

		return $carousel;

	}

	public function productListAutocomplete(ProductModalParameters $pmp) {

	    $productName = '';
	    if ($pmp->productID) { $p = new Product($pmp->productID); $productName = $p->productName(); }

	    $pac = '<input id="' . $pmp->modalKey . '_hidden_input_id" class="product-id-input" type="hidden" name="' . $pmp->fieldName . '" value="' . $pmp->productID . '">';

	    $pac .= '

			<div class="input-group">
				<input id="' . $pmp->modalKey . '_text_input_id" type="text" class="product-list-autocomplete form-control' . ($pmp->size?' form-control-'.$pmp->size:'') . '" value="' . $productName . '" placeholder="' . Lang::getLang($pmp->placeholder) . '"' . ($pmp->required?' required':'') . '>
				<div class="input-group-append">
					<button id="' . $pmp->modalKey. '_btn_id" class="btn-modal-trigger btn btn-outline-secondary' . ($pmp->size?' btn-'.$pmp->size:'') . '" type="button" tabindex="-1" data-toggle="modal" data-target="#productReferenceModal">' . Lang::getLang($pmp->productModalButtonAnchor) . '</button>
				</div>
			</div>

	    ';

	    if ($pmp->includeModal) { $pac .= $this->productReferenceModal(); }

	    return $pac;

	}

	public function productReferenceModal() {

		$arg = new ProductListParameters();
		$pl = new ProductList($arg);
		$products = $pl->products();

		$items = '';
		foreach ($products AS $productID) {
			$p = new Product($productID);
			$items .= '<a class="list-group-item" data-productid="' . $productID . '">' . $p->productName() . '</a>';
		}

		$modal = '

			<div class="modal fade" id="productReferenceModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Product Reference</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="list-group product-modal-list-group">' . $items . '</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

		';

		return $modal;

	}


}

?>