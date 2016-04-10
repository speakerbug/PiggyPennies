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

                                <div id="button">
                                    <button class="btn btn-primary" onclick="sendTransaction()">Demo Transaction</button>
                                </div>

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

        function sendTransaction() {
            $.get("http://piggy.aws-cloud.oweb.co/hooks/transaction.php", function (data, status) {
                alert("Transaction made");
                });
            
            $.get("http://piggy.aws-cloud.oweb.co/hooks/transaction.php", function (data, status) {
                alert("Transaction made");
                });
        }
    </script>

    <?php include("footer.php"); ?>