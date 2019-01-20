<!DOCTYPE html>
<html>
    <title>Batch</title>
    <link rel="icon" type="image/png" href="CSS/imges/PageLogo.PNG" />
<style>
body, html {
    height: 100%;
    margin: 0;
}

.bgimg {
    background-image: url('css/imges/coming_soon.jpg');
    height: 100%;
    background-position: center;
    background-size: cover;
    position: relative;
    color: white;
    font-family: "Courier New", Courier, monospace;
    font-size: 25px;
}

.topleft {
    position: absolute;
    top: 0;
    left: 16px;
}

.bottomleft {
    position: absolute;
    bottom: 0;
    left: 16px;
}

.middle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

hr {
    margin: auto;
    width: 40%;
}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <?php $token = $_POST['token']; ?>
    <?php $iurl =  $_POST['iurl'];  ?>

<!-- Navigation bar -->
    <div class="w3-bar w3-theme-d2 w3-left-align">
        <form name="frm" action="import.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Home" type="submit" style="background-color: #009688">
        </form>   
        
        <form name="frm" action="statistics.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Statistics" type="submit">
        </form>   
                
        <form name="frm" action="subject_wise.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Subject Wise" type="submit">
        </form>   

        <form name="frm" action="student_wise.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Student Wise" type="submit">
        </form>   
        
        <form name="frm" action="batch_wise.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Batch Wise" type="submit">
        </form>   
        
        <form name="frm" action="year_wise.php" method="POST">
            <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
            <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
            <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Year Wise" type="submit">
        </form>   
        
        
        <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-button" title="Advanced Reports">More<i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-card-4 w3-bar-block">
                <form name="frm" action="gender_wise.php" method="POST">
                    <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
                    <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
                    <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Gender Wise" type="submit">
                </form>   

                <form name="frm" action="teacher_wise.php" method="POST">
                    <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
                    <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
                    <input class="w3-bar-item w3-button w3-hide-small w3-hover-white w3-mobile" value="Teacher Wise" type="submit">
                </form>   
                <a href="#" class="w3-bar-item w3-button w3-mobile">....</a>
            </div>
        </div>  <!-- Search box -->
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-teal w3-mobile" title="Search"><i class="fa fa-search"></i></a>
    </div>
<!--</div>-->

<div class="bgimg">
  <div class="topleft">
    <br>
    <h1>In-Depth</h1>
  </div>
  <div class="middle">
    <h1>COMING SOON</h1>
    <hr>
    <h3 id="demo" style="font-size:70px; color: red;"></h3>
  </div>
  <div class="bottomleft">
      <p>Contuct Us</p>
      <p>Address: Al Ain - United arab emirates</p>
      <p>Email: info@indepth.ae</p>
      <p>Email: Support@indepth.ae</p>
  </div>
</div>

<script>
// Set the date we're counting down to
var countDownDate = new Date("OCT 1, 2018 00:00:").getTime();

// Update the count down every 1 second
var countdownfunction = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(countdownfunction);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);
</script>

</body>
</html>
