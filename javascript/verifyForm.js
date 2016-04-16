/*Created by: Kimberly Lanman
Description: This file contains functions that verify form input.*/

var unameValid=true;  
var pwValid=true;

/*AJAX: checkAvail uses ajax to check the availability of the input simultaneously as the user enters it.
This is only used to check the username availability, which is done in availability.php.*/
function checkAvail(input){

	input.strip();
	new Ajax.Request
	("availability.php",
	{
		method: "post",
		parameters:{name:input},
		onSuccess: displayResult
	}
	);
}

/*Displays the ajax response text from checkAvail()'s call to availability.
 The text part of the response (stripped of tags and leading, trailing whitespace)
 is evaluated and unameValid will not be true if it doesn't match "available" */
function displayResult(ajax){
	var message=ajax.responseText;
	$('msgbox').innerHTML=message;
	
	
	var stripped=message.stripTags();	//Prototype library functions 
	var trimmed=stripped.strip();
	if(trimmed=="available"){
		
		unameValid=true;
	}
	else{
		unameValid=false;
	}
}

/*Checks whether confirm password matches password and notifies user onchange. This is used in 
accountprefs.php and newaccount.php onchange (of input)*/
function checkPW(confirm){
	var password= document.getElementById("pw").value;
	var message="";
	var pwinfo=document.getElementById("confirmpw");
	var goodColor = "#66cc66";
	
	if((password == confirm) && (password != "") && (confirm != "")){
		
		message= "<span style='color:#66cc66'>Passwords match</span>";	
		pwinfo.innerHTML=message;
		pwValid=true;
	}
	else if((password !="")  &&  (confirm !="")){
		message= "<span style='color:#ff6666'>Passwords do not match!</span>";
		pwinfo.innerHTML=message;
		pwValid=false;
	}
	else{
		message="";
		pwinfo.innerHTML=message;
		pwValid=false;
	}		
}

/*Used in accountprefs.php. on submit for the Change Password form*/
  
function changePW(){
	if(pwValid){
		return true;
	}
	else{
		alert("Passwords do not match");
		return false;
	}
}

/*Used in accountprefs.php on submit for the Change Email form*/
function checkEmail(){
	var email=document.getElementById("email").value;
	var pattern= /([\w\-]+\@[\w\-]+\.[\w\-]+)/i;
	var r=pattern.test(email);
	if(email=='' || r==false){
		alert("invalid email"); 
		return false;
	}
	else{
		return true;
	}
}

/*Checks all of the inputs in newaccount.php onclick of submit button. 
Won't submit until all are valid and alerts otherwise*/
function checkAll(){
	var valid=true;
	var errormessage="";
	var fname=document.getElementById("fname").value;
	var pattern1=/\d/;
	var r1=pattern1.test(fname);
	if(fname=='' || r1==true){
		errormessage=errormessage+"invalid first name \n";
		valid=false;
	}
	var lname=document.getElementById("lname").value;
	var r2=pattern1.test(lname);
	if(lname=='' || r2==true){
		errormessage=errormessage+"invalid last name \n";
		valid=false;
	}
	var email=document.getElementById("email").value;
	var pattern2= /([\w\-]+\@[\w\-]+\.[\w\-]+)/i;
	var r3=pattern2.test(email);
	if(email=='' || r3==false){
		errormessage=errormessage+"invalid email \n"; 
		valid=false;
	}
	
	/*Here is where unameValid and pwValid come in handy*/
	if(unameValid==false){
		errormessage=errormessage+"User name  already taken \n"; 
		valid = false;
	}
	if(pwValid==false){
		errormessage=errormessage+"Passwords do not match \n"; 
		valid=false;
	 }
	 
	 var amount=document.getElementById("amount").value;
	 var pattern3=/^\d{1,10}(\.\d{0,2})?$/;
	 var r4=pattern3.test(amount);
	 if(amount=='' || r4==false){
		 errormessage=errormessage+"Invalid starting amount \n"; 
		 valid=false;
	 }
	 if(valid==false){
		 alert("Please fill out all of the required areas:\n" + errormessage);
		 return false;
	 }
	 else{
		 return true;
	 }
}


