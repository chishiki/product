
var productScript = function() {

	const path = window.location.pathname.split('/');
	var lang = 'en';
	var langPrefix = '';

	path.pop();
	path.shift();
	if (path[0] == 'ja') {
		path.shift();
		lang = 'ja';
		langPrefix = '/ja';
	}

	var btnModalTrigger = '';
	$(document).on('click', 'button.btn-modal-trigger', function() {
		btnModalTrigger = $(this).attr('id');
	});

	/* START ADMIN PRODUCT FEATURE MANAGER */

	var setProductFeatureDisplayOrder = function() {
		var displayOrder = [];
		$('.admin-product-feature-list-item').each(function(i){
			displayOrder[i] = $(this).data("product-feature-id");
		});
		var settings = {
			url: "/api/product/update-product-feature-display-order/",
			method: "post",
			data: { displayOrder : displayOrder },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$("#admin_product_feature_list").sortable({
		handle: ".drag-handle",
		update: function() { setProductFeatureDisplayOrder(); }
	});

	var deleteProductFeature = function(productFeatureID) {
		var settings = {
			url: "/api/product/delete-product-feature/",
			method: "post",
			data: { productFeatureID : productFeatureID },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$(document).on('click', '.delete-product-feature', function(){
		var productFeatureID = $(this).parent().data("product-feature-id");
		$(this).closest('li').remove();
		deleteProductFeature(productFeatureID);
	});

	/* END ADMIN PRODUCT FEATURE MANAGER */



	/* START ADMIN PRODUCT SPECIFICATION MANAGER */

	var setProductSpecificationDisplayOrder = function() {
		var displayOrder = [];
		$('.admin-product-specification-list-item').each(function(i){
			displayOrder[i] = $(this).data("product-specification-id");
		});
		var settings = {
			url: "/api/product/update-product-specification-display-order/",
			method: "post",
			data: { displayOrder : displayOrder },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$("#admin_product_specification_list").sortable({
		handle: ".drag-handle",
		update: function() { setProductSpecificationDisplayOrder(); }
	});

	var deleteProductSpecification = function(productSpecificationID) {
		var settings = {
			url: "/api/product/delete-product-specification/",
			method: "post",
			data: { productSpecificationID : productSpecificationID },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$(document).on('click', '.delete-product-specification', function(){
		var productSpecificationID = $(this).parent().data("product-specification-id");
		$(this).closest('li').remove();
		deleteProductSpecification(productSpecificationID);
	});

	/* END ADMIN PRODUCT SPECIFICATION MANAGER */



	$(document).on('keypress keyup keydown', '.product-list-autocomplete', function() {

		$('.product-list-autocomplete').autocomplete({

			source: function (request, response) {
				var settings = {
					url: "/api/product/search/",
					method: "post",
					data: {'productSearchString':request.term},
					dataType: "json",
					success: function(data) { response(data); }
				};
				$.ajax(settings).always(function(data) { return data; });
			},
			minLength: 2,
			delay: 100,
			select: function (event, ui) {
				$(this).val(ui.item?ui.item.label:"");
				$(this).parent().prev().val(ui.item?ui.item.value:0);
				return false;
			},
			change: function(event, ui) {
				$(this).val(ui.item?ui.item.label:"");
				$(this).parent().prev().val(ui.item?ui.item.value:0);
			},
			focus: function (event, ui) {
				event.preventDefault();
				$(this).val(ui.item?ui.item.label:"");
				$(this).parent().prev().val(ui.item?ui.item.value:0);
			}

		});

	});

	$(document).on('click', '#productReferenceModal a.list-group-item', function (event) {

		var element = $('#'+btnModalTrigger).parent().prev('input');
		var productID = $(this).data("productid");
		var productName = $(this).text();

		$('#'+btnModalTrigger).parent().parent().prev('input').val(productID);
		$('#'+btnModalTrigger).parent().prev('input').val(productName);

		if (orderObject == 'sales-orders') { setUpSalesOrderRow(element, productID); }

		$('#productReferenceModal').modal('hide');

	});

	console.log('product javascript has loaded');

}

window.addEventListener('load', productScript, false);
