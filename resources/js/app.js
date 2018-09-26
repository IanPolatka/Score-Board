
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

import $ from 'jquery';
window.$ = window.jQuery = $;



import 'jquery-ui/ui/widgets/datepicker.js';



$(document).ready( function(){

    $(".alert").delay(1500).fadeOut(function() {
    	$(this).alert('close');
	});



    $('input').attr('autocomplete','off');

});

$(document).on('click', '.addingHome', function (e) {
    e.preventDefault();
    var $input = $(this).prev();
    var currentValue = parseInt($input.val());
    $($input).val(currentValue + 1);
  	$('.home-total').html(function(i, val) { return val*1+1 });
    $(".home-total").addClass("text-danger font-weight-bold");
});

$(document).on('click', '.subtractingHome', function (e) {
    e.preventDefault();
    var $input = $(this).next();
    var currentValue = parseInt($input.val());
    if (currentValue > 0) {
        $($input).val(currentValue - 1);
        $('.home-total').html(function(i, val) { return val*1-1 });
        $(".home-total").addClass("text-danger font-weight-bold");
    }
});

$(document).on('click', '.addingAway', function (e) {
    e.preventDefault();
    var $input = $(this).prev();
    var currentValue = parseInt($input.val());
    $($input).val(currentValue + 1);
    $('.away-total').html(function(i, val) { return val*1+1 });
    $(".away-total").addClass("text-danger font-weight-bold");
});

$(document).on('click', '.subtractingAway', function (e) {
    e.preventDefault();
    var $input = $(this).next();
    var currentValue = parseInt($input.val());
    if (currentValue > 0) {
        $($input).val(currentValue - 1);
        $('.away-total').html(function(i, val) { return val*1-1 });
        $(".away-total").addClass("text-danger font-weight-bold");
    }
});
