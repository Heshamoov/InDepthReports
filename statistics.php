<?php include('Header.php'); ?>

<title>Statistics</title>

</head>



<script type="text/javascript"> 
$(function () {
    
    $('#term').multiselect({ includeSelectAllOption: true });
    $('#grade').multiselect({  includeSelectAllOption: true });
    $('#batch').multiselect({ includeSelectAllOption: true });
    $('#subject').multiselect({ includeSelectAllOption: true });
    $('#gender').multiselect({ includeSelectAllOption: true });
    
    $( document ).on("ready click",function () {
        
        var selected_terms = $("#term option:selected");
        var selected_grades = $("#grade option:selected");
        var selected_batches = $("#batch option:selected");
        var selected_subjects = $("#subject option:selected");
        var selected_gender = $("#gender option:selected");

        //Terms
        var message = "";     var termHeader = "";
        selected_terms.each(function () {
                if (message ===""){
                    message = " (exam_groups.name = '" + $(this).text() + "'";
                    termHeader = $(this).text();
                } else {
                    message += " OR exam_groups.name = '" + $(this).text() + "'";
                    termHeader += " , " + $(this).text();
                }
        });
        if (message !== "")
            selected_terms = message + ")";
        else
            selected_terms = "";

        //Grades                
        var message = "";     var gradeHeader = "";
        selected_grades.each(function () {
            var currentGrade = $(this).text();
            if (currentGrade.indexOf("(") !== -1) {
                var bracketIndex = currentGrade.indexOf("(");
                currentGrade = currentGrade.slice(0,bracketIndex);
            }
            if (message ===""){
                if (selected_terms !== "") 
                    message = " AND (courses.course_name = '" + currentGrade + "' ";
                else 
                    message = " (courses.course_name = '" + currentGrade + "'";
                gradeHeader = " - " + currentGrade;
            } else {
                message += " OR courses.course_name = '" + currentGrade + "'";  //  grade like 'GR1' OR grade like 'GR10';
                gradeHeader += " , " + currentGrade;
            }
        });
        if (message !== "")
            selected_grades = message + ")";
        else
            selected_grades = "";


        //Batches
        var message = "";       var batchHeader = "";
        selected_batches.each(function () {
            if (message === "") {
                if (selected_grades !== "") 
                        message = " AND (batches.name = '" + $(this).text() + "' ";
                else 
                        message = " (batches.name = '" + $(this).text() + "' ";
                batchHeader = " - " + $(this).text();
            } else {
                message += " OR batches.name = '" + $(this).text() + "' ";
                batchHeader += " , " + $(this).text();
            }
        });
        if (message !== "")
            selected_batches = message + ")";
        else
            selected_batches = "";

        //Gender
        var message = "";       var genderHeader = "";
        selected_gender.each(function () {
            
            var DB_Gender = "";
            if ($(this).text() === 'Male')
                DB_Gender = 'm';
            else if ($(this).text() === 'Female')
                DB_Gender = 'f';
                
            if (message === "") {
                if (selected_terms !=="" || selected_grades !== "" || selected_batches !== "") 
                    message = " AND (gender = '" + DB_Gender + "' ";
                else 
                    message = " (gender = '" + DB_Gender + "' ";
                genderHeader = " - " + $(this).text();
                } else {
                    message += "OR gender = '" + DB_Gender + "' ";
                    genderHeader += " , " + $(this).text();
                }
        });
        if (message !== "")
            selected_gender = message + ")";
        else
            selected_gender = "";

        //Generate Tables
        for (var i = 1; i < 13; i++)
        {
            var tableName = 'T' + i;
            document.getElementById(tableName).style.visibility = "hidden";
        }
        var message = "";    var subjectHeader = ""; var tableNumber = 0;
        
        //Subjects
        selected_subjects.each(function () {
            var currentSubject = "";    var firstSpace = true;
            var subject = $(this).text();     
            for (var i = 0; i < subject.length; i++) {       // Extracting English letters and numbers and remove Arabic letters                
                if ((subject[i] >= 'A' && subject[i] <= 'z') || (subject[i] >= '0' && subject[i] <= '9'))
                    currentSubject += subject[i];
                if (subject[i] === ' ' && firstSpace && i > 3) {
                    currentSubject += subject[i];
                    firstSpace = false;
                }
            }
            
            tableNumber++;
            if (message === "") {
                if (selected_terms !== "" || selected_grades !== "" || selected_batches !== "" || selected_gender !== "") 
                    message = " AND (subjects.name  LIKE '" + currentSubject + "%' ";  //Add '%' to the end of the subject name: WHERE subject LIKE 'Math%' 
                else
                    message = " (subjects.name = '" + currentSubject +  "' " ;
                subjectHeader = " - " + currentSubject;
            } else {
                message += "OR subjects.name  LIKE '" + currentSubject + "%' ";
                subjectHeader += " , "+ currentSubject;
            }
            
            
            tableName = "T" + tableNumber;
            var tableNeme2 = 'TT' + tableNumber;
            document.getElementById(tableName).style.visibility = "Visible";
            var table = document.getElementById(tableName);
            var table2 = document.getElementById(tableNeme2);
            table.rows[0].cells[0].innerHTML = currentSubject;  //head
            table2.rows[0].cells[0].innerHTML = currentSubject; //head                        
                                                                                                                       //Academic //Total
            var min=0,max =0;                                                                    // Head values
            for (var i=2; i<5; i++)                 
            {
                min = stable.rows[1].cells[i].childNodes[0].value;
                max= stable.rows[1].cells[i].childNodes[2].value;
                table.rows[1].cells[i].innerHTML = min + "% - " + max + "%";                                
                table2.rows[1].cells[i].innerHTML = min + "% - " + max + "%";                                
            }
            
            //Academic Year value
            stablePDF.rows[2].cells[0].innerHTML = "2017-2018";
            table.rows[2].cells[0].innerHTML = "2017-2018";
            table2.rows[2].cells[0].innerHTML = "2017-2018";                       
            
            // Total value Subject wise
            var httpTotal = new XMLHttpRequest();
            httpTotal.onreadystatechange = function() {
                if (this.readyState === 4) {
                    table.rows[2].cells[1].innerHTML = this.responseText;
                    table2.rows[2].cells[1].innerHTML = this.responseText;                                        
                }
            }; 
            httpTotal.open("POST", "sqldb/subjectCount.php?terms=" + selected_terms + "&grades=" + selected_grades + "&batches=" + selected_batches + "&subject=" + currentSubject + "&gender=" + selected_gender, false);
            httpTotal.send();
            
                             
            

            //Between values Subject wise
            var min=0,max =0;
            for (var i=2; i<5; i++)
            {
                min = stable.rows[1].cells[i].childNodes[0].value;
                max= stable.rows[1].cells[i].childNodes[2].value;
                var httpBetween = new XMLHttpRequest();
                httpBetween.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        table.rows[2].cells[i].innerHTML = this.responseText;
                        table2.rows[2].cells[i].innerHTML = this.responseText;                                                
                    }
                };
                httpBetween.open("POST", "sqldb/subjectBetween.php?terms=" + selected_terms + "&grades=" + selected_grades + "&batches=" + selected_batches + "&subject=" + currentSubject + "&gender=" + selected_gender + "&min=" + min + "&max=" + max, false);
                httpBetween.send();
            }
        });

        if (message !== "")
            selected_subjects = message + ")";
        else
            selected_subjects = "";
        
        stable.rows[0].cells[0].innerHTML =  "Statistics: "+termHeader + " " + gradeHeader + " " + batchHeader + "" + "  " + subjectHeader + "  " + genderHeader; 
        stablePDF.rows[0].cells[0].innerHTML =  termHeader + " " + gradeHeader + " " + batchHeader + " " + " ( " + subjectHeader + " ) " + genderHeader; 

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4)
                document.getElementById("out").innerHTML = this.responseText;
        };
        xmlhttp.open("POST", "sqldb/statisticsSearch.php?terms=" + selected_terms + "&grades=" + selected_grades + "&batches=" + selected_batches + "&subjects=" + selected_subjects + "&gender=" + selected_gender, false);
        xmlhttp.send();

        //Total Count
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                
                stable.rows[2].cells[1].innerHTML = this.responseText;
                stablePDF.rows[2].cells[1].innerHTML = this.responseText;
                drawChart()
            }
        }; 
        xmlhttp.open("POST", "sqldb/count.php?terms=" + selected_terms + "&grades=" + selected_grades + "&batches=" + selected_batches + "&subjects=" + selected_subjects + "&gender=" + selected_gender, false);
        xmlhttp.send();

        //Statistics Min-Max
        var min=0,max =0;
        for (var i=2; i<5; i++)
        {
            min = stable.rows[1].cells[i].childNodes[0].value;
            max= stable.rows[1].cells[i].childNodes[2].value;
            stablePDF.rows[1].cells[i].innerHTML = min + "% - " + max + "%";
            var xmlhttpm1 = new XMLHttpRequest();
            xmlhttpm1.onreadystatechange = function() {
               
                if (this.readyState === 4) {
                    stable.rows[2].cells[i].innerHTML = this.responseText;
                    stablePDF.rows[2].cells[i].innerHTML = this.responseText;
                     drawChart();
                }
            };
            xmlhttpm1.open("POST", "sqldb/between.php?terms=" + selected_terms + "&grades=" + selected_grades + "&batches=" + selected_batches + "&subjects=" + selected_subjects + "&gender=" + selected_gender + "&min=" + min + "&max=" + max, false);
            xmlhttpm1.send();
        }
    });
});




</script>
 
<script>
        
google.charts.load("current", {
packages: ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
        var value1, value2,value3,value4, value5, value6, result1, result2, result3,  tableName , header ;
            var tableName = document.getElementById("stable");

                value1 = tableName.rows[1].cells[2].childNodes[0].value;
                value2= tableName.rows[1].cells[2].childNodes[2].value;
                value3= tableName.rows[1].cells[3].childNodes[0].value;
                value4= tableName.rows[1].cells[3].childNodes[2].value;
                value5= tableName.rows[1].cells[4].childNodes[0].value;
                value6= tableName.rows[1].cells[4].childNodes[2].value;
                result1 = tableName.rows[2].cells[2].innerHTML;
                result2 = tableName.rows[2].cells[3].innerHTML;
                result3 = tableName.rows[2].cells[4].innerHTML;
                header = tableName.rows[0].cells[0].innerHTML;
         


                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Number of Students');
                data.addColumn('number', 'Students');
                data.addColumn({type:'string', role:'style'});
                
                data.addRows([
                        [ value1.toString() + '% - ' + value2.toString() + "% ", Number(result1), ' yellow'],
                        [ value3.toString()+ '% - ' + value4.toString() + "% ",Number(result2), 'orange'],
                        [ value5.toString() + '% - ' + value6.toString() + "%", Number(result3), ' lime'],
                            ]);
                var options = {title: header };
                        
                      
                        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                         chart.draw(data, options); 
   
        
    }; 


</script>

<body>
    
    
    <div class=" w3-responsive header" >
    
        <!-- Navigation bar -->        
        <?php include('navbar.php'); ?>
        
        <!--set color for current tab-->
        <script>
            document.getElementById("navStatistics").style.backgroundColor = '#009688' ;
        </script>

        <!--End of Navictacoin bar-->
        
        <!--Drop menus-->
        <div id="upperdiv" class="w3-container w3-mobile" style="padding-top: 10px; padding-bottom: 10px">
            <table id= "table1">

                <tr>
                    <td></td><td>Term</td>
                    <td>Grade</td>  <td>Section</td>  <td>Subject</td><td>Gender</td><td></td>
                </tr>
                <tr>
                    <td>
                        <button class="w3-button w3-round-xlarge w3-hover-blue-gray w3-medium w3-custom" id="exportS" onclick="downloadStatistics()()" title="Export Statistics as PDF">Export Statistics
                            <span class="material-icons">save_alt</span></button>
                    </td>
                   
                    <td>
                        <select   id="term"   multiple="multiple"></select>   
                    </td>
                    <td >
                        
                        <select  id ="grade" multiple="multiple"  ></select>  
                    </td>
                    <td>
                        <select id="batch"  multiple="multiple"></select>
                    </td>
                    <td>
                        <select id="subject"  multiple="multiple"></select>         
                    </td>
                    <td>
                            <select id="gender"  multiple="multiple"> 
                                <option>Male</option>
                                <option>Female</option> 
                            </select>
                    </td>
                   
                    <td>
                        <button style="padding: 15px 32px 32px 32px;text-align: center ;font-size: 14px;" class="w3-button w3-hover-blue-gray w3-custom w3-round-large " id="search" title="Get students marks">Search    <span class="fa fa-search"></span></button>
                    </td>
                    
                    <td>
                        <button  class="w3-button w3-hover-blue-gray w3-custom w3-medium w3-round-xlarge" id="exportM" onclick="downloadStudents()" title="Export Marks as PDF">Export Marks <span class="material-icons ">save_alt</span></button>
                    </td>
                    
                </tr>
                    
            </table>
          
        </div>

        <!--Drop menus-->
        
    <div class="w3-container w3-col m4 l5 w3-mobile" id="tables" style="overflow: scroll;top: 0;  bottom: 0; height: 100vh; " >
        <textarea id="output" rows="10" cols="50" hidden></textarea>
        <br>
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="stable">  
            <th colspan="4" class="w3-custom " style="font-size: 16px">Statistics 
           </th>
           <th colspan="1" class="w3-custom">  <button  style="float: right;"type="button" class="btn w3-button w3-hover-blue-gray w3-custom" 
                                                        data-toggle="popover" >
                                                        <span class="material-icons ">signal_cellular_alt</span>
                                                </button></th>
           

            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Marks Count</th>
                <th class="w3-border-right"><input id="percent11" type="text" value= 50>% - <input id="percente12" type="text" value=100>%</th>
                <th class="w3-border-right"><input id="percent21" type="text" value=65>% - <input id="percente22" type="text" value=100>%</th>
                <th class="w3-border-right"><input id="percent31" type="text" value=75>% - <input id="percente32" type="text" value=100>%</th>
            </tr>
            <tr>
                <td class="w3-border-right">2017-2018</td>
                <td class="w3-border-right"></td>
                <td class="w3-border-right"></td>
                <td class="w3-border-right"></td>
                <td class="w3-border-right"></td>
            </tr>
        
        
        </table>
        <br><br>
        
        <table id="stablePDF" style="font-size: 100px" hidden>
            <thead>
                <tr>
                    <th colspan="5"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <th>Year</th>
                    <th>Total Number</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <table id="T1" class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" >
        <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
        <tr>
            <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
            <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
        </tr>
        <tr>
            <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
            <td class="w3-border-right"></td><td class="w3-border-right"></td>
        </tr>
        </table>
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T2">  
            <th colspan="5" class="w3-custom" style="font-size: 16px;">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
    
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T3">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T4">
             <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T5">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
    
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T6">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>

        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T7">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T8">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T9">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>    
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T10">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T11">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
        
        <br>
    
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T12">  
            <th colspan="5" class="w3-custom" style="font-size: 16px">Subject</th>
            <tr>
                <th class="w3-border-right">Academic Year</th><th class="w3-border-right">Total</th>
                <th class="w3-border-right"></th><th class="w3-border-right"></th><th class="w3-border-right"></th>
            </tr>
            <tr>
                <td class="w3-border-right"></td><td class="w3-border-right"></td><td class="w3-border-right"></td>
                <td class="w3-border-right"></td><td class="w3-border-right"></td>
            </tr>
        </table>
            
    </div>
        
    <div class="w3-col m8 l7 w3-card-4 w3-mobile" id="rightdiv" style = "height:100vh; overflow: scroll; padding-top: 10px; padding-left: 10px; padding-right: 10px"> 
        <!--Downloading table  11:52 AM-->   
        <br>

        <table class="w3-table-all w3-card-4 w3-striped w3-hoverable" id="out" ></table>
        <table id="TT1" hidden>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Year</td>
                    <td>Total Number</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>
            </tbody>
        </table>
        <table id="TT2" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT3" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT4" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT5" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT6" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT7" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT8" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT9" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT10" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT11" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>
        <table id="TT12" hidden>
            <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
            <tbody><tr><td>Year</td><td>Total Number</td><td></td><td></td><td></td></tr>
                   <tr><td></td><td></td><td></td><td></td><td></td></tr></tbody>
        </table>    
    </div>
    
   <button onclick="topFunction()" style="left:0; padding: 10px;" class=" w3-hover-blue-gray w3-small" id="myBtn" title="Go to top"><span class="glyphicon glyphicon-arrow-up"style="font-size: 25px;" ></span></button>

    <!--Scroll Handling-->
    </div>
    <script>
        document.getElementById("tables").onscroll = function() {scrollFunction();};
        function scrollFunction() {
            if (document.getElementById("tables").scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else
                document.getElementById("myBtn").style.display = "none";
            };
        function topFunction() {
            document.getElementById("tables").scrollTop = 0;
            
            
        };
    </script>
    
      
    <!--Term drop down  AND Tables initializer-->  
    <script type="text/javascript">
        for (var i = 1; i < 13; i++)
        {
            var tableName = 'T' + i;
            document.getElementById(tableName).style.visibility = "hidden";
        }
        var termsArray = ["Your Data Base is Empty!."];
        var httpterms = new XMLHttpRequest();
        httpterms.onreadystatechange = function() {
            if (this.readyState === 4) {
                var str = this.responseText;
                termsArray = str.split("\n");
            }
        };
        httpterms.open("GET", "sqldb/displayTerms.php", false);
        httpterms.send();

        var select = document.getElementById( 'term' );
        delete termsArray[termsArray.length - 1];
        for( var i in termsArray ) {
            select.add( new Option( termsArray[i] ) );
        };   
    
        $(function () {
            $('#term').multiselect({
                includeSelectAllOption: true
            });     
         });
    </script>

    
<!--Initialize Grade drop down-->     
<script type="text/javascript">
        var gradesArray = ["Your Data Base is Empty!."];
         
        var httpgrades = new XMLHttpRequest();
        httpgrades.onreadystatechange = function() {
                if (this.readyState === 4) {
                        var str = this.responseText;
                        gradesArray = str.split("\n");   
                  }
         };
         httpgrades.open("GET", "sqldb/initGrades.php", false);
         httpgrades.send();

         var select = document.getElementById( 'grade' );
         delete gradesArray[gradesArray.length -1];
         for( var i in gradesArray ) {
                  select.add( new Option( gradesArray[i] ) );
         };   
    
         $(function () {
                  $('#grade').multiselect({
                           includeSelectAllOption: true
                  });     
         });
</script>

<!--Initialize Batch drop down-->     
<script type="text/javascript">
        var batchesArray = ["Your Data Base is Empty!."];
         
        var httpBatches = new XMLHttpRequest();
        httpBatches.onreadystatechange = function() {
                if (this.readyState === 4) {
                        var str = this.responseText;
                        batchesArray = str.split("\n");   
                  }
         };
         httpBatches.open("GET", "sqldb/initBatches.php", false);
         httpBatches.send();

         var select = document.getElementById( 'batch' );
         delete batchesArray[batchesArray.length -1];
         for( var i in batchesArray ) {
                  select.add(new Option(batchesArray[i]));
         };   
    
         $(function () {
                  $('#batch').multiselect({
                           includeSelectAllOption: true
                  });     
         });
</script>

<!--Initialize Subject drop down-->     
<script type="text/javascript">
        var subjectsArray = ["Your Data Base is Empty!."];
         
        var httpSubjects = new XMLHttpRequest();
        httpSubjects.onreadystatechange = function() {
                if (this.readyState === 4) {
                        var str = this.responseText;
                        subjectsArray = str.split("\n");   
                  }
         };
         httpSubjects.open("GET", "sqldb/initSubjects.php", false);
         httpSubjects.send();

         var select = document.getElementById( 'subject' );
         delete subjectsArray[subjectsArray.length -1];
         for( var i in subjectsArray ) {
                  select.add( new Option( subjectsArray[i] ) );
         };   
    
         $(function () {
                  $('#subject').multiselect({
                           includeSelectAllOption: true
                  });     
         });
</script>

<!--Batches via Grades-->
<!--<script type="text/javascript">
document.getElementById("grade").onchange = function() {fetchBatches();};
function fetchBatches() {
        output.value = "";
        var str ="";
        var fillBatch = document.getElementById('batch'); var fillSubject = document.getElementById('subject');
        var selectedGrades = $("#grade option:selected");
        var distinctArray = []; var distinctIndex = 0;  var gradesBatches = [];      
        var distinctArraySubject = []; var distinctIndexSubject = 0;  var gradesSubjects = [];      
        while (fillBatch.length > 0)
                fillBatch.remove(0);
        while (fillSubject.length > 0)
                fillSubject.remove(0);
        
        selectedGrades.each(function() {
                var currentGrade = $(this).text().slice(0,4);
                if (currentGrade.indexOf(" ") === 3)
                        currentGrade = currentGrade.slice(0,3);
                var httpbatches = new XMLHttpRequest();
                httpbatches.onreadystatechange = function() {
                        if (this.readyState === 4) {
                                str = this.responseText;  output.value += str + "\n";
                                var strArray = str.split(" ");
                                var lastindex = strArray.length - 1;      delete strArray[lastindex];
                                for (var i in strArray) {
output.value += "distinctArray[" + distinctIndex + "] = " + distinctArray[distinctIndex] + "= strArray[" + i + "] = " + strArray[i] + "\n";
                                        distinctArray[distinctIndex] = strArray[i];
                                        gradesBatches[distinctIndex] = currentGrade;
                                        distinctIndex++;
                                }
                        }
                };
                httpbatches.open("GET", "sqldb/distinctBatches.php?grade=" + currentGrade, false);
                httpbatches.send();
         });
         var duplicated = false;
         $('#batch').multiselect('destroy');
         var length = distinctArray.length;
         for ( var i = 0; i < length; i++) {  output.value += "inside first for " + length + "\n";
                var transferGrade = " (" + gradesBatches[i];
                for (var j = i+1; j < length; j++) { 
                        output.value += "inside second for\n";
                        output.value += "distinctArray[" + i + "] = " + distinctArray[i] + " = distinctArray[" + j + "] = " + distinctArray[j] + "\n";
                        if ( distinctArray[i] === distinctArray[j]) {
                                transferGrade += " - " + gradesBatches[j];
                                var start = j+1;
                                for (start ; start < length; start++) {
                                    distinctArray[start - 1] = distinctArray[start];
                                    gradesBatches[start -1] = gradesBatches[start];
                                }
                                delete distinctArray[start];        delete gradesBatches[start];
                                length--;                                duplicated = true;                      j--;                
                        }
                }
                if (duplicated) {
                        fillBatch.add(new Option (distinctArray[i] + " " + transferGrade + ")"));
                        duplicated = false;
                  } else 
                           fillBatch.add(new Option (distinctArray[i] + " " + transferGrade + ")"));
        }
         $('#batch').multiselect('rebuild');
         output.value += "\n Subject \n";
         
         
// Fetch & Fill Subjects
        selectedGrades.each(function() {
                var currentGrade = $(this).text().slice(0,4);
                var httpSubjects = new XMLHttpRequest();
                httpSubjects.onreadystatechange = function() {
                        if (this.readyState === 4) {
                                str = this.responseText;  output.value += str + "\n";
                                var strArray = str.split("?");
                                var lastindex = strArray.length - 1;      delete strArray[lastindex];
                                for (var i in strArray) {
output.value += "distinctArray[" + distinctIndexSubject + "] = " + distinctArraySubject[distinctIndexSubject] + "= strArray[" + i + "] = " + strArray[i] + "\n";
                                        distinctArraySubject[distinctIndexSubject] = strArray[i];
                                        gradesSubjects[distinctIndexSubject] = currentGrade;
                                        distinctIndexSubject++;
                                }
                        }
                };
                httpSubjects.open("GET", "sqldb/distinctSubjects.php?grade=" + currentGrade, false);
                httpSubjects.send();
         });
         var duplicated = false;
         $('#subject').multiselect('destroy');
         var length = distinctArraySubject.length;
         for ( var i = 0; i < length; i++) {  output.value += "inside first for " + length + "\n";
                var transferGrade = " (" + gradesSubjects[i];
                for (var j = i+1; j < length; j++) { 
                        output.value += "inside second for\n";
                        output.value += "distinctArray[" + i + "] = " + distinctArraySubject[i] + " = distinctArray[" + j + "] = " + distinctArraySubject[j] + "\n";
                        if ( distinctArraySubject[i] === distinctArraySubject[j]) {
                                output.value += "Equal => ";
                                transferGrade += " - " + gradesSubjects[j];
                                output.value += transferGrade + "\n";
                                var start = j+1;
                                for (start ; start < length; start++) {
                                    distinctArraySubject[start - 1] = distinctArraySubject[start];
                                    gradesSubjects[start -1] = gradesSubjects[start];
                                }
                                delete distinctArraySubject[start];        delete gradesSubjects[start];
                                length--;                                duplicated = true;                      j--;                
                        }
                }
                if (duplicated) {
                        fillSubject.add(new Option (distinctArraySubject[i] + " " + transferGrade + ")"));
                        duplicated = false;
                  } else 
                           fillSubject.add(new Option (distinctArraySubject[i] + " " + transferGrade + ")"));
        }
         $('#subject').multiselect('rebuild');
};
</script>-->

 <!--Grades via Terms-->
<!-- <script type="text/javascript">
document.getElementById("term").onchange = function() {fetchGrades();};
function fetchGrades() {
        var str =""; var fillGrades = document.getElementById('grade');               
        var selectedTerms = $("#term option:selected");
        var distinctArray = []; var distinctIndex = 0;  var termsGrades = [];      
        while (fillGrades.length > 0)
                fillGrades.remove(0);
        
        selectedTerms.each(function() {
                var currentTerm = $(this).text();
                var httpGrades = new XMLHttpRequest();
                httpGrades.onreadystatechange = function() {
                        if (this.readyState === 4) {
                                str = this.responseText;  output.value += str + "\n";
                                var strArray = str.split(" ");
                                var lastindex = strArray.length - 1;      delete strArray[lastindex];
                                for (var i in strArray) {
output.value += "distinctArray[" + distinctIndex + "] = " + distinctArray[distinctIndex] + "= strArray[" + i + "] = " + strArray[i] + "\n";
                                        distinctArray[distinctIndex] = strArray[i];
                                        termsGrades[distinctIndex] = currentTerm;
                                        distinctIndex++;
                                }
                        }
                };
                httpGrades.open("GET", "sqldb/distinctGrades.php?term=" + currentTerm, false);
                httpGrades.send();
         });
         var duplicated = false;
         $('#grade').multiselect('destroy');
         var length = distinctArray.length;
         for ( var i = 0; i < length; i++) {  output.value += "inside first for " + length + "\n";
                var transferTerm = " (" + termsGrades[i];
                for (var j = i+1; j < length; j++) { 
                        output.value += "inside second for\n";
                        output.value += "distinctArray[" + i + "] = " + distinctArray[i] + " = distinctArray[" + j + "] = " + distinctArray[j] + "\n";
                        if ( distinctArray[i] === distinctArray[j]) {
                                transferTerm += " - " + termsGrades[j];
                                var start = j+1;
                                for (start ; start < length; start++) {
                                    distinctArray[start - 1] = distinctArray[start];
                                    termsGrades[start -1] = termsGrades[start];
                                }
                                delete distinctArray[start];        delete termsGrades[start];
                                length--;                                duplicated = true;                      j--;                
                        }
                }
                if (duplicated) {
                        fillGrades.add(new Option (distinctArray[i] + " " + transferTerm + ")"));
                        duplicated = false;
                  } else 
                           fillGrades.add(new Option (distinctArray[i] + " " + transferTerm + ")"));
        }
         $('#grade').multiselect('rebuild');
};
</script>


--><script>
        function downloadStudents() {
                var doc = new jsPDF('p', 'pt','a4');
                var table = doc.autoTableHtmlToJson(document.getElementById("out"));
                var header = function(data) {
                        doc.setFontSize(16);
                        doc.setFontStyle('normal');
                        doc.text("Students List", 250, 50);
                        doc.line(250,53,335,53);// Header top margin
// Header top margin
                };
              
                doc.autoTable(table.columns, table.data,{beforePageContent: header,theme: 'grid',margin: {top: 70}, styles: {
        fontSize: 12,
        font: 'PTSans'
    }    
    } );
                doc.save("Students.pdf");
        }
</script><!--
--><script>
        function downloadStatistics() {
                var doc = new jsPDF('p', 'pt');
                var header = function(data) {
                        doc.setFontSize(18);
                        doc.setFontStyle('PTSans');
                        doc.text("Subject Wise Statistics",225,50);
                        doc.line(226,53,390,53);// Header top margin
                };
            
                var table = doc.autoTableHtmlToJson(stablePDF);    
                doc.autoTable(table.columns, table.data,{beforePageContent: header,theme: 'grid',margin: {top: 70, left:40,right:40},columnStyles: {
    0: {columnWidth: 205},
    1: {columnWidth: 80},
    2: {columnWidth: 80},
    3: {columnWidth: 80}
     }, styles: {
        fontSize: 12,
        font: 'PTSans',
    }
    
    });

                var tableName ="";  var i = 1;
                $('#subject').multiselect({ includeSelectAllOption: true });
                var selected_subjects = $("#subject option:selected");
                        selected_subjects.each(function() {
                       
                        tableName = 'TT' + i;
                        var table = doc.autoTableHtmlToJson(document.getElementById(tableName));
                        doc.autoTable(table.columns, table.data, {startY: doc.autoTable.previous.finalY + 14,margin: {left:40,right:40},theme: 'grid',columnStyles: {
    0: {columnWidth: 205},
    1: {columnWidth: 80},
    2: {columnWidth: 80},
    3: {columnWidth: 80}
     } ,styles: {
        fontSize: 12,
        font: 'PTSans'
    }});
                        i++;
                });
                doc.save("Statistics.pdf");
        }
</script>

            
<script>
 
    $(document).ready(function(){
    $('[data-toggle="popover"]').popover(
  {
trigger: "manual" ,
  html: true,
  content: function() {
  
    return $('#chart_div').html();
  }
}).on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    });

});
    
</script>



<div id = "popcontainer" class="popover-content-el hide " style="width:400px; "  >

    <div id="chart_div" style="width:400px; "  >
    </div>
</div>

</body>
</html>

