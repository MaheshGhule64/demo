
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
  apiKey: "AIzaSyC9Up-Mstpotc3zAFj9UxEbHYWJfGkLLXU",
  authDomain: "testfirebase-309a4.firebaseapp.com",
  projectId: "testfirebase-309a4",
  storageBucket: "testfirebase-309a4.appspot.com",
  messagingSenderId: "284115556016",
  appId: "1:284115556016:web:4fcd86fa44f39161524d75",
  measurementId: "G-TQBK2L18XY"
};


  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
  //render();
 

   function render(){

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');

    window.recaptchaVerifier.render();
   }

   function phoneauth(){       

    var phone = document.getElementById('inputPhone').value;

    console.log(phone);
    render();

firebase.auth().signInWithPhoneNumber(phone,window.recaptchaVerifier).then(function(response){

    window.confirmationResult=response;
    coderesult = confirmationResult;
    console.log(coderesult);


    $('#phoneloginbtn').hide();
    $('#inputPhone').hide();
    $('#recaptcha-container').hide();
    $('#inputOtp').show();
    $('#verifyotp').show();


    

}).catch(function(error){
    alert(error.message);
});    
       
   }
function verify(){

     var code  = document.getElementById('inputOtp').value;
     console.log(code);
   window.confirmationResult.confirm(code).then(function(response){
      
        var userobj=response.user;
       
        if(userobj){

          window.location.href = "<?php echo base_url('Page/index');?>";
            console.log(response);
        }
   })
   .catch(function(error){
       alert(error.message);
   })
}
   


</script>
<!------ Include the above in your HEAD tag ---------->

    <style>

/* sign in FORM */
#logreg-forms{
    width:412px;
    margin:10vh auto;
    background-color:#f3f3f3;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
#logreg-forms form {
    width: 100%;
    max-width: 410px;
    padding: 15px;
    margin: auto;
}
#logreg-forms .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
}
#logreg-forms .form-control:focus { z-index: 2; }
#logreg-forms .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}
#logreg-forms .form-signin input[type="password"] {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

#logreg-forms .social-login{
    width:390px;
    margin:0 auto;
    margin-bottom: 14px;
}
#logreg-forms .social-btn{
    font-weight: 100;
    color:white;
    width:190px;
    font-size: 0.9rem;
}

#logreg-forms a{
    display: block;
    padding-top:10px;
    color:lightseagreen;
}

#logreg-form .lines{
    width:200px;
    border:1px solid red;
}


#logreg-forms button[type="submit"]{ margin-top:10px; }

#logreg-forms .facebook-btn{  background-color:#3C589C; }

#logreg-forms .google-btn{ background-color: #DF4B3B; }

#logreg-forms .form-reset, #logreg-forms .form-signup{ display: none; }

#logreg-forms .form-signup .social-btn{ width:210px; }

#logreg-forms .form-signup input { margin-bottom: 2px;}

.form-signup .social-login{
    width:210px !important;
    margin: 0 auto;
}

/* Mobile */

@media screen and (max-width:500px){
    #logreg-forms{
        width:300px;
    }
    
    #logreg-forms  .social-login{
        width:200px;
        margin:0 auto;
        margin-bottom: 10px;
    }
    #logreg-forms  .social-btn{
        font-size: 1.3rem;
        font-weight: 100;
        color:white;
        width:200px;
        height: 56px;
        
    }
    #logreg-forms .social-btn:nth-child(1){
        margin-bottom: 5px;
    }
    #logreg-forms .social-btn span{
        display: none;
    }
    #logreg-forms  .facebook-btn:after{
        content:'Facebook';
    }
  
    #logreg-forms  .google-btn:after{
        content:'Google+';
    }
    
}
    </style>
    <title>Bootstrap 4 Login/Register Form</title>
</head>
<body>
    <div id="logreg-forms">
        <form class="form-signin" accept="#">
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
           
            <input type="text" id="inputPhone" class="form-control" placeholder="PHONE" required="" autofocus="">
            <div id="recaptcha-container"></div>
            <button class="btn btn-success btn-block" type="button" id="phoneloginbtn" onclick="phoneauth()"><i class="fas fa-sign-in-alt"></i> SEND OTP</button>
            <input type="otp" id="inputOtp" class="form-control" placeholder="OTP" required="" style="display:none">
            <button class="btn btn-success btn-block" type="button" id="verifyotp" onclick="verify()" style="display:none"><i class="fas fa-sign-in-alt"></i> VERIFY OTP</button>
        
        
    </div>

    
    </p>




</body>
</html>