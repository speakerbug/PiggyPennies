<?php include("header.php"); ?>

    <!-- page content -->
    <div class="right_col" role="main">

        <div class="">

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <div class="col-md-12">
                                
                                <div id="button"><button class="btn btn-primary" onclick="getLocation()">Find a local ATM</button></div>

                                <p id="demo"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <!-- /page content -->
    </div>


    <script>
        var x = document.getElementById("demo");
        var y = document.getElementById("button");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            // Remove button
            y.innerHTML = "";
        }

        function showPosition(position) {
            x.innerHTML = "<i class='fa fa-refresh fa-spin'></i>";
            $.get("http://api.reimaginebanking.com/atms?lat=" + position.coords.latitude + "&lng=" + position.coords.longitude + "&rad=25&key=c50e2ab66da1e818d92a5884067a17ef", function(data, status){
        alert("Data: " + data + "\nStatus: " + status);
                 x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
            });
        }
    </script>

    <?php include("footer.php"); ?>