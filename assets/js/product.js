
var productScript = function() {

	$(document).on('keypress keyup keydown', '.product-list-autocomplete', function() {

		$('.product-list-autocomplete').autocomplete({

			source: function (request, response) {
				var settings = {
					url: "/api/order/product/search/",
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
