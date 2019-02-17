<!DOCTYPE html>
<html lang="en">
<head>
        <title>Subject Wise</title>
        <link rel="icon" type="image/png" href="CSS/imges/PageLogo.PNG" />    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/resultstyle.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="js/jspdf.min.js"></script>
        <script src="js/jspdf.debug.js"></script>
        <script src="js/jspdf.plugin.autotable.js"></script>    
<script type="text/javascript">
$(function () { $('#search').click(function () {
                
        var grade = document.getElementById("grade").options[document.getElementById("grade").selectedIndex].text;
        var subject = document.getElementById("subject").options[document.getElementById("subject").selectedIndex].text;
        
                // Between values Subject wise
                var min=0, tableName, term, gender;
                for (var t=1; t<5; t++) {
                        tableName = 'T' + t; 
                        for (var i=0; i<4; i++) {
                                if (i < 2) {
                                        term = tableName + "-Term1";
                                        term = document.getElementById(term).options[document.getElementById(term).selectedIndex].text;
                                        gender = tableName + "-Gender1";
                                        gender = document.getElementById(gender).options[document.getElementById(gender).selectedIndex].text;                                        
                                } else {
                                        term = tableName + "-Term2";
                                        term = document.getElementById(term).options[document.getElementById(term).selectedIndex].text;                                        
                                        gender = tableName + "-Gender2";
                                        gender = document.getElementById(gender).options[document.getElementById(gender).selectedIndex].text;                                        
                                }
                                
                                output.value += term + " " + gender;
                                min = document.getElementById(tableName).rows[2].cells[i].childNodes[0].value;
                                var httpAbove = new XMLHttpRequest();
                                httpAbove.onreadystatechange = function() {
                                        if (this.readyState === 4)
                                                document.getElementById(tableName).rows[3].cells[i].innerHTML = 
                                                this.responseText;
                                };
                                httpAbove.open("POST", "sqldb/marksAbove.php?term=" + term + 
                                        "&grade=" + grade  + "&subject=" + subject + 
                                        "&gender=" + gender + "&min=" +min, false);
                                                         
                                httpAbove.send();
                        }
                }
    
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMaterial);
function drawMaterial() {
        var grade = document.getElementById("grade").options[document.getElementById("grade").selectedIndex].text;
        var subject = document.getElementById("subject").options[document.getElementById("subject").selectedIndex].text;
        var value1, value2,value3,value4, result1, result2, result3, result4, tableName, chartName, gender1, gender2;
        for (var i = 1; i < 5; i++) {
                tableName = 'T' + i;
                
                var year = document.getElementById(tableName + '-Year').options[document.getElementById(tableName + '-Year').selectedIndex].text;
                var term1 = document.getElementById(tableName + '-Term1').options[document.getElementById(tableName + '-Term1').selectedIndex].text;
                var term2 = document.getElementById(tableName + '-Term2').options[document.getElementById(tableName + '-Term2').selectedIndex].text;
                var gender1 = document.getElementById(tableName + '-Gender1').options[document.getElementById(tableName + '-Gender1').selectedIndex].text;
                var gender2 = document.getElementById(tableName + '-Gender2').options[document.getElementById(tableName + '-Gender2').selectedIndex].text;

                value1 = document.getElementById(tableName).rows[2].cells[0].childNodes[0].value;
                value2 = document.getElementById(tableName).rows[2].cells[1].childNodes[0].value;
                value3 = document.getElementById(tableName).rows[2].cells[2].childNodes[0].value;
                value4 = document.getElementById(tableName).rows[2].cells[3].childNodes[0].value;        

                result1 = document.getElementById(tableName).rows[3].cells[0].innerHTML;
                result2 = document.getElementById(tableName).rows[3].cells[1].innerHTML;
                result3 = document.getElementById(tableName).rows[3].cells[2].innerHTML;
                result4 = document.getElementById(tableName).rows[3].cells[3].innerHTML;
                
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Number of Students');
                data.addColumn('number', 'Students');
                data.addColumn({type:'string', role:'style'});
                
                data.addRows([
                        [gender1 + "-" + value1.toString() + '% and above', Number(result1), ' #0066cc'],
                        [gender1 + "-" + value2.toString()+ '% and above',Number(result2), '#ff0000'],
                        [gender2 + "-" + value3.toString() + '% and above', Number(result3), ' #0066cc'],
                        [gender2 + "-" + value4.toString()+ '% and above',Number(result4), '#ff0000'],
                ]);
                var options = {
                        title:'(' + term1 + " " + gender1 + ') VS ('  + term2 + " " + gender2 + ") " + grade + '-' + subject,
                };
                chartName = 'chart' + i;
                
                var materialChart = new google.visualization.ColumnChart(document.getElementById(chartName));
                materialChart.draw(data, options);
        }
    };
    

});
    });
</script>

<body  onload="fillSubjects()">
    <?php $token = $_POST['token']; ?>
    <?php $iurl =  $_POST['iurl']; ?>
    
<div class=" w3-responsive header">
<!-- Navigation bar -->
<div class="w3-responsive w3-bar w3-theme-d2 w3-left-align">
        
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
        
        <div class="w3-responsive w3-dropdown-hover w3-hide-small">
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
        </div>
</div>

<div id="upperdiv" class="w3-container">
        <table id= "table1">
        <tr><td></td><td></td><td>Grade</td><td>Subject</td><td></td><td>Search</td></tr>
        <tr><td><button class="w3-button w3-blue" id="exportS" onclick="downloadStatistics()()" title="Export Statistics as PDF"><span class="material-icons">get_app</span></button>
        </td><td>|||</td><td><select id="grade"></select></td><td><select id="subject"> </select></td>
        <td>|||</td><td><button class="w3-button w3-blue w3-block" id="search" title="Get students marks"><span class="fa fa-search"></span></button></td>
        <td>|||</td><td><button class="w3-button w3-blue" id="exportM" onclick="downloadStudents()" title="Export Marks as PDF"><span class="material-icons">get_app</span></button></td>
        </tr>
        </table>
</div>

<div id="tables">
<!--Tables-->
<!--////////////////////////            Table 1     ///////////////////////////////////////////////////-->
<textarea id="output" rows="10" cols="50" hidden></textarea>
<div class="w3-row w3-border">
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T1">  
            <th colspan="4" class="w3-blue" style="font-size: 16px">Benchmark Data<br>Academic Year
                <select id="T1-Year">
                        
                </select>
        </th>
        <tr>
        <th colspan="2" class="w3-border-right">
                <select id="T1-Term1"></select>
                <select id="T1-Gender1">
                        <option>Boys</option>
                        <option>Girls</option>
                        <option>Both</option>
                </select>            
        </th>
        <th colspan="2" class="w3-border-right">
                <select id="T1-Term2"></select>
                <select id="T1-Gender2">
                        <option>Girls</option>
                        <option>Boys</option>
                        <option>Both</option>
                </select>            
        </th>
        </tr>
                <tr>
                        <td class="w3-border-right"><input type="text" value= 80>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 85>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 90>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 95>% and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                </tr>
        </table>
                <br>
                <div class="w3-half w3-card-4" id="chart1"></div>
        </div>
    
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-centered w3-card-4" id="T2">  
                <th colspan="4" class="w3-blue" style="font-size: 16px">Benchmark Data<br>Academic Year
                        <select id="T2-Year">
                        </select></th>
                <tr>
                <th colspan="2" class="w3-border-right">
                        <select id="T2-Term1"></select>
                        <select id="T2-Gender1">
                                <option>Boys</option>
                                <option>Girls</option>
                                <option>Both</option>
                        </select>            
                </th>
                <th colspan="2" class="w3-border-right">
                        <select id="T2-Term2"></select>
                        <select id="T2-Gender2">
                                <option>Girls</option>
                                <option>Boys</option>
                                <option>Both</option>
                        </select>                    
                </th>
                </tr>
                <tr>
                        <td class="w3-border-right"><input type="text" value= 80>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 85>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 90>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 95>% and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                </tr>
        </table>
        <br>
        <div class="w3-half w3-card-4" id="chart2"></div>
        </div>
    
</div>
<br><br>
<!--////////////////////////            Table 2     ///////////////////////////////////////////////////-->
<div class="w3-row w3-border">
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T3">  
        <th colspan="4" class="w3-blue" style="font-size: 16px">Benchmark Data<br>Academic Year
                <select id="T3-Year">
                </select>
        </th>
        <tr>
        <th colspan="2" class="w3-border-right">
                <select id="T3-Term1"></select>
                <select id="T3-Gender1">
                        <option>Boys</option>
                        <option>Girls</option>
                        <option>Both</option>
                </select>            
        </th>
        <th colspan="2" class="w3-border-right">
                <select id="T3-Term2"></select>
                <select id="T3-Gender2">
                        <option>Girls</option>
                        <option>Boys</option>
                        <option>Both</option>
                </select>            
        </th>
        </tr>
                <tr>
                        <td class="w3-border-right"><input type="text" value= 80>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 85>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 90>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 95>% and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                </tr>
        </table>
        <br>
        <div class="w3-half w3-card-4" id="chart3"></div>
        </div>
    
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T4">  
                <th colspan="4" class="w3-blue" style="font-size: 16px">Benchmark Data<br>Academic Year
                        <select id="T4-Year" style.visiblity='display:hide'>
                        </select></th>
                <tr>
                <th colspan="2" class="w3-border-right">
                        <select id="T4-Term1"></select>
                        <select id="T4-Gender1">
                                <option>Boys</option>
                                <option>Girls</option>
                                <option>Both</option>
                        </select>            
                </th>
                <th colspan="2" class="w3-border-right">
                        <select id="T4-Term2"></select>
                        <select id="T4-Gender2">
                                <option>Girls</option>
                                <option>Boys</option>
                                <option>Both</option>
                        </select>                    
                </th>
                </tr>
                <tr>
                        <td class="w3-border-right"><input type="text" value= 80>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 85>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 90>% and above</td>
                        <td class="w3-border-right"><input type="text" value= 95>% and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                        <td class="w3-border-right">100</td>
                        <td class="w3-border-right">50</td>
                </tr>
        </table>
        <br>
        <div class="w3-half w3-card-4" id="chart4"></div>
        </div>
</div>
    
<!--////////////////////////            Table 3     ///////////////////////////////////////////////////-->
        
    </div>
</div>
   
<script src="js/jspdf.debug.js"></script>
<script src="js/jspdf.plugin.autotable.js"></script>
<script>
    function generate() {
        var doc = new jsPDF('p', 'pt');
        var res = doc.autoTableHtmlToJson(document.getElementById("out"));
        doc.autoTable(res.columns, res.data, {margin: {top: 80}});
        var header = function(data) {
            doc.setFontSize(18);
            doc.setTextColor(40);
            doc.setFontStyle('normal');
            doc.text("Testing Report", data.settings.margin.left, 50);
        };
        var options = {
            beforePageContent: header,
            margin: {top: 80},  startY: doc.autoTableEndPosY() + 20
        };

        doc.autoTable(res.columns, res.data, options);
        doc.save("Students.pdf");
    }
</script>

<script type="text/javascript">
    function generate2() {
        var doc = new jsPDF('p', 'pt');
        var res = doc.autoTableHtmlToJson(document.getElementById("stablePDF"));
        doc.autoTable(res.columns, res.data, {margin: {top: 80}});
        var header = function(data) {
            doc.setFontSize(18);
            doc.setTextColor(40);
            doc.setFontStyle('normal');
            //doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 20, 50, 50);
            doc.text("Statistics Report", data.settings.margin.left, 50);
        };
        var options = {
            beforePageContent: header,
            margin: {top: 80},  startY: doc.autoTableEndPosY() + 20
        };

        doc.autoTable(res.columns, res.data, options);
        doc.save("Statistics.pdf");
    }
</script>
</div>
<!--Onchange event listener Year and Gender-->
<script type="text/javascript">
document.getElementById('T1-Gender1').onchange = function() {Result();};
document.getElementById('T1-Gender2').onchange = function() {Result();};
document.getElementById('T2-Gender1').onchange = function() {Result();};
document.getElementById('T2-Gender2').onchange = function() {Result();};
document.getElementById('T3-Gender1').onchange = function() {Result();};    
document.getElementById('T3-Gender2').onchange = function() {Result();};
document.getElementById('T4-Gender1').onchange = function() {Result();};
document.getElementById('T4-Gender2').onchange = function() {Result();};
function Result() {
        document.getElementById("search").click();
}
</script>    
<!--Terms VIA Year-->
<!--<script type="text/javascript">
document.getElementById('T1-Year').onchange = function() {fetchTerms("T1");};
document.getElementById('T2-Year').onchange = function() {fetchTerms("T2");};
document.getElementById('T3-Year').onchange = function() {fetchTerms("T3");};
document.getElementById('T4-Year').onchange = function() {fetchTerms("T4");};
function fetchTerms(table) {
        var tableYear= table + '-Year';
        for (var T=1; T<3; T++) {
                var year = document.getElementById(tableYear).options[document.getElementById(tableYear).selectedIndex].text;
                var tableTerm = table + '-Term' + T;
                var select = document.getElementById(tableTerm);
                while (select.length > 0)
                        select.remove(0);
                $('#T1-Term1').multiselect('destroy');
                         select.add( new Option(year));
                $(function () {$('#T1-Term1').multiselect({includeSelectAllOption: true});});
        }
}; 
</script>-->

<!--Initialize Terms-->
<script type="text/javascript">
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
        for (T=1; T<5; T++) {
                var select = document.getElementById('T' + T + '-Year');
                while (select.length > 0)
                        select.remove(0);
                        
                delete termsArray[termsArray.length - 1];
                for( var i in termsArray )
                        select.add( new Option( termsArray[i] ) );    
                
                for (c=1; c<3; c++) {
                        var tableName = 'T' + T + '-Term' + c;
                        var select = document.getElementById( tableName );
                        while (select.length > 0)
                                select.remove(0);
                        
                        delete termsArray[termsArray.length - 1];
                         for( var i in termsArray )
                                  select.add( new Option( termsArray[i] ) );    
                }
        }
        $(function () {$('#T1-Year').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T2-Year').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T3-Year').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T4-Year').multiselect({includeSelectAllOption: true});});
        
        $(function () {$('#T1-Term1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T1-Term2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T2-Term1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T2-Term2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T3-Term1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T3-Term2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T4-Term1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T4-Term2').multiselect({includeSelectAllOption: true});});
        
        $(function () {$('#T1-Gender1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T1-Gender2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T2-Gender1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T2-Gender2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T3-Gender1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T3-Gender2').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T4-Gender1').multiselect({includeSelectAllOption: true});});
        $(function () {$('#T4-Gender2').multiselect({includeSelectAllOption: true});});
        
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

<!--Subject VIA Grades-->
<script type="text/javascript">
document.getElementById("grade").onchange = function() {fillSubjects();};
function fillSubjects(){
        var grade = document.getElementById("grade").options[document.getElementById("grade").selectedIndex].text;
        if (grade !== 'Select Grade') {
                var select = document.getElementById('subject');
                while (select.length > 0)
                    select.remove(0);

                var httpSubjects = new XMLHttpRequest();
                httpSubjects.onreadystatechange = function() {
                    if (this.readyState === 4) {
                            var str = this.responseText;
                            subjectsArray = str.split("\?");
                    }
                };
                            httpSubjects.open("GET", "sqldb/distinctSubjects.php?grade=" + grade, false);
                            httpSubjects.send();
                $('#subject').multiselect('destroy');

                delete subjectsArray[subjectsArray.length - 1];
                for( var i in subjectsArray ) {
                         select.add( new Option( subjectsArray[i] ) );
                };   
                $(function () {
                    $('#subject').multiselect({
                             includeSelectAllOption: true
                    }); 
                });
        }
};
</script>

// Charts
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMaterial);
function drawMaterial() {
        var grade = document.getElementById("grade").options[document.getElementById("grade").selectedIndex].text;
        var subject = document.getElementById("subject").options[document.getElementById("subject").selectedIndex].text;

        var value1, value2,value3,value4, result1, result2, result3, result4, tableName, chartName, gender1, gender2;
        for (var i = 1; i < 5; i++) {
                tableName = 'T' + i;
                
                var year = document.getElementById(tableName + '-Year').options[document.getElementById(tableName + '-Year').selectedIndex].text;
                var term1 = document.getElementById(tableName + '-Term1').options[document.getElementById(tableName + '-Term1').selectedIndex].text;
                var term2 = document.getElementById(tableName + '-Term2').options[document.getElementById(tableName + '-Term2').selectedIndex].text;
                var gender1 = document.getElementById(tableName + '-Gender1').options[document.getElementById(tableName + '-Gender1').selectedIndex].text;
                var gender2 = document.getElementById(tableName + '-Gender2').options[document.getElementById(tableName + '-Gender2').selectedIndex].text;

                value1 = document.getElementById(tableName).rows[2].cells[0].childNodes[0].value;
                value2 = document.getElementById(tableName).rows[2].cells[1].childNodes[0].value;
                value3 = document.getElementById(tableName).rows[2].cells[2].childNodes[0].value;
                value4 = document.getElementById(tableName).rows[2].cells[3].childNodes[0].value;        

                result1 = document.getElementById(tableName).rows[3].cells[0].innerHTML;
                result2 = document.getElementById(tableName).rows[3].cells[1].innerHTML;
                result3 = document.getElementById(tableName).rows[3].cells[2].innerHTML;
                result4 = document.getElementById(tableName).rows[3].cells[3].innerHTML;
                
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Number of Students');
                data.addColumn('number', 'Students');
                data.addColumn({type:'string', role:'style'});
                
                data.addRows([
                        [gender1 + "-" + value1.toString() + '% and above', Number(result1), ' #0066cc'],
                        [gender1 + "-" + value2.toString()+ '% and above',Number(result2), '#ff0000'],
                        [gender2 + "-" + value3.toString() + '% and above', Number(result3), ' #0066cc'],
                        [gender2 + "-" + value4.toString()+ '% and above',Number(result4), '#ff0000'],
                ]);
                var options = {
                        title:'(' + term1 + " " + gender1 + ') VS ('  + term2 + " " + gender2 + ") " + grade + "-" + subject,
                };
                chartName = 'chart' + i;
                
                var materialChart = new google.visualization.ColumnChart(document.getElementById(chartName));
                materialChart.draw(data, options);
        }
    };
</script>

</body>
</html>
