<?php include('Header.php'); ?>
<title>Statistics based on subject</title>
</head>

<script>


function printDiv(printCharts){
    
 

      var newWin=window.open('','Print-Window');
        newWin.document.open();
          newWin.document.write('<html><body onload="window.print()">'+printCharts.innerHTML+' </body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);

}
</script>
<script>
    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

    $('#exportS').click(function () {
        doc.fromHTML($('#body').html(), 15, 15, {
            'width': 170,
                'elementHandlers': specialElementHandlers
        });
        doc.save('sample-file.pdf');
    });

    // This code is collected but useful, click below to jsfiddle link.
</script>

<script>
    
    
function printAllCharts(chart1,chart2,chart3,chart4){ 
       
     


      var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body'+chart1.innerHTML+chart2.innerHTML+chart3.innerHTML+chart4.innerHTML+' </body></html>');
        newWin.window.print();
        newWin.document.close();
  setTimeout(function(){newWin.close();},10);
  
 

}
</script>

<script type="text/javascript">
    

$(function () { 
        
          $('#studentcategory').multiselect({ includeSelectAllOption: true });

        $('#search, #charttype').click(function () {
                
        var grade = document.getElementById("grade").options[document.getElementById("grade").selectedIndex].text;
        var subject = document.getElementById("subject").options[document.getElementById("subject").selectedIndex].text;
//      var category = document.getElementById("studentcategory").options[document.getElementById("studentcategory").selectedIndex].text;
        var selected_category = $("#studentcategory option:selected");
        
            //Category               
        var message = "";     var categoryHeader = "";
        selected_category.each(function () {
            var currentCategory = $(this).text();
            if (currentCategory.indexOf("(") !== -1) {
                var bracketIndex = currentCategory.indexOf("(");
                currentCategory = currentCategory.slice(0,bracketIndex);
            }
            if (message ===""){
                if (selected_category !== "") 
                    message = " AND (student_categories.name = '" + currentCategory + "' ";
                else 
                    message = " (student_categories.name = '" + currentCategory + "'";
                categoryHeader = " - " + currentCategory;
            } else {
                message += " OR student_categories.name = '" + currentCategory + "'";  //  grade like 'GR1' OR grade like 'GR10';
                categoryHeader += " , " + currentCategory;
            }
        });
        if (message !== "")
            selected_category = message + ")";
        else
            selected_category = "";

        
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
                                        "&grade=" + grade  + "&subject=" + subject +"&category=" + selected_category +
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
                chartprint = 'chart' + i;
                
                
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
                        title:'(' + term1 + " " + gender1 + ') VS ('  + term2 + " " + gender2 + ") " + grade + '-' + subject  ,
                };
                chartName = 'chart' + i;
                
                var e = document.getElementById("charttype");
                var type = e.options[e.selectedIndex].value;
                if(type === "coloumn"){
                        var materialChart = new google.visualization.ColumnChart(document.getElementById(chartName));
                         materialChart.draw(data, options);}            
                 if(type === "pie"){
                        var materialChart = new google.visualization.PieChart(document.getElementById(chartName));
                         materialChart.draw(data, options);}
                if(type === "histogram"){
                         var materialChart = new google.visualization.Histogram(document.getElementById(chartName));
                         materialChart.draw(data, options);}
                if(type === "linechart"){
                         var materialChart = new google.visualization.LineChart(document.getElementById(chartName));
                         materialChart.draw(data, options); }

               
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
        <?php include('navbar.php'); ?>
<!-- End of Navigation bar -->
<div id="upperdiv" class="w3-container" style="padding-top: 10px; padding-bottom: 10px;">   

        <table id= "table1">
        <tr><td></td>
            <td></td>
            <td>Grade</td>
            <td>Subject</td>
            <td>Student Category</td>
            
            <td></td><td></td>
        </tr>
        <tr><td><button style="text-align: center ;" class="w3-button w3-round-xlarge w3-medium w3-hover-blue-gray w3-center w3-custom" id="exportS" onclick="downloadStatistics()" title="Export Statistics as PDF" >Export Charts  <span class="material-icons">print</span></button>
            </td>
            <td></td>
            <td><select id="grade"></select></td>
            <td><select id="subject"> </select></td>
            <td><select id="studentcategory" multiple="multiple"> </select></td>
           
            <td><button style="text-align: center ;" class="w3-button w3-hover-blue-gray w3-custom w3-medium w3-round-xlarge" id="search" title="Get students marks">Search Results  <span class="fa fa-search"></span></button></td>
            <td></td>
             <td><select  class="w3-button w3-hover-blue-gray w3-custom w3-medium w3-round-xlarge" style="text-align: center" id="charttype" > 
                    <option class="w3-round-xlarge"style="text-align: center" selected="selected" value="pie">Pie Chart</option> 
                     <option class="w3-round-xlarge"style="text-align: center"  value="coloumn">Coloumn Chart</option>
                     <option class="w3-round-xlarge"style="text-align: center"  value="linechart">Line Chart</option> 
                     <option class="w3-round-xlarge"style="text-align: center"  value="histogram">Histogram</option> 

                     
            </select></td>
            <td><button  style="text-align: center ;" class="w3-button w3-hover-blue-gray w3-custom w3-medium w3-round-xlarge" id="exportM" onclick="downloadStudents()" title="Export Marks as PDF">Export Mark  <span class="material-icons ">save_alt</span></button></td>
        </tr>
        </table>
</div>

<div id="tables" style="height: 100vh; overflow: auto">
<!--Tables-->
<!--////////////////////////            Table 1     ///////////////////////////////////////////////////-->
<textarea id="output" rows="10" cols="50" hidden></textarea>
<div class="w3-row w3-border">
    <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T1">  
            <th colspan="4" class="w3-teal" style="font-size: 18px"><button style="float: left;"type='button'class="w3-button w3-hover-blue-gray" onclick="printDiv(chart1)"id='printbtn'  title="Print chart"value='Print'><i class="glyphicon glyphicon-print"></i></button>Benchmark Data

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
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 80> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 85> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 90> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 95> % and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                </tr>
        </table>
                <br>
               
                <div class="w3-half w3-card-4" id="chart1"></div>
        </div>
    
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-centered w3-card-4" id="T2">  
                <th colspan="4" class="w3-teal" style="font-size: 18px"><button style="float: right;"type='button'class="w3-button w3-hover-blue-gray" onclick="printDiv(chart2)"id='printbtn'  title="Print chart"value='Print'><i class="glyphicon glyphicon-print"></i></button>Benchmark Data</th>
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
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 80> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 85> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 90> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;"value= 95> % and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
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
        <th colspan="4" class="w3-teal" style="font-size: 18px"><button style="float: left;"type='button'class="w3-button w3-hover-blue-gray" onclick="printDiv(chart3)"id='printbtn'  title="Print chart"value='Print'><i class="glyphicon glyphicon-print"></i></button>Benchmark Data</th>
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
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 80> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 85> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 90> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 95> % and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                </tr>
        </table>
        <br>
        <div class="w3-half w3-card-4" id="chart3"></div>
        </div>
    
        <div class="w3-container w3-half">
        <table class=" w3-table-all w3-striped w3-bordered w3-centered w3-card-4" id="T4">  
                <th colspan="4" class="w3-teal" style="font-size: 18px;" ><button style="float: right;"type='button'class="w3-button w3-hover-blue-gray" onclick="printDiv(chart4)"id='printbtn'  title="Print chart"value='Print'><i class="glyphicon glyphicon-print"></i></button>Benchmark Data</th>
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
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 80> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 85> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 90> % and above</td>
                        <td class="w3-border-right"><input type="text" style = "font-style:initial ; font-size: 16px;" value= 95> % and above</td>
                </tr>
                <tr>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
                        <td class="w3-border-right">--</td>
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
//                var select = document.getElementById('T' + T + '-Year');
//                while (select.length > 0)
//                        select.remove(0);
                        
                delete termsArray[termsArray.length - 1];
//                for( var i in termsArray )
//                        select.add( new Option( termsArray[i] ) );    
                
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

<!--Initialize Student Category drop down-->     
<script type="text/javascript">
        var categoryArray = ["Your Data Base is Empty!."];
         
        var httpcategory = new XMLHttpRequest();
        httpcategory.onreadystatechange = function() {
                if (this.readyState === 4) {
                        var str = this.responseText;
                        categoryArray = str.split("\n");   
                  }
         };
         httpcategory.open("GET", "sqldb/distinctStudentCategory.php", false);
         httpcategory.send();

        var select = document.getElementById( 'studentcategory' );
        delete categoryArray[categoryArray.length -1];
        for( var i in categoryArray ) {
            select.add( new Option( categoryArray[i] ) );
        };   
        $(function () {
            $('#studentcategory').multiselect({
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


<!----------Save PDF for table----------------->
<script src="js/jspdf.min.js"></script>
<script src="js/jspdf.plugin.autotable.src.js"></script>
<script>
       function downloadStatistics() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#T1')[0];

    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF 
        //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
    }, margins);
}
</script>

</body>
</html>
