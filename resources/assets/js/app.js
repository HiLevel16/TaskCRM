
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./jquery');

$('.currency_value').click(function () {
    $('#currency_dropdown').html($(this).html());
    $('#currency').attr('value', $(this).html().toLowerCase());
});

$('.status_value').click(function () {
    $('#status_dropdown').html($(this).html());
    $('#status').attr('value', $(this).html());
});

$('.payment_value').click(function () {
    $('#payment_dropdown').html($(this).html());
    $('#payment').attr('value', $(this).data('id'));
});

$('.project_value').click(function () {
    $('#project_dropdown').html($(this).html());
    $('#project').attr('value', $(this).data('id'));
});

$('.category_value').click(function () {
    $('#category_dropdown').html($(this).html());
    $('#category').attr('value', $(this).data('id'));
});

$('.role_value').click(function () {
    $('#role_dropdown').html($(this).html());
    $('#role').attr('value', $(this).data('id'));
});

