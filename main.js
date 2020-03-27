function submitreg() {
    var form = document.reg;

    // If passwords same return False.     
    // if (form.userpassword != form.confirm_password) { 
    //   alert("looks like the passwords did not match");
    //   return false;
    // } 
    // else{
    //   return true
    // }
  }
  function submitpassword(){
    var form = document.forgotpassword;
    //check if any field is empty
     if (form.newpassword.value == "") {
    alert("Please Enter password.");
    return false;
    } 
    else if (form.confirmpassword.value == "") {
      alert("Please Confirm password.");
      return false;
    } 
    // If passwords same return False.     
    else if (newpassword != confirmpassword) { 
    alert ("\nPassword did not match: Please try again...");
    return false; 
    } 
  }
  function submitlogin() {
    var form = document.login;
    if (form.emailusername.value == "") {
      alert("Please Enter email or username.");
      return false;
    } else if (form.userpassword.value == "") {
      alert("Please Enter password.");
      return false;
    }
  }
  function submitadminlogin() {
    var form = document.login;
    if (form.admin.value == "") {
      alert("Please Enter email or username.");
      return false;
    } else if (form.adminpassword.value == "") {
      alert("Please Enter password.");
      return false;
    }
  }
  function regsuccess(){
    if (window.confirm('Registration Successful.<br>Click "ok" to login.')) 
    {
    window.location.href='login.php';
    };
  }
  function confirmreg(){
    window.location.href='http://localhost/phpprojects/maintest3/login.php';
  }
  function skipconfirm(){
    window.location.href='home/main.php';
  }
 /*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

  'use strict';
  
  // class helper functions from bonzo https://github.com/ded/bonzo
  
  function classReg( className ) {
    return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
  }
  
  // classList support for class management
  // altho to be fair, the api sucks because it won't accept multiple classes at once
  var hasClass, addClass, removeClass;
  
  if ( 'classList' in document.documentElement ) {
    hasClass = function( elem, c ) {
      return elem.classList.contains( c );
    };
    addClass = function( elem, c ) {
      elem.classList.add( c );
    };
    removeClass = function( elem, c ) {
      elem.classList.remove( c );
    };
  }
  else {
    hasClass = function( elem, c ) {
      return classReg( c ).test( elem.className );
    };
    addClass = function( elem, c ) {
      if ( !hasClass( elem, c ) ) {
        elem.className = elem.className + ' ' + c;
      }
    };
    removeClass = function( elem, c ) {
      elem.className = elem.className.replace( classReg( c ), ' ' );
    };
  }
  
  function toggleClass( elem, c ) {
    var fn = hasClass( elem, c ) ? removeClass : addClass;
    fn( elem, c );
  }
  
  var classie = {
    // full names
    hasClass: hasClass,
    addClass: addClass,
    removeClass: removeClass,
    toggleClass: toggleClass,
    // short names
    has: hasClass,
    add: addClass,
    remove: removeClass,
    toggle: toggleClass
  };
  
  // transport
  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( classie );
  } else {
    // browser global
    window.classie = classie;
  }
  
  })( window );