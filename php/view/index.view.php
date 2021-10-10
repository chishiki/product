<?php 

final class ProductIndexView {

    private $urlArray;
	private $view;
	
	public function __construct($urlArray) {
		
	    $this->urlArray = $urlArray;
		$this->view = $this->index();

	}

	private function index() {

		$h = '';

		// GET FEATURED PRODUCTS LIST
		$hpv = new ProductView();
		$arg = new ProductListParameters();
		$arg->productFeatured = true;
		$arg->descriptionConcat = 77; // if English do we make this longer...?
		$arg->title = array('langKey' => 'featuredProducts', 'langSelector' => $_SESSION['lang']);
		$h .= $hpv->productList($arg);

		return $h;
	    
	}
	
	public function getView() {
		
		return $this->view;
		
	}
	
}


?>