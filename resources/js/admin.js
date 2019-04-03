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
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})


isNumberKey = function (evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

swalDelete = function(trigger, e) {
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

confirmLogout = function(trigger, e) {
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