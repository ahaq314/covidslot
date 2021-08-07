<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Covid Centers & Slots</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" crossorigin="anonymous">
          <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}">
 
  <script src="{{ URL::asset('js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
  <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
     
    </head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-sm-12">
              <div class="text-center">
                     <h2 class="text-center">Find Nearby Covid Centres</h2>
          <form autocomplete="off">
            <input type="text" required placeholder="Enter PIN..."  id="pin" name="pin" />

            <input type="text"  required placeholder="Select Date..." id="datepicker">
            
            <button class="btn btn-primary btn-sm" id="btn-find">Find</button>
            &nbsp;&nbsp;<span id="count" class="text-success"></span>
        </form>
              </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                             <tr>
                               
                                <th>Name</th>
                                <th>Address</th>
                                <th>Timing</th>
                                <th>Vaccine Type</th>
                                <th>Available<br />Capacity</th>
                                <th>Fee Type</th>
                                <th>Fee</th>
                                <th>Slots</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
               </div>
             

    

            </div>
        </div>
      </div>
    </body>

    <script>
      $(function(){
            $("#btn-find").click(function(e){
                e.preventDefault();
               
               $("#count").html("");


                var pincode = $("#pin").val().trim();
                var date = $("#datepicker").val();

                if (pincode == "" || isNaN(pincode)) {

                    $("#pin").css("border-color","red");
                    alert("Enter PIN...");
                    return false;

                } else {

                    $("#pin").css("border-color","");
                }

                if (date == "") {

                    $("#datepicker").css("border-color","red");
                    alert("Select date...");
                    return false;

                } else {

                    $("#datepicker").css("border-color","");
                }


                $("#btn-find").prop("disabled",true).text("Wait...");
                
                

                $.ajax({

                      url:"https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/findByPin",
                      data:{pincode:pincode, date:date},
                      dataType:"json",
                      beforeSend:function(){
                        $("#btn-find").prop("disabled",true).text("Wait...");
                      },
                      complete: function(){
                        $("#btn-find").prop("disabled",false).text("Find");
                      }

                }).done(function(response){
                     

                   
                       console.log(response.sessions.length);

                    var data = response.sessions;

                    var len = response.sessions.length;

                     var html = "";

                    if (len > 0){

                        for (var i =0; i < len ; i++){

                            html += '<tr>';
                            html += '<td>'+data[i].name+'</td>';
                            html += '<td>'+data[i].address+'</td>';
                            html += '<td>'+data[i].from+' - '+data[i].to+'</td>';
                            html += '<td>'+data[i].vaccine+'</td>';
                            html += '<td>'+data[i].available_capacity+'</td>';
                            html += '<td>'+data[i].fee_type+'</td>';
                            html += '<td>'+data[i].fee+'</td>';
                            html += '<td>'+data[i].slots.join(', ')+'</td>';
                            html += '</tr>'
                        }

                    } else {
                        html +='<tr><td colspan="7"><span class="text-danger">No center found</span></td></tr>';
                    }

                    $("#count").html('('+len+') centers found');
                    $("tbody").html(html);


                }).fail(function( jqXHR,  textStatus, errorThrown){
                  
                    alert(jqXHR.responseJSON.error);
                });


            });
      });
    </script>
    
    <script>
    $(function(){
         $( "#datepicker" ).datepicker({
        dateFormat: "dd-mm-yy"
     });
     });
    </script>
</html>
