getLastPeriodOfProduct = function (trigger, period, quarter, baseUri) {
	let source = $(trigger).val();
	let url = baseUri + "/last-period-of/" + source;

	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$(period).val(response[0].period);
			$(quarter).val(response[0].quarter);
		},
		error: function (response) {
			console.log(response);
		}
	});
}

getLastQuarterOfProduct = function (trigger, quarter, baseUri) {
	let source = $(trigger).val();
	let url = baseUri + "/last-period-of/" + source;

	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			// $(period).val(response[0].period);
			$(quarter).val(response[0].quarter);
		},
		error: function (response) {
			console.log(response);
		}
	});
}

getNextYear = function(trigger, target, baseUri) {
	let source = $(trigger).val();
	let url = baseUri + "/next-year/" + source;

	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			// $(period).val(response[0].period);
			$(target).val(response);
		},
		error: function (response) {
			console.log(response);
		}
	});
}