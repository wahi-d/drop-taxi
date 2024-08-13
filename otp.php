<?php 
error_reporting(0);

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include("connection/config.php");
include('smtp/PHPMailerAutoload.php');



///$msgsub="\n Computer Service MSG \n N: \nPh: \nIS: \nAD: ";


 session_start(); 

if(isset($_POST['btnAdd_otp']))  {
     
	 $datas = $_SESSION['data'];
    
	 if($datas['otp']==$_POST['number']){
	 $msgsub="DROP TAXI MADURAI \nName:".$datas['name']."Mobileno:".$datas['mobileno']." Pickup:".$datas['pickplace']." Drop:".$datas['dp']." Type:".$datas['ctype']." Date:".$datas['dat']."";
$msgsubb="Welcome To  DROP TAXI MADURAI, Thank you for your booking , please wait Few Minutes for our  Call \nName:".$datas['name']."\nMobileno:".$datas['mobileno']."\nPickup:".$datas['pickplace']."\nDrop:".$datas['dp']."\nType:".$datas['ctype']."\nDate:".$datas['dat']."";
	 	$datas['date_of_create'] = jk_mysql_datetime();

		$numbers	=	"8190006205";

		@sendsms($numbers, $msgsub);

    	$insertRoute = jk_insert_data(CABBOOKING,$datas);
	  
	
		$html=$msgsub;
	
		$submail	="New Cab  Booking Welcome To DROP TAXI MADURAI, Thank you for your booking,Have a Happy Journey - ".date('d-m-Y H:i:s');

		$to      = $datas['mail'];
    	$subject = $submail;
		$message = $msgsubb;
		$headers = 'From: wahiofficial18@gmail.com'       . "\r\n" .
					 'Reply-To:wahiofficial18@gmail.com' . "\r\n" .
					 'X-Mailer: PHP/' . phpversion();

    	mail($to, $subject, $message, $headers);
	// echo $to;
	 //echo $subject;
	 //echo $message;
	 //exit;
	 
	 }else{
		 $insertRoute =	0;
	 }
	  
	  
	  
	 session_destroy (); 
		 if($insertRoute)  {
					echo "<script>alert('DROP TAXI MADURAI Cab Booked Successfully, please wait Few Minutes for our Call!');window.location.href='thank-you.php';</script>";
				  }else{
					  
					 jk_redirect_success_url('index.php?error=Invalid otp.!'); 
				  }
      }




if(isset($_POST['btnAdd']))

  {



     $datas = array_filter($_POST);
	
	if($datas['randcode']==$_SESSION['rand_code']){
	$datas['otp']		=	rand(999,9999);
	
	$_SESSION['data']	=	$datas;

	 //$datas['finline_name'] = strtoupper($datas['finline_name']);

		 $msgsub="MANI TRAVELS \nName:".$datas['name']."Mobileno:".$datas['mobileno']." Pickup:".$datas['pickplace']." Drop:".$datas['dp']." Type:".$datas['ctype']." Date:".$datas['dat']."";

	$msgsub="\n Dear Customer, Your one time otp for booking is ".$datas['otp']." and is valid for 2 mins. DROP TAXI MADURAI";





	 //$datas['branch'] = BRANCH;

	 //$datas['date_of_create'] = jk_mysql_datetime();

		

		$numbers	=	$datas["mobileno"];
		
		if(preg_match("/^\d+\.?\d*$/",$numbers) && strlen($numbers)==10){

				@sendsms($numbers, $msgsub);
		
		}else{
		session_destroy ();
			jk_redirect_success_url('index.php?error=Invalid mobile number..!');

	
			
		}

      //$insertRoute = jk_insert_data(CABBOOKING,$datas);
      }else{
		  session_destroy ();
		  	jk_redirect_success_url('index.php?error=Please enter correct code.!');

	  }

  }



if(!isset($_SESSION['data'])){
    header("Location: https://droptaximadurainc.com/");
    exit;
}
?>
<?php include'header.php';?>
<!-- about -->
  <header>
            <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-expand-lg navbar-light navbar-fixed-top">
                <h1>
                    <a class="navbar-brand" href="index.php" data-blast="color">
                        Drop Taxi NC
                    </a>
                </h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-lg-auto text-center">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php" data-blast="color">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>

            </nav>
        </header>
<section class="about py-sm-5 py-4" id="about" style="padding-top:40px; margin-top:80px;" data-blast="bgColor">
	<div class="container margin-top:80px">
		<div class="row about-grids">
			
			<div class="col-lg-12 col-md-12 mt-lg-0 mt-9">
				<div class="padding">
					<form action="#" method="post">
					     <h2 class="custom-text--heading" style="text-align:center;">Enter the Valid OTP</h2>
					<center>	<div  >
					
					<input type="text" id="otp_num" name="number" class="form-control" placeholder="Enter the OTP" size="30">
					
							
						
						
						
				
			<br>
							     <input type="submit" name="btnAdd_otp"  style="margin-bottom:0px;"  class="book-btn btn" value="Confirm Book Now">
						</div></center>
					</form><br>
				</div>
			</div>
			
		</div>
	</div>
</section>
<!-- //about -->
  <section class="contact-wthree py-sm-5 py-4" id="contact">
        <div class="container pt-lg-5">
            <div class="title-desc text-center pb-sm-3">
                <h3 class="main-title-w3pvt"data-blast="color">contact us</h3>
                <p>Get In Touch With Us!!</p>
            </div>
            <div class="row mt-4">
                <div class="col-lg-5 text-center">
                    <h5 class="cont-form" data-blast="color">get in touch</h5>
                    <div class="row flex-column">
                        <div class="contact-w3">
                            <span class="fa fa-envelope-open  mb-3" data-blast="color"></span>
                            <div class="d-flex flex-column">
                                <a href="mailto:droptaximadurainc@gmail.com" class="d-block">droptaximadurainc@gmail.com</a>
                               
                            </div>
                        </div>
                        <div class="contact-w3 my-4">
                            <span class="fa fa-phone mb-3" data-blast="color"></span>
                            <div class="d-flex flex-column">
                                <a href="tel:(+91)8190006205"><p>(+91)8190006205</p></a>
                               
                            </div>
                        </div>
                        <div class="contact-w3">
                            <span class="fa fa-home mb-3" data-blast="color"></span>
                            <address>drop taxi <br>44 Shirley Ave.<br> madurai.</address>
                        </div>
                    </div>

                </div>
                <div class="col-lg-7">
                    <h5 class="cont-form" data-blast="color">contact form</h5>
                    <div class="contact-form-wthreelayouts">
                        <form action="#" method="post" class="register-wthree">
                            <div class="form-group">
                                <label>
                                    Your Name
                                </label>
                                <input class="form-control" type="text" placeholder="Enter your name" name="email" required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    Mobile
                                </label>
                                <input class="form-control" type="text" placeholder="Mobile Number" name="email" required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    Email
                                </label>
                                <input class="form-control" type="email" placeholder="example@email.com" name="email"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    Your message
                                </label>
                                <textarea placeholder="Type your message here" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-w3layouts btn-block  bg-theme text-white w-100 font-weight-bold text-uppercase"
                                    data-blast="bgColor">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mx-auto text-center mt-lg-0 mt-4">
                <div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=madurai+(DROP%20TAXI%20madurai)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps tracker sport</a></iframe></div>
                    
                <!-- //footer right -->
            </div>
        </div>

    </section>
<!-- //what we do -->
<?php include'footer.php';?>
<!-- //footer -->
<script>
  
  document.getElementById("otp_num").focus();
</script>
</body>
</html>
