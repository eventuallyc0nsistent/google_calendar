<html>
    <head>
        <title>
            Calendar Form
        </title>
        
        <style type="text/css">
            .rght_calendar {
                        width: 70% ;
        }
        </style>
        <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script src="js/jquery.qtip-1.0.0-rc3.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" media="all" href="js/datepicker/jsDatePick_ltr.css" />
        <script type="text/javascript" src="js/datepicker/jsDatePick.min.1.3.js"></script>
    </head>
    <body>
        <?php 

                        function getDispTime($cal_time){
                        if($cal_time == 24) $cal_time = 0;
                        
                        if($cal_time*2%2 == 0)
                          $disp_time = $cal_time.":00";
                        else
                          $disp_time = $cal_time-0.5.":30";

                        if($cal_time<10)
                          $disp_time = "0".$disp_time;

                        return $disp_time;
                      }

                      ?>
        <div class="rght_calendar">
            <h3>Add your Event</h3>
            <!-- <form name="calendar_entry" method="post" action="http://energysolforum.com/googlecalendar/index.php"> -->
            <form name="calendar_entry" method="post" action="../googlecalendar/index.php" onsubmit="return validateForm()" >
                <h4>Title:</h4><input type="text" name="cal_title" id="cal_title" class="cal_entry" placeholder="E.g. MIT Energy Conference">
                <h4>Where:</h4><input type="text" name="cal_where" id="cal_where" class="cal_entry" placeholder="E.g. 137 Varick St, 2nd Flr, NYC
">
                <div>
                  <h4>Start Date:</h4><input type="text" value="<?php echo date("Y-m-H") ?>" name="cal_start_date" id="cal_start_date" class="cal_date" readonly>
                  <h4>Start Time:</h4>
                  <select name="cal_start_time" id="cal_start_time" class="cal_time">';

                 <?php 
                  $cal_time = 7;
                  while($cal_time<=24){
                      $disp_time = getDispTime($cal_time);
                    ?>
                    <option value="<?php echo $disp_time ?>"><?php echo $disp_time ?></option>
                  <?php $cal_time = $cal_time+0.5; } ?>
                </select>
                </div>
                <div>
                  <h4>End Date:</h4><input type="text" value="<?php echo date("Y-m-H") ?>" name="cal_end_date" id="cal_end_date" class="cal_date" readonly>
                  <h4>End Time:</h4>
                  <select name="cal_end_time" id="cal_end_time" class="cal_time">';
                <?php 
                  $cal_time = 7;
                  while($cal_time<=24){
                      $disp_time = getDispTime($cal_time);
                    ?>
                    <option value="<?php echo $disp_time ?>"><?php echo $disp_time ?></option>
                  <?php $cal_time = $cal_time+0.5; } ?>
                </select>
                </div>
                <h4>Description: <span class="desc-tip" style="color:#478ca7;cursor: default;">[?]</span> </h4> <textarea type="text" name="cal_desc" id="cal_desc"></textarea>
                <div class="descTip">
                  E.g.<br>The MIT Energy Conference will focus on natural gas demand outlook, as well as regulatory and legislative changes. &lt;p&gt;Speakers include:<br/>&lt;br&gt;Ronald Jibson, Chairman, American Gas Association<br/>&lt;br&gt;Dave McCurdy, President and CEO, American Gas Association<br/>&lt;p&gt;For event details and registration &lt;b&gt;&lt;a href=&quot;http://www.mitenergyconference.com&quot;&gt;click here&lt;/a&gt;&lt;/b&gt;
                </div>
                <div style="text-align: center;">
                  <input type="submit" name="cal_submit" id="cal_submit">
                </div>
            </form>
        </div>
        <script type="text/javascript">
        
            $( document ).ready(function() {
                    var catCounter = 4;
                    
                    $('.descTip').hide();

                    for(var cnt=1;cnt<=catCounter;cnt++){
                        $('.desc-tip').qtip({
                                        content: $('.descTip'), // Give it some content, in this case a simple string
                                        position: { target: 'mouse' },
                                        style : { border: {radius:8}, tip : 'topLeft' }
                                   });
                    }

                    a = new JsDatePick({
                        useMode:2,
                        target:"cal_start_date",
                        dateFormat:"%Y-%m-%d"
                    });
                    b = new JsDatePick({
                        useMode:2,
                        target:"cal_end_date",
                        dateFormat:"%Y-%m-%d"
                    });
                });

            function validateForm(){
                // alert("Hii");
                var x=document.calendar_entry;
                if (x.cal_title.value==null || x.cal_title.value==""){
                  alert("Please enter the Title");
                  x.cal_title.focus();
                  return false;
                }
                if (x.cal_where.value==null || x.cal_where.value==""){
                  alert("Please enter the Location of the Event");
                  x.cal_where.focus();
                  return false;
                }
                if (x.cal_start_date.value==null || x.cal_start_date.value==""){
                  alert("Please enter the Start Date");
                  x.cal_start_date.focus();
                  return false;
                }

                var startD = new Date(x.cal_start_date.value+" "+x.cal_start_time.value);
                var endD = new Date(x.cal_end_date.value+" "+x.cal_end_time.value);

                if (startD > endD) {
                alert("Invalid Date/Time Range!\nStart Time cannot be after End Time!")
                return false;
                }

                if (x.cal_end_date.value==null || x.cal_end_date.value==""){
                  alert("Please enter the End Date");
                  x.cal_end_date.focus();
                  return false;
                }

                if (x.cal_desc.value==null || x.cal_desc.value==""){
                  alert("Please enter the Description");
                  x.cal_desc.focus();
                  return false;
                }
              }
        </script>
    </body>
</html>