
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./jquery');
require('bootstrap-datepicker');

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

$('.js-clear-dropdown').on('click', function (e) {
    var checkboxes = $(this).parent().find('input[type=checkbox]');
    checkboxes.prop( "checked", false );
});

$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    clearBtn: true
});
function serializeQuery(params, prefix) {
  const query = Object.keys(params).map((key) => {
    const value  = params[key];

    if (params.constructor === Array)
      key = `${prefix}[]`;
    else if (params.constructor === Object)
      key = (prefix ? `${prefix}[${key}]` : key);

    if (typeof value === 'object')
      return serializeQuery(value, key);
    else
      return `${key}=${encodeURIComponent(value)}`;
  });

  return [].concat.apply([], query).join('&');
}

$('#submit-filter').on('click', function (e) {
    var formData = new FormData(); // using additional FormData object

    var object = {};
    for(var i = 0; i < $('#filter form').length; i++){
        var form = $('#filter form').get(i);
        var data = new FormData(form);
        for (var key of data.keys()) {
            if (data.getAll(key).length > 1) {
                object[key] = data.getAll(key);
            } else {
                object[key] = data.get(key);
            }
        }
    }

    var json = JSON.stringify(object);
    console.log(object);
    const stringData = serializeQuery(object);
    window.location.href = location.protocol + '//' + location.host + location.pathname +'/?'+ stringData;
})