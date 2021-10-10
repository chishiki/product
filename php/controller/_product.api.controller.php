<?php

final class ProductAPI {
		
	    private $loc;
	    private $input;
	    
	    public function __construct($loc, $input) {
			
	        $this->loc = $loc;
	        $this->input = $input;
			
		}
		
		public function response() {
	    	
	    	if ($this->loc[0] == 'api' && $this->loc[1] == 'product') {

	    		// /api/product/<productID>/
				if (is_numeric($this->loc[2])) {

					$productID = $this->loc[3];
					$product = new Product($productID);
					return json_encode($product);
		
				}

				if (Auth::isSiteManager()) {

					// /api/product/delete-product-feature/
					if ($this->loc[2] == 'delete-product-feature' && isset($this->input['productFeatureID'])) {

						$productFeatureID = $this->input['productFeatureID'];
						$feature = new ProductFeature($productFeatureID);
						$feature->markAsDeleted();
						return json_encode($feature);

					}

					// /api/product/update-product-feature-display-order/
					if ($this->loc[2] == 'update-product-feature-display-order' && isset($this->input['displayOrder'])) {

						$displayOrder = $this->input['displayOrder'];
						$updateFeatures = array();
						foreach($displayOrder AS $thisDisplayOrder => $productFeatureID) {
							$dt = new DateTime();
							$feature = new ProductFeature($productFeatureID);
							if ($feature->productFeatureDisplayOrder != $thisDisplayOrder) {
								$feature->updated = $dt->format('Y-m-d H:i:s');
								$feature->productFeatureDisplayOrder = $thisDisplayOrder;
								$cond = array('productFeatureID' => $productFeatureID);
								ProductFeature::update($feature, $cond, true, false, 'hardware_');
								$updateFeatures[] = $feature;
							}
						}
						return json_encode($updateFeatures);

					}

					// /api/product/delete-product-specification/
					if ($this->loc[2] == 'delete-product-specification' && isset($this->input['productSpecificationID'])) {

						$productSpecificationID = $this->input['productSpecificationID'];
						$specification = new ProductSpecification($productSpecificationID);
						$specification->markAsDeleted();
						return json_encode($specification);

					}

					// /api/product/update-product-specification-display-order/
					if ($this->loc[2] == 'update-product-specification-display-order' && isset($this->input['displayOrder'])) {

						$displayOrder = $this->input['displayOrder'];
						$updateSpecifications = array();
						foreach($displayOrder AS $thisDisplayOrder => $productSpecificationID) {
							$dt = new DateTime();
							$specification = new ProductSpecification($productSpecificationID);
							if ($specification->productSpecificationDisplayOrder != $thisDisplayOrder) {
								$specification->updated = $dt->format('Y-m-d H:i:s');
								$specification->productSpecificationDisplayOrder = $thisDisplayOrder;
								$cond = array('productSpecificationID' => $productSpecificationID);
								ProductSpecification::update($specification, $cond, true, false, 'hardware_');
								$updateSpecifications[] = $specification;
							}
						}
						return json_encode($updateSpecifications);

					}

				}

				// /api/products/partials/product-autocomplete/
				if ($this->loc[2] == 'partials') {

					if ($this->loc[3] == 'product-autocomplete') {

						if (isset($this->input['selectedProductID'])) { $selectedProductID = $this->input['selectedProductID']; } else { $selectedProductID = null; }
						if (isset($this->input['fieldName'])) { $fieldName = $this->input['fieldName']; } else { $fieldName = 'productID'; }
						$pv = new ProductView($this->loc, $this->input, array(), array(), array());

						$pmp = new ProductModalParameters();
						$pmp->productID = $selectedProductID;
						$pmp->size = 'sm';
						$pmp->fieldName = $fieldName;
						$pmp->includeModal = false;
						$pmp->required = true;
						$pmp->productModalButtonAnchor = '<span class="fas fa-bars"></span>';
						$pmp->modalKey = 'product_modal_' . Utilities::generateUniqueKey();

						return $pv->productListAutocomplete($pmp);

					}

				}

				// /api/product/search/
				if ($this->loc[2] == 'search') {

					$productSearchString = null;
					if (isset($this->input['productSearchString']) && !empty($this->input['productSearchString'])) { $productSearchString = $this->input['productSearchString']; }

					$pl = new ProductList(true, $productSearchString, 0, 10000);
					$pll = $pl->products();

					$products = array();
					foreach ($pll AS $p) {
						$products[] = array('value' => $p['productID'], 'label' => $p['productName']);
					}

					return json_encode($products);

				}

				$response = '{"api":"products"}';
				return $response;

			}

		}
		
	}

?>