getLastPeriodOfProduct = function (trigger, period, quarter, baseUri) {
	let source = $(trigger).val();
	let url = baseUri + "/last-period-of/" + source;

	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$(period).val(response.period);
			$(quarter).val(response.quarter);
		},
		error: function (response) {
			console.log(response);
		}
	});
}