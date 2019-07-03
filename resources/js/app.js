
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

Vue.component('todays-events', require('./components/TodaysEventsComponent.vue'));

//  Single Events
Vue.component('baseball', require('./components/SingleEvents/Baseball.vue'));
Vue.component('softball', require('./components/SingleEvents/Softball.vue'));

Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})

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





    //  Turn of submit button on 'post to twitter' if textarea is blank
    var maxLength = 279;
    var currentLength = $('.tweetText').val().length;
    var theLength = maxLength - currentLength;
    $('#chars').text(theLength);
    $('.sendTweet').attr('disabled',false);

    $('.tweetText').keyup(function(){
        var length = $(this).val().length;
        var length = maxLength-length;
        $('#chars').text(length);
        if($(this).val().length !=0 && $(this).val().length < 280)
            $('.sendTweet').attr('disabled', false);            
        else
            $('.sendTweet').attr('disabled',true);
    });

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








