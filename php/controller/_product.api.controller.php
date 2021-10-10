<?php

final class ProductAPI {
		
	    private $loc;
	    private $input;
	    
	    public function __construct($loc, $input) {
			
	        $this->loc = $loc;
	        $this->input = $input;
			
		}
		
		public function response() {

	    	if ($this->loc[0] == 'api' && $this->loc[1] == 'products') {

				if ($this->loc[2] == 'partials') {

					if ($this->loc[3] == 'product-autocomplete') {

						// /api/products/partials/product-autocomplete/

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

				if ($this->loc[2] == 'product' && $this->loc[3] == 'search') {

					// /api/products/product/search/

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

				if ($this->loc[2] == 'product' && ctype_digit($this->loc[3])) {

					// /api/products/product/1001/

					$product = new Product($this->loc[3]);
					return json_encode($product);

				}

				$response = '{"api":"products"}';
				return $response;

			}

		}
		
	}

?>