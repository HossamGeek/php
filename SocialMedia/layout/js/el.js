/**
 * Created by Hossam on 5/16/2017.
 */
$(document).ready(function () {

    'use strict';

    $('.pic').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000,
        prevArrow: false,
        nextArrow:false,
        infinite: true,
        fade: true,
        cssEase: 'linear'
    });
    $("[placeholder]").focus(function () {
        $(this).attr("data-text", $(this).attr("placeholder"));
        $(this).attr("placeholder", "");
    }).blur(function () {
        $(this).attr("placeholder", $(this).attr("data-text"));
    });




    $(".textbox").focus(function () {
        $(this).css("opacity", "1");
    }).blur(function () {
        $(this).css("opacity", "0.8");
    });

    $(".btndash").click(function () {
        $(".Post").fadeToggle(1000);
    });


    $(".btndash1").click(function () {
        $(".All-posts").fadeToggle(1000);
    });
    var displayed1 = true,
         displayed2 = true;

    var hovered = false ;

    $(".btn1").hover(function(){

        if(!hovered) {
            displayed2 = false;
            hovered = true;
            $(".hidde2").find("input").val("");
            $(this).css({
                "background-color":"#1da1f2",
                "border":"1px solid  #eeeeee",
                "color":"#f9f9ff"
            });
            $(".btn2").css({
                "background-color":"#f9f9ff",
                "border":"1px solid  #1da1f2",

                "color": "#1da1f2"
            });
            $(".hidde2").fadeOut();
            $(".hidde2").hide();
            $(".hidde").fadeIn();

            setTimeout(function(){
                hovered = false ;
            }, 500);
        }

    });
    $(".btn2").hover(function(){
        displayed1 = false;
        $(".hidde").find("input").val("");
        $(this).css({
            "background-color":"#1da1f2",
            "border":"1px solid  #eeeeee",
            "color":"#f9f9ff"
        });
        $(".btn1").css({
            "background-color":"#f9f9ff",
            "border":"1px solid  #1da1f2",

            "color": "#1da1f2"
        });
        $(".hidde").fadeOut();
        $(".hidde").hide();
        $(".hidde2").fadeIn();
    });


    /** Validate  **/

    var  usernameerror = true,
         passworderror = true,
         usererror = true,
         emailerror = true,
         phoneerror = true,
         passerror = true;


    $(".user").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            usernameerror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            usernameerror = false;
        }
    });

    $(".password").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            passworderror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            passworderror = false;
        }
    });

    $(".newuser").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            usererror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            usererror = false;
        }
    });
    $(".email").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            emailerror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            emailerror = false;
        }
    });
    $(".phone").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            phoneerror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            phoneerror = false;
        }
    });
    $(".pass").blur(function () {
        if($(this).val() === "" ){
            $(this).css("border","2px solid #ff002e");
            passerror = true;
        }else{
            $(this).css("border","2px solid #44b55e");
            passerror = false;
        }
    });
    /**btn validate**/

    $(".login").submit(function (e) {
        if( $(".hidde").css("display") == "none"){
            if (usererror === true || emailerror === true || phoneerror === true || passerror === true){
                e.preventDefault();
                $(".newuser, .email, .phone, .pass").blur();
            }else{
                $(".hidde").css("display","none");
            }
        }
        else if($(".hidde2").css("display") == "none"){
            if (usernameerror === true || passworderror === true){
                e.preventDefault();
                $(".user, .password").blur();
            }else{
                $(".hidde2").css("display","none");
            }
        }
       });


/*
    $(".btn2").click(function(){
        $(".hidde").css("display", "none");
        $(".btn2").submit(function (e) {
            if (usererror === true || emailerror === true || phoneerror === true || passerror === true){
                e.preventDefault();
                $(".newuser, .email, .phone, .pass").blur();
            }});
    });
    $(".btn1").click(function(){
        $(".hidde2").css("display", "none");
        $(".btn1").submit(function (e) {
            if (usernameerror === true || passworderror === true){
                e.preventDefault();
                $(".user, .password").blur();
            }});
    });

*/

    /*$("#sign").click(function(){
        console.log("Hi");
        $(".hidde").hide();
    */    //$("#sign").submit(function (e) {
      /*      if (usererror === true || emailerror === true || phoneerror === true || passerror === true){
                e.preventDefault();
                $(".newuser, .email, .phone, .pass").blur();
            }}
        //}
        );*/
    //});
    /*
    $(".btn1").click(function(){
        $(".hidde2").css("display", "none");
        $(".btn1").submit(function (e) {
            if (usernameerror === true || passworderror === true){
                e.preventDefault();
                $(".user, .password").blur();
            }});
    });*/

    /**********/

});