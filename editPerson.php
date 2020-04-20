<?php
include 'verifyDbLogin.php';
include 'includes/db_open.php';
session_start();

    $queryStr = "SELECT * FROM " . $_SESSION['directoryTable'] . " WHERE id='" . $_REQUEST['id'] . "'";

    $result = $database->query($queryStr);
    $rows = $result->num_rows;
?>

<html>
    <head>
        <link href="./directory.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          function setOnCampus(onCampus) {
              if (onCampus == 'true') {
                  document.getElementById('onCampusAddress').style.display = "";
                  document.getElementById('offCampusAddress').style.display = "none";
              } else {
                  document.getElementById('onCampusAddress').style.display = "none";
                  document.getElementById('offCampusAddress').style.display = "";
              }
          }

          function fillAddress() {
              var radioVal = '';
              for (i = 0; i < document.editForm.on_campus.length; i++) {
                  if (document.editForm.on_campus[i].checked == true) radioVal = document.editForm.on_campus[i].value;
              }

              if (radioVal == 'true') {
                  document.getElementById('hiddenStreetNum').value = document.getElementById('dorm_room').value;
                  document.getElementById('hiddenStreet').value = document.getElementById('dorm_building').value;
              } else {
                  document.getElementById('hiddenStreetNum').value = document.getElementById('street_number').value;
                  document.getElementById('hiddenStreet').value = document.getElementById('street_name').value;
              }
          }
        </script>
    </head>
    <body>
        <?php if ($rows != 1) echo "<h1>Student Not Found!</h1>";
            else {
              $data = $result->fetch_assoc();
        ?>
        <h2>Edit Student Information</h2>
        <form name="editForm" action="displayPerson.php" method="post">
        <div id="person">
            <div id="first_name"><div class="label">First Name:</div> &nbsp; <input name="first_name" type="text" value="<?php echo $data['first_name'];?>" maxlength="32"/></div>
            <div id="last_name"><div class="label">Last Name:</div> &nbsp; <input name="last_name" type="text" value="<?php echo $data['last_name'];?>" maxlength="32"/></div>
            <div id="class"><div class="label">Class:</div> &nbsp;
                <select name="class">
                    <option value="fr" <?php if ($data['class'] == "fr") echo "selected=\"yes\"";?> >Freshman</option>
                    <option value="so" <?php if ($data['class'] == "so") echo "selected=\"yes\"";?> >Sophomore</option>
                    <option value="jr" <?php if ($data['class'] == "jr") echo "selected=\"yes\"";?> >Junior</option>
                    <option value="sr" <?php if ($data['class'] == "sr") echo "selected=\"yes\"";?> >Senior</option>
                    <option value="gr" <?php if ($data['class'] == "gr") echo "selected=\"yes\"";?> >Grad Student</option>
                </select>
            </div>
            <div id="gender"><div class="label">Gender:</div>&nbsp;
                <select name="gender">
                    <option value="m" <?php if ($data['gender'] == "m") echo "selected=\"yes\"";?> >Male</option>
                    <option value="f" <?php if ($data['gender'] == "f") echo "selected=\"yes\"";?> >Female</option>
                </select>
            </div>
            <div id="family"><div class="label">Family Group:</div> &nbsp;
                <select name="color">
                    <option value="none" <?php if ($data['color'] == "none") echo "selected=\"yes\"";?> >[No Family]</option>
                    <option value="blue" <?php if ($data['color'] == "blue") echo "selected=\"yes\"";?> >Blue</option>
                    <option value="brown" <?php if ($data['color'] == "brown") echo "selected=\"yes\"";?> >Brown</option>
                    <option value="gold" <?php if ($data['color'] == "gold") echo "selected=\"yes\"";?> >Gold</option>
                    <option value="green" <?php if ($data['color'] == "green") echo "selected=\"yes\"";?> >Green</option>
                    <option value="maroon" <?php if ($data['color'] == "maroon") echo "selected=\"yes\"";?> >Maroon</option>
                    <option value="navy" <?php if ($data['color'] == "navy") echo "selected=\"yes\"";?> >Navy</option>
                    <option value="orange" <?php if ($data['color'] == "orange") echo "selected=\"yes\"";?> >Orange</option>
                    <option value="orange" <?php if ($data['color'] == "pink") echo "selected=\"yes\"";?> >Pink</option>
                    <option value="purple" <?php if ($data['color'] == "purple") echo "selected=\"yes\"";?> >Purple</option>
                    <option value="red" <?php if ($data['color'] == "red") echo "selected=\"yes\"";?> >Red</option>
                    <option value="silver" <?php if ($data['color'] == "silver") echo "selected=\"yes\"";?> >Silver</option>
                    <option value="yellow" <?php if ($data['color'] == "yellow") echo "selected=\"yes\"";?> >Yellow</option>
                </select>
            </div>
            <div id="prospect"><div class="label">Prospect?</div>&nbsp;<input name="prospect" type="checkbox" value="true" <?php if ($data['prospect'] == "true") echo "checked";?>/></div>
            <div id="phone"><div class="label">Phone:</div> &nbsp; <input name="phone" type="text" value="<?php echo $data['phone'];?>" maxlength="10"/></div>
            <div id="email"><div class="label">Email:</div> &nbsp; <input name="email" type="text" value="<?php echo $data['email'];?>" maxlength="32"/></div>
            <div id="info_card"><div class="label">Info Card?</div>&nbsp;<input name="info_card" type="checkbox" value="true" <?php if ($data['info_card'] == "true") echo "checked";?>/></div>

            <fieldset>
                <legend>Local Address</legend>
            <div id="on_campus">
                <input type="radio" name="on_campus" value="true" <?php if ($data['on_campus'] == 'true') echo " checked "; ?> onclick="setOnCampus('true');"/>On Campus
                &nbsp;<input type="radio" name="on_campus" value="false" <?php if ($data['on_campus'] == 'false') echo " checked "; ?> onclick="setOnCampus('false');"/>Off Campus
            </div>


            <div id="onCampusAddress" <?php if ($data['on_campus'] == 'false') echo "style='display:none'"; ?> >
                <div id="streetNum_local"><div class="label" id="streetNum_label">Dorm Room Number:</div> &nbsp; <input name="dorm_room" id="dorm_room" type="text" value="<?php if ($data['on_campus'] == 'true') echo $data['streetNum_local'];?>" maxlength="8"/></div>
                <div id="street_local"><div class="label" id="street_label">Dorm:</div> &nbsp;
                        <select name="dorm_building" id="dorm_building">
                            <option value="East AJ" <?php if ($data['street_local'] == 'East AJ') echo "selected=\"yes\""; ?>>East AJ</option>
                            <option value="West AJ" <?php if ($data['street_local'] == 'West AJ') echo "selected=\"yes\""; ?>>West AJ</option>
                            <option value="Barringer" <?php if ($data['street_local'] == 'Barringer') echo "selected=\"yes\""; ?>>Barringer</option>
                            <option value="East Campbell" <?php if ($data['street_local'] == 'East Campbell') echo "selected=\"yes\""; ?>>East Campbell</option>
                            <option value="Main Campbell" <?php if ($data['street_local'] == 'Main Campbell') echo "selected=\"yes\""; ?>>Main Campbell</option>
                            <option value="Cochrane" <?php if ($data['street_local'] == 'Cochrane') echo "selected=\"yes\""; ?>>Cochrane</option>
                            <option value="Donaldson-Brown" <?php if ($data['street_local'] == 'Donaldson-Brown') echo "selected=\"yes\""; ?>>Donaldson-Brown</option>
                            <option value="East Eggleston" <?php if ($data['street_local'] == 'East Eggleston') echo "selected=\"yes\""; ?>>East Eggleston</option>
                            <option value="Main Eggleston" <?php if ($data['street_local'] == 'Main Eggleston') echo "selected=\"yes\""; ?>>Main Eggleston</option>
                            <option value="West Eggleston" <?php if ($data['street_local'] == 'West Eggleston') echo "selected=\"yes\""; ?>>West Eggleston</option>
                            <option value="GLC" <?php if ($data['street_local'] == 'GLC') echo "selected=\"yes\""; ?>>GLC</option>
                            <option value="Harper" <?php if ($data['street_local'] == 'Harper') echo "selected=\"yes\""; ?>>Harper</option>
                            <option value="Hillcrest" <?php if ($data['street_local'] == 'Hillcrest') echo "selected=\"yes\""; ?>>Hillcrest</option>
                            <option value="Holiday Inn" <?php if ($data['street_local'] == 'Holiday Inn') echo "selected=\"yes\""; ?>>Holiday Inn</option>
                            <option value="The Inn at Virginia Tech" <?php if ($data['street_local'] == 'The Inn at Virginia Tech') echo "selected=\"yes\""; ?>>The Inn at Virginia Tech</option>
                            <option value="Johnson" <?php if ($data['street_local'] == 'Johnson') echo "selected=\"yes\""; ?>>Johnson</option>
                            <option value="Lee" <?php if ($data['street_local'] == 'Lee') echo "selected=\"yes\""; ?>>Lee</option>
                            <option value="Miles" <?php if ($data['street_local'] == 'Miles') echo "selected=\"yes\""; ?>>Miles</option>
                            <option value="Newman" <?php if ($data['street_local'] == 'Newman') echo "selected=\"yes\""; ?>>Newman</option>
                            <option value="New Cadet Hall" <?php if ($data['street_local'] == 'New Cadet Hall') echo "selected=\"yes\""; ?>>New Cadet Hall</option>
                            <option value="New Hall West" <?php if ($data['street_local'] == 'New Hall West') echo "selected=\"yes\""; ?>>New Hall West</option>
                            <option value="New Res East" <?php if ($data['street_local'] == 'New Res East') echo "selected=\"yes\""; ?>>New Res East</option>
                            <option value="OShaughnessy" <?php if ($data['street_local'] == 'OShaughnessy') echo "selected=\"yes\""; ?>>O'Shaughnessy</option>
                            <option value="Payne" <?php if ($data['street_local'] == 'Payne') echo "selected=\"yes\""; ?>>Payne</option>
                            <option value="Pearson" <?php if ($data['street_local'] == 'Pearson') echo "selected=\"yes\""; ?>>Pearson</option>
                            <option value="Peddrew-Yates" <?php if ($data['street_local'] == 'Peddrew-Yates') echo "selected=\"yes\""; ?>>Peddrew-Yates</option>
                            <option value="Pritchard" <?php if ($data['street_local'] == 'Pritchard') echo "selected=\"yes\""; ?>>Pritchard</option>
                            <option value="Slusher Tower" <?php if ($data['street_local'] == 'Slusher Tower') echo "selected=\"yes\""; ?>>Slusher Tower</option>
                            <option value="Slusher Wing" <?php if ($data['street_local'] == 'Slusher Wing') echo "selected=\"yes\""; ?>>Slusher Wing</option>
                            <option value="Vawter" <?php if ($data['street_local'] == 'Vawter') echo "selected=\"yes\""; ?>>Vawter</option>
                        </select>
                </div>
            </div>
            <div id="offCampusAddress" <?php if ($data['on_campus'] == 'true') echo "style='display:none'"; ?> >
                <div id="streetNum_local"><div class="label" id="streetNum_label">Street Number:</div> &nbsp; <input name="street_number" id="street_number" type="text" value="<?php if ($data['on_campus'] == 'false') echo $data['streetNum_local'];?>" maxlength="8"/></div>
                <div id="street_local"><div class="label" id="street_label">Street:</div> &nbsp; <input name="street_name" id="street_name" type="text" value="<?php if ($data['on_campus'] == 'false') echo $data['street_local'];?>" maxlength="128"/></div>
            </div>

            </fieldset>

            <fieldset>
                <legend>Home Address</legend>
            <div id="street_perm"><div class="label">Street:</div> &nbsp; <input type="text" name="street_perm" value="<?php echo $data['street_perm'];?>" maxlength="128"/></div>
            <div id="city_perm"><div class="label">City:</div> &nbsp; <input type="text" name="city_perm" value="<?php echo $data['city_perm'];?>" maxlength="32"/></div>
            <div id="state_perm"><div class="label">State:</div> &nbsp; <input type="text" name="state_perm" value="<?php echo $data['state_perm'];?>" maxlength="2"/></div>
            <div id="zip_perm"><div class="label">Zip:</div> &nbsp; <input type="text" name="zip_perm" value="<?php echo $data['zip_perm'];?>" maxlength="5"/></div>
            </fieldset>

            <div id="major"><div class="label">Major:</div> &nbsp; <input type="text" name="major" value="<?php echo $data['major']; ?>" maxlength="32"/></div>
            <div id="church"><div class="label">Church:</div> &nbsp; <input type="text" name="church" value="<?php echo $data['church']; ?>" maxlength="128"/></div>
            <div id="other"><div class="label">Notes:</div> &nbsp; <input type="text" name="other" value="<?php echo $data['other']; ?>" maxlength="255"/></div>
        </div>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
            <input type="hidden" name="updateRecord" value="true"/>
            <input type="hidden" name="streetNum_local" id="hiddenStreetNum"/>
            <input type="hidden" name="street_local" id="hiddenStreet"/>
            <div id="personButtons">
                <input type="submit" value="Update Information" onclick="fillAddress();"/>
                <input type="submit" value="Cancel" onclick="document.forms.editForm.updateRecord.value = 'false'"/>
            </div>
        </form>
        <?php } //end else ?>
        <div class="clearing"></div>
    </body>
</html>
