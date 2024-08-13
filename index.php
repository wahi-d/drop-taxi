<?php include("connection/config.php");
 session_start(); 
if(isset($_POST['btnAdd']) )
  {
 $_SESSION['name'] = $_POST['name'];
     $datas = array_filter($_POST);

	 //$datas['finline_name'] = strtoupper($datas['finline_name']);
		
	$msgsub="\n Welcome To DROP TAXI MADURAI\n Cab Booking Service\nCabBooking ID:".$datas['id']."\Name:".$datas['name']."\nMobileno:".$datas['mobileno']."\nPick up:".$datas['pickplace']."\nDrop:".$datas['dp']."\nDate:".$datas['dat']."Thank you for your booking,Have a Happy Journey";
//$msgsub="\n welcome to mani travels \n\n date:".$datas['date']."";

	 //$datas['branch'] = BRANCH;
	 $datas['date_of_create'] = jk_mysql_datetime();
		
		$numbers	=	"6369865319";
		@sendsms($numbers, $msgsub);

      $insertRoute = jk_insert_data(CABBOOKING,$datas);
		  
		 if($insertRoute)
      {
		  
		   jk_redirect_success_url('index.php?success=Cab booking successfully.!');}

  }
  $randCode				=	rand(999,9999);
$_SESSION['rand_code']	=	$randCode;
?>
<?php include'header.php';?>

    	
	   

	<div class="container-fluid text-center; background-color:white;" id="contactt" >
    <div><br>
	
      

  	<form action="otp.php" method="post">
	
						
						<div class="form-style-agile" id="locationField">
							<input placeholder="Name" class="form-control" name="name" id="name" type="text" required="">
							<br>
							<input placeholder="Phone Number" maxlength="10" class="form-control" name="mobileno" id="mobileno" type="text" required="">
								<br>
									
							<input placeholder="Pickup Place" class="form-control" name="pickplace"  id="pickplace" type="text" required="">
								<br>
	<input placeholder="Drop Place" name="dp" class="form-control"  id="dp" type="text" required="">
		<br>
		
		  <div align="justify" class="form-control">
		
                     <input type="radio" name="ctype" id="ctype" required="" 
<?php if (isset($ctype) && $ctype=="sedan") echo "checked";?>
value="sedan">
          sedan
		
		  
            <input type="radio" name="ctype" id="ctype"  
<?php if (isset($ctype) && $ctype=="suv")  echo "checked";?>
value="suv">   suv<br />
            </div>
			<br>
			  <div align="justify" class="form-control">
		
                     <input type="radio" name="ptype" id="ptype" required="" 
<?php if (isset($ptype) && $ptype=="Oneway Trip") echo "checked";?>
value="sedan">
          Oneway Trip
		
		  
            <input type="radio" name="ptype" id="ptype"  
<?php if (isset($ptype) && $ptype=="Round Trip")  echo "checked";?>
value="suv">   Round Trip<br />
            </div>
		  </div>
		</div>
							
						
								<br>
							<input type="datetime-local"  class="form-control" value="<?php echo Date('Y-m-d\TH:i',time()) ?>"   name="dat" id="dat"  required="">
							<!--<input placeholder="Password" name="password" type="password" required=""> -->
						<h2>
                            <button class="btn btn-primary badge pull-right"><?php echo $randCode;?></button></h2>
							<input placeholder="Enter the code" class="form-control" name="randcode" id="randcode"  type="text" required="">
			
		<br>
							  <a href="index.php">
							  <input type="submit" name="btnAdd" style="margin-bottom:20px;" class="btn btn-secondary btn-rounded" value="Book Now"></a>						</div>
                      		<input placeholder="Email" class="form-control" name="mail" id="mail" type="text"  style="display:none">
										 <select name="ptype" id="ptype" class="form-control"  class="select-state form-control" style="display:none">
							 
									    <option value="state">Package Type </option>
                                      
                                     <option value="Package Trip">Airport Pickup/Drop</option>
                                        <option value="Round Trip">Round Trip</option>
						  </select>
								
					</form>
    </div>

  </div>
    <!-- //banner -->
    <!--  about -->
    
    <!--  about bottom -->
    <section class="wthree-slide-btm pb-lg-5">
        <div class="container   pt-sm-5 pt-4">
            <div class="row flex-row-reverse no-gutters">
                <div class="col-lg-5">
                    <div class="ab-banner">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="bg-abt"id="about">
                        <div class="container">
                            <div class="title-desc  pb-sm-3">
                                <h4 class="main-title-w3pvt"data-blast="color">ABOUT US</h4>
                                <p>Drop taxi madurai</p>
                            </div>
                            <div class="row flex-column mt-lg-4 mt-3">
                                <div class="abt-grid">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="abt-icon" data-blast="bgColor">
                                                <span class="fa fa-ravelry"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 pl-sm-0">
                                            <div class="abt-txt ml-sm-0">
                                                
                                                <p style="font-weight:600">Car Rental Booking
We are provides you with the best-customized deals for car rentals local, outstation trips,
tour packages and taxi hire in Madurai.Always Available, Best Cabs, Safe Journey</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="abt-grid mt-4 pt-lg-2">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="abt-icon" data-blast="bgColor">
                                                <span class="fa fa-laptop"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 pl-sm-0">
                                            <div class="abt-txt ml-sm-0">
                                               
                                                <p style="font-weight:600">मदुरै मणि ट्रेवल्स कार रेंटल बुकिंग हम आपको मदुरै में स्थानीय, बाहरी यात्राओं, टूर पैकेज और टैक्सी किराए पर कार किराए पर लेने के लिए सर्वोत्तम-अनुकूलित सौदे प्रदान करते हैं। हमेशा उपलब्ध, सर्वश्रेष्ठ कैब, सुरक्षित यात्रा।
अब हम 24 घंटे लोकल और लंबी दूरी की यात्रा के लिए एक्सप्रेस सेवा में सबसे कम दरों पर अपनी सेवा दे रहे हैं
मदुरै मणि टूर्स एंड ट्रेवल्स।
चलो भी! सहायता! बड़े होना! अपनी सफलता की सुरक्षित यात्रा में एक साथी के रूप में हमसे जुड़ें</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //about boottom -->
	   <!-- blog -->
    <section class="blog_w3ls pb-lg-5 pb-4" id="tariff">
        <div class="container py-sm-5 py-4">
            <div class="title-desc text-center pb-sm-3 mb-lg-5">
                <h3 class="main-title-w3pvt"data-blast="color">TARIFF</h3>
                <p>We provide the best price</p>
            </div>
            <div class="row mt-4">
                <!-- blog grid -->
                <div class="col-lg-4 col-md-6 mt-sm-0 mt-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="#exampleModal2" data-toggle="modal" aria-pressed="false" data-target="#exampleModal2"
                                role="button">
                                <img class="card-img-bottom" src="images/gg1.jpg" alt="Card image cap">
                                

                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <a href="#exampleModal2" data-toggle="modal" aria-pressed="false" data-target="#exampleModal2"
                                    role="button">Etios, Dzire, Xcent</a>
                            </h5>
                            <p>Round Trip Rs 13.<BR>Driver Allowance Rs. 300/--<BR>Per day Round Trip Minimum/ 250 Toll Charge Extra.<br> My Travels Online Booking Availble<br>
 Aim safety and secure</p>
                            
                            <button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="#contactt">BOOK NOW</a></button>
                        </div>
                    </div>
                </div>
                <!-- //blog grid -->
                <!-- blog grid -->
                <div class="col-lg-4 col-md-6 mt-md-0 mt-sm-5 mt-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="#exampleModal3" data-toggle="modal" aria-pressed="false" data-target="#exampleModal3"
                                role="button">
                                <img class="card-img-bottom" src="images/g2.jpg" alt="Card image cap">
                                
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <a href="#exampleModal3" data-toggle="modal" aria-pressed="false" data-target="#exampleModal3"
                                    role="button">Xylo, Tavera, Enjoy</a>
                            </h5>
                            <p>Round Trip Rs 17.<BR>Driver Allowance Rs. 400/-<BR>Per day Round Trip Minimum/ 300Km Toll Charge Extra.<br> My Travels Online Booking Availble<br>Aim Safety and Secure</p>
                            
                            <button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="#contactt">BOOK NOW</a></button>
                        </div>
                    </div>
                </div>
                <!-- //blog grid -->
                <!-- blog grid -->
                <div class="col-lg-4 col-md-6 mt-lg-0 mt-4 mx-auto">
                    <div class="card">
                        <div class="card-header p-0  position-relative">
                            <a href="#exampleModal4" data-toggle="modal" aria-pressed="false" data-target="#exampleModal4"
                                role="button">
                                <img class="card-img-bottom" src="images/g3.jpg" alt="Card image cap">
                                
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <a href="#exampleModal4" data-toggle="modal" aria-pressed="false" data-target="#exampleModal4"
                                    role="button">Assured Innova</a>
                            </h5>
                            <p>Round Trip Rs 18.<BR>Driver Allowance Rs. 500/-<BR>Per day Round Trip Minimum/ 300Km Toll Charge Extra.<br> My Travels Online Booking Availble <br>Aim Safety and Secure</p>
                          
                            <button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="#contactt">BOOK NOW</a></button>
                        </div>
                    </div>
                </div>
                <!-- //blog grid -->
            </div>
        </div>
    </section>
    <!-- //blog -->
	<!-- team -->
    <section class="team py-4 py-lg-5" id="tour">
        <div class="container py-lg-5 py-sm-4">
            <div class="title-desc text-center pb-sm-3">
                <h3 class="main-title-w3pvt"data-blast="color">TOUR PACKAGES</h3>
                <p>Book your dream ride with us!!</p>
            </div>
            <div class="row py-4 mt-lg-5  team-grid">
                <div class="col-lg-4 col-sm-6">
                    <div class="box13">
                        <a href="mdu.php"><img src="images/meen.jpg" class="img-fluid img-thumbnail" alt="" />
						
                        <div class="box-content">
                            <h3 class="title" data-blast="color">MADURAI</h3>
                            <span class="post">Madurai is  an academic centre of learning for Tamil culture, literature, art, music and dance for centuries.</span>
                           <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="mdu.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">MADURAI</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-sm-0 mt-4">
                    <div class="box13">
                        <a href="kerala.php"><img src="images/vaga.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">KERALA</h3>
                            <span class="post">Kerala, a small beautiful state situated in the southwest corner of India is one of the most popular tourist.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="kerala.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">KERALA</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-lg-0 mt-4">
                    <div class="box13">
                        <a href="kodai.php"><img src="images/team1.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">KODAIKANAL</h3>
                            <span class="post">Kodaikanal is a hill town in the southern Indian state of Tamil Nadu. It is called as the princess of hills.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="kodai.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">KODAIKANAL</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6  mt-4">
                    <div class="box13">
                       <a href="ramesh.php"> <img src="images/team2.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">RAMESHWARAM</h3>
                            <span class="post">Pamban Bridge is a railway bridge which connects the town of Mandapam with Rameswaram.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="ramesh.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">RAMESHWARAM</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-4">
                    <div class="box13">
                        <a href="ooty.php"><img src="images/team4.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">OOTY</h3>
                            <span class="post">Ooty (Udhagamandalam) is a resort town in the Western Ghats mountains, in southern India's Tamil Nadu state.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					 <a href="ooty.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">OOTY</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-4">
                    <div class="box13">
                        <a href="valp.php"><img src="images/team31.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">VALPARAI </h3>
                            <span class="post">Situated inside Karumalai Tea Estate, it is one of the beautiful and the most visited Valparai tourist places.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="valp.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">VALPARAI </h3></a>
                </div>
				<div class="col-lg-4 col-sm-6  mt-4">
                    <div class="box13">
                        <a href="kolli.php"><img src="images/team11.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">KOLLI HILLS</h3>
                            <span class="post"> Located on the Eastern Ghats, Kolli Hills or Kolli Malai is a picturesque hill station in the state of Tamil Nadu.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button></a>
                        </div>
                    </div>
					<a href="kolli.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">KOLLI HILLS</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-4">
                    <div class="box13">
                        <a href="megamalai.php"><img src="images/team21.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">MEGA MALAI</h3>
                            <span class="post">Meghamalai  is a mountain range located in the Western Ghats in the Theni district near Kumily, Tamil Nadu.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="megamalai.php"><h3 class="title" style="text-align: center;font-family:serif;" data-blast="color">MEGA MALAI</h3></a>
                </div>
                <div class="col-lg-4 col-sm-6 mt-4">
                    <div class="box13">
                       <a href="cout.php"> <img src="images/team411.jpg" class="img-fluid img-thumbnail" alt="" />
                        <div class="box-content">
                            <h3 class="title" data-blast="color">COUTRALLAM </h3>
                            <span class="post">Several lakhs of people of different faith from all over the world visits Courtallam during this period.</span>
                            <button type="button" class="btn blog-btn wthree-bnr-btn">
                                know more>>
                            </button>
                        </div></a>
                    </div>
					<a href="cout.php"><h3 class="title" style="text-align: center; font-family:serif;" data-blast="color">COUTRALLAM </h3></a>
                </div>
            </div>
        </div>
    </section>
    <!-- //team -->
    <!-- stats -->
    <section class="w3_stats py-sm-5 py-4" id="stats">
        <div class="container">
            <div class="py-lg-5 w3-stats">
                <h2 class="w3pvt-title">We Make Your Destination As A Sweet Memory With Our Cabs
                </h2>
                <p class="my-4 text-white">
                    DROP TAXI Madurai is one the best and outstanding call taxi service for our
            valued customers,We offer low cost cars with our very flexible
            and smooth process. You enjoy the experience of traveling the
            vehicle you choose, and you return it after you complete your
            journey.</p>
                <div class="row py-4">
                    <div class="col-md-4 col-6">
                        <div class="counter">
                            <span class="fa fa-smile-o"></span>
                            <div class="timer count-title count-number mt-2 text-white" data-to="297" data-speed="1500"></div>
                            <p class="count-text text-uppercase text-white">Happy Coustomers</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="counter">
                            <span class="fa fa-users"></span>
                            <div class="timer count-title count-number mt-2 text-white" data-to="194" data-speed="1500"></div>
                            <p class="count-text text-uppercase text-white">Travels Completed</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6 mt-md-0 mt-4">
                        <div class="counter">
                            <span class="fa fa-database"></span>
                            <div class="timer count-title count-number mt-2 text-white" data-to="2298" data-speed="1500"></div>
                            <p class="count-text text-uppercase text-white">Drivers</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- //stats -->
    <!-- services -->
    <div class="w3lspvt-about py-md-5 py-5" id="services">
        <div class="container pt-lg-5">
            <div class="title-desc text-center pb-sm-3">
                <h3 class="main-title-w3pvt"data-blast="color">Services</h3>
                <p>We Proide The Best Services!!</p>
            </div>
            <div class="w3lspvt-about-row row  text-center pt-md-0 pt-5 mt-lg-5">
                <div class="col-lg-4 col-sm-6 w3lspvt-about-grids">
                    <div class="p-md-5 p-sm-3">
                        <span class="fa fa-map-marker" data-blast="borderColor"></span>
                        <h4 class="mt-2 mb-3" data-blast="color">GPS Searching</h4>
                        <p> Fill the address field and click on "Get GPS Coordinates" to display its latitude and longitude.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 w3lspvt-about-grids  border-left border-right my-sm-0 my-5">
                    <div class="p-md-5 p-sm-3">
                        <span class="fa fa-check-circle-o" data-blast="borderColor"></span>
                        <h4 class="mt-2 mb-3" data-blast="color">Experienced Drivers</h4>
                        <p>Quality maintenance goes beyond any transports service in your experience.</p>
                    </div>
                </div>
                <div class="col-lg-4 w3lspvt-about-grids">
                    <div class="p-md-5 p-sm-3">
                        <span class="fa fa-paw" data-blast="borderColor"></span>
                        <h4 class="mt-2 mb-3" data-blast="color">Safe Journey</h4>
                        <p>We don't just take a booking and forget about you. Helpful agents at our customer care centers 24/7.</p>
                    </div>
                </div>
            </div>
            <div class="w3lspvt-about-row border-top row text-center pt-md-0 pt-5 mt-md-0 mt-5">
                <div class="col-lg-4 col-sm-6 w3lspvt-about-grids">
                    <div class="p-md-5 p-sm-3 col-label">
                        <span class="fa fa-tint" data-blast="borderColor"></span>
                        <h4 class="mt-2 mb-3" data-blast="color">Online Booking</h4>
                        <p>Booking through website & App We don't just take a booking and forget about you. Helpful agents at our customer care centers 24/7.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 w3lspvt-about-grids mt-lg-0 mt-md-3 border-left border-right pt-sm-0 pt-5">
                    <div class="p-md-5 p-sm-3 col-label">
                        <span class="fa fa-handshake-o" data-blast="borderColor">
                        </span>
                        <h4 class="mt-2 mb-3" data-blast="color">Fast and Safe</h4>
                        <p>You can say "drive safely" or "drive safe" when referring to driving. " Safely is recognizable as an adverb since it ends in -ly.</p>
                    </div>
                </div>
                <div class="col-lg-4 w3lspvt-about-grids pt-md-0 pt-5">
                    <div class="p-md-5 p-sm-3 col-label">
                        <span class="fa fa-bar-chart" data-blast="borderColor"></span>
                        <h4 class="mt-2 mb-3" data-blast="color">24/7 Cab Service</h4>
                        <p>We don't just take a booking and forget about you. Helpful agents at our customer care centers 24/7.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //services -->
  
    <!-- slide -->
    <div class="abt_bottom py-lg-5 bg-theme" data-blast="bgColor">
        <div class="container py-sm-4 py-3">
            <h4 class="abt-text text-capitalize text-sm-center mb-0">24 Hours, 7 Days a Week, 24*7</h4>
            <p class="text-white text-sm-center ">We Move You To The All Over The World.</p><br>
			<h4 class="abt-text text-capitalize text-sm-center mb-0"><a href="tel:(+91)8190006205">+(91)8190006205</a></h4>
            <div class="d-sm-flex justify-content-center">
			
                <a href="tel:(+91)8190006205" role="button"  class="btn light-bg mt-sm-4 mt-3 ml-3 w3_pvt-link-bnr">
                    call now</a>
					<a class="btn light-bg mt-sm-4 mt-3 ml-3 w3_pvt-link-bnr" href="#contact" role="button">contact
                    us
                </a>
                <a href="#contactt" role="button"  class="btn light-bg mt-sm-4 mt-3 ml-3 w3_pvt-link-bnr">
                    Book Now</a>
            </div>
        </div>
    </div>
    <!-- //slide -->
	 <!-- contact -->
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
                            <address>No.41Rahmath garden, bismi streat,<br>  Annai sathya nagar, kalmedu,<br>madurai.</address>
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
                <div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=No.41Rahmath%20garden,%20bismi%20streat,%20%20Annai%20sathya%20nagar,%20kalmedu,madurai+(DROP%20TAXI%20MADURAI)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
                    
                <!-- //footer right -->
            </div>
        </div>

    </section>
    <!-- //contact -->
   <?php include'footer.php';?>
