<div class="w3-bar  w3-blue-gray w3-card  w3-medium" >

            <form name="frm" action="import.php" method="POST">
                <input id="iurl" type="hidden" value="<?php echo $iurl ?>" name="iurl"/>
                <input id="token" type="hidden" value="<?php echo $token ?>" name="token"/> 
                <input class="w3-bar-item w3-button w3-hide-small  w3-right-align w3-hover-white w3-mobile" value="Home" type="submit" style="background-color: #009688">
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
        
            <div class="w3-responsive w3-dropdown-hover w3-hide-small">
                <button class="w3-button" title="Advanced Reports">More <i class="fa fa-caret-down"></i></button>     
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
            </div>
    
        </div>