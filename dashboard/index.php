<?php include("header.php"); ?>

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_content">

                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Change the avatar">
                          <img src="https://s3-us-west-2.amazonaws.com/piggypennies/images/henry-big.jpg" alt="Avatar">
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal" type="button">&times;</button>
                                  <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                      <input class="avatar-src" name="avatar_src" type="hidden">
                                      <input class="avatar-data" name="avatar_data" type="hidden">
                                      <label for="avatarInput">Local upload</label>
                                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                      <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                      </div>
                                    </div>

                                    <div class="row avatar-btns">
                                      <div class="col-md-9">
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">Rotate Left</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">Rotate Right</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3>Henry Saniuk</h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i> Rochester, New York, USA
                      </li>

                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> Software Engineer
                      </li>

                      <li class="m-top-xs">
                        <i class="fa fa-external-link user-profile-icon"></i>
                        <a href="http://henrysaniuk.com" target="_blank">henrysaniuk.com</a>
                      </li>
                    </ul>

                    <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                    <br />

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="profile_title">
                      <div class="col-md-6">
                        <h2>Savings Report</h2>
                      </div>
                    </div>

                    <div class="profile_title">
                      <div class="col-md-6">
                        <h2>Recent Activity</h2>
                      </div>
                    </div>

                            
                            <?php 
                            $lifetime_savings = 0;
                            $statement = file_get_contents("http://api.reimaginebanking.com/accounts/$henry/purchases?key=$api_key");
                            $statement = json_decode($statement, true);
                            ?>
                            
                           <!-- start user projects -->
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th>Merchant</th>
                                <th>Price</th>
                                <th>Savings</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                for ($i = count($statement)-1; $i >= 0; $i--) {
                                    
                                    $merchant = $statement[$i]['merchant_id'];
                                    $amount = $statement[$i]['amount'];
                                    $rounded = ceil($statement[$i]['amount']);
                                    $round = $rounded-$amount;
                                    $lifetime_savings += $round;
                                    $amount = money_format('$%i', $amount);
                                    $round = money_format('$%i', $round);
                                    
                                    $merchant_info = file_get_contents("http://api.reimaginebanking.com/merchants/$merchant?key=$api_key");
                                    $merchant_info = json_decode($merchant_info, true);
                                    $merchant = $merchant_info['name'];
                                    
                                    echo "<tr>";
                                    echo "<td>$merchant</td>";
                                    echo "<td>$amount</td>";
                                    echo "<td>+$round</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                          </table>
                          <!-- end user projects -->
                      
                      <div class="profile_title">
                      <div class="col-md-6">
                        <h2>Lifetime Total Savings: <strong>+<?php echo money_format('$%i', $lifetime_savings); ?></strong></h2>
                      </div>
                    </div>

                        </div>
                       
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

<?php include("footer.php"); ?>
