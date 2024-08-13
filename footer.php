
    <!-- footer -->
    <footer class="cpy-right bg-theme" data-blast="bgColor">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-12 text-lg-center mt-lg-0 mt-12">
                    <p>© 2024 DROP TAXI MADURAI. All rights reserved | Design by
                        <a href="tel:(+91)9965189712">ABDUL WAHID S</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- //footer -->
 
    <!-- blog modal1 -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-theme">
                    <h5 class="modal-title" id="exampleModalLabel2">Etios, Dzire, Xcent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="images/gg1.jpg" class="img-fluid" alt="" />
                    <p class="text-left my-4">
                        In this we provide mini,Sedan cars, in this 4 members can travel along with the driver and the luggages. You have an pleasend ride with your family.
                    </p>
					<button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="index.php">BOOK NOW</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- //blog modal1 -->
    <!-- blog modal2 -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-theme">
                    <h5 class="modal-title" id="exampleModalLabel3">Xylo, Tavera, Enjoy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="images/g2.jpg" class="img-fluid" alt="" />
                    <p class="text-left my-4">
                                               In this we provide SUV type cars, in this 7 members can travel along with the driver and the luggages. You have an pleasend ride with your family and friends.
                    </p>
					<button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="index.php">BOOK NOW</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- //blog modal2 -->
    <!-- blog modal3 -->
    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-theme">
                    <h5 class="modal-title" id="exampleModalLabel4">Assured Innova</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="images/g3.jpg" class="img-fluid" alt="" />
                    <p class="text-left my-4">
                        In this we provide INNOVA CRYSTA, TEMPO TRAVELER, 40/7 VAN type cars, in this more than 7 members can travel along with the driver and the luggages. You have an pleasend ride with your family and friends.
                    </p>
					<button type="button" class="btn blog-btn text-lg-center  wthree-bnr-btn"><a href="index.php">BOOK NOW</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- //blog modal3-->
    <!-- js -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- //js -->
    <!-- script for password match -->
    <script>
        window.onload = function () {
            document.getElementById("password1").onchange = validatePassword;
            document.getElementById("password2").onchange = validatePassword;
        }

        function validatePassword() {
            var pass2 = document.getElementById("password2").value;
            var pass1 = document.getElementById("password1").value;
            if (pass1 != pass2)
                document.getElementById("password2").setCustomValidity("Passwords Don't Match");
            else
                document.getElementById("password2").setCustomValidity('');
            //empty string means no validation error
        }
    </script>
    <!-- script for password match -->
    <!-- Banner  Responsiveslides -->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        // You can also use"$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider3").responsiveSlides({
                auto: true,
                pager: true,
                nav: false,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>
    <!-- //Banner  Responsiveslides -->
    <!-- Scrolling Nav JavaScript -->
    <script src="js/scrolling-nav.js"></script>
    <script src="js/counter.js"></script>
    <!-- portfolio -->
    <script src="js/jquery.picEyes.js"></script>
    <script>
        $(function () {
            //picturesEyes($('.demo li'));
            $('.demo li').picEyes();
        });
    </script>
    <!-- //portfolio -->
    <!-- start-smooth-scrolling -->
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();

                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->
    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function () {
            /*
            var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
            };
            */
            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- color switch -->
    <script src="js/blast.min.js"></script>
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
</body>

</html>
<a  onclick="function()" href="https://wa.me/+918190006205/?text=Hi..Drop Taxi Madurai..." class="float9">
<img src="images/580b57fcd9996e24bc43c543.png" width="100%"/>

</a>
<a href="tel://+918190006205" class="float10">
<img src="images/phone-call-icon-16.png" width="100%"/>
</a>
