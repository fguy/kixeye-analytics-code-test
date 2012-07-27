$(function() {
		$("#search-query").autocomplete({
			source: "/simple-address-book/contact/autocomplete",
			minLength: 2,
			matchContains: true,
		});
});