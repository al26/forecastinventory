require('./bootstrap');

// $.noConflict();

$(document).ready(function () {

	"use strict";

	[].slice.call(document.querySelectorAll('select.cs-select')).forEach(function (el) {
		new SelectFx(el);
	});

	$('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function (event) {
		$('body').toggleClass('open');
	});

	$('.search-trigger').on('click', function (event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function (event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });
	$('.table').DataTable();

	$('.select2').select2();
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})


isNumberKey = function (evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;

	// let regex = new RegExp("^\d{1,2}(?:\.\d{1,9})?$");
	// console.log($(evt.target).val());
}




swalDelete = function (trigger, e) {
	let uri = $(trigger).attr('href');
	let text = $(trigger).attr('delete-text');
	let form = $(trigger).find('form');
	e.preventDefault();
	swal({
		title: text,
		text: "Data yang telah dihapus tidak dapat dikembalikan.",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#e3342f',
		cancelButtonColor: '#3490dc',
		confirmButtonText: 'Hapus',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			form.submit();
		}
	})
}

confirmLogout = function (trigger, e) {
	let uri = $(trigger).attr('href');
	let text = $(trigger).attr('confirmation-text');
	let form = $(trigger).find('form');
	e.preventDefault();
	swal({
		title: text,
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#e3342f',
		cancelButtonColor: '#3490dc',
		confirmButtonText: 'Keluar',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			form.submit();
		}
	})
}

chainSelect = function (trigger, target, baseUri) {
	let source = $(trigger).val();
	let url = baseUri + "/" + source;

	$.ajax({
		type: "get",
		url: url,
		success: function (res) {
			let innerHtml = "<option value='0'>-- Pilih Periode Penjualan --</option>";
			if (res instanceof Array && res.length > 0) {
				$.each(res, function (index, value) {
					innerHtml += `<option value="${value.period}">${value.period}</option>`;
				});
			}

			$(target).html(innerHtml);
		},
		error: function (res) {
			console.log(res);
		}
	})

}

swalUpdateStatus = function (trigger, e) {
	let uri = $(trigger).attr('href');
	let title = $(trigger).attr('update-title');
	let text = $(trigger).attr('update-text');
	let form = $(trigger).find('form');
	e.preventDefault();
	swal({
		title: title,
		text: text,
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#e3342f',
		cancelButtonColor: '#3490dc',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Tidak'
	}).then((result) => {
		if (result.value) {
			form.submit();
		}
	})
}

chainSelect = function(trigger, target, baseUri) {
	let source = $(trigger).val();
	let url = baseUri +"/"+ source;

	$.ajax({
		type: "get",
		url: url,
		success: function(res) {
			let innerHtml = "<option value='0'>-- Pilih Periode Penjualan --</option>";
			if (res instanceof Array && res.length > 0) {
				$.each(res, function(index, value) {
					innerHtml += `<option value="${value.period}">${value.period}</option>`;
				});
			} 

			$(target).html(innerHtml);
		},
		error: function (res) {
			console.log(res);
		}
	})
	
}