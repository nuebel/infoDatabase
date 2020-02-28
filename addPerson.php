<?php include 'verifyDbLogin.php'; ?>
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
        <h2>Add Student</h2>
        <form name="editForm" action="displayPerson.php" method="post">
        <div id="person">
            <div id="first_name"><div class="label">First Name:</div> &nbsp; <input name="first_name" type="text" maxlength="32"/></div>
            <div id="last_name"><div class="label">Last Name:</div> &nbsp; <input name="last_name" type="text" maxlength="32"/></div>
            <div id="class"><div class="label">Class:</div> &nbsp;
                <select name="class">
                    <option value="fr">Freshman</option>
                    <option value="so">Sophomore</option>
                    <option value="jr">Junior</option>
                    <option value="sr">Senior</option>
                    <option value="gr">Grad Student</option>
                </select>
            </div>
            <div id="gender"><div class="label">Gender:</div>&nbsp;
                <select name="gender">
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
            </div>
            <div id="family"><div class="label">Family Group:</div> &nbsp;
                <select name="color">
                    <option value="none">[No Family]</option>
                    <option value="blue">Blue</option>
                    <option value="brown">Brown</option>
                    <option value="gold">Gold</option>
                    <option value="green">Green</option>
                    <option value="maroon">Maroon</option>
                    <option value="navy">Navy</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Purple</option>
                    <option value="red">Red</option>
                    <option value="silver">Silver</option>
                    <option value="yellow">Yellow</option>
                </select>
            </div>
            <div id="prospect"><div class="label">Prospect?</div>&nbsp;<input name="prospect" type="checkbox" value="true"/></div>
            <div id="phone"><div class="label">Phone:</div> &nbsp; <input name="phone" type="text" maxlength="10"/></div>
            <div id="email"><div class="label">Email:</div> &nbsp; <input name="email" type="text" maxlength="32"/></div>
            <div id="info_card"><div class="label">Info Card?</div>&nbsp;<input name="info_card" type="checkbox" value="true"/></div>

            <fieldset>
                <legend>Local Address</legend>
                <div id="on_campus">
                    <input type="radio" name="on_campus" value="true" onclick="setOnCampus('true');"checked/>On Campus
                    &nbsp;<input type="radio" name="on_campus" value="false" onclick="setOnCampus('false');"/>Off Campus
                </div>
                <div id="onCampusAddress">
                    <div id="streetNum_local"><div class="label" id="streetNum_label">Dorm Room Number:</div> &nbsp; <input name="dorm_room" id="dorm_room" type="text" maxlength="8"/></div>
                    <div id="street_local">
                        <div class="label" id="street_label">Dorm:</div> &nbsp;
                        <select name="dorm_building" id="dorm_building">
                            <option value="East AJ">East AJ</option>
                            <option value="West AJ">West AJ</option>
                            <option value="Barringer">Barringer</option>
                            <option value="East Campbell">East Campbell</option>
                            <option value="Main Campbell">Main Campbell</option>
                            <option value="Cochrane">Cochrane</option>
                            <option value="Donaldson-Brown">Donaldson-Brown</option>
                            <option value="East Eggleston">East Eggleston</option>
                            <option value="Main Eggleston">Main Eggleston</option>
                            <option value="West Eggleston">West Eggleston</option>
                            <option value="GLC">GLC</option>
                            <option value="Harper">Harper</option>
                            <option value="Hillcrest">Hillcrest</option>
                            <option value="Holiday Inn">Holiday Inn</option>
                            <option value="The Inn at Virginia Tech">The Inn at Virginia Tech</option>
                            <option value="Johnson">Johnson</option>
                            <option value="Lee">Lee</option>
                            <option value="Miles">Miles</option>
                            <option value="Newman">Newman</option>
                            <option value="New Cadet Hall">New Cadet Hall</option>
                            <option value="New Hall West">New Hall West</option>
                            <option value="New Res East">New Res East</option>
                            <option value="OShaughnessy">O'Shaughnessy</option>
                            <option value="Payne">Payne</option>
                            <option value="Pearson">Pearson</option>
                            <option value="Peddrew-Yates">Peddrew-Yates</option>
                            <option value="Pritchard">Pritchard</option>
                            <option value="Slusher Tower">Slusher Tower</option>
                            <option value="Slusher Wing">Slusher Wing</option>
                            <option value="Vawter">Vawter</option>
                        </select>
                    </div>
                </div>
                <div id="offCampusAddress" style="display:none">
                    <div id="streetNum_local"><div class="label" id="streetNum_label">Street Number:</div> &nbsp; <input name="street_number" id="street_number" type="text" maxlength="8"/></div>
                    <div id="street_local"><div class="label" id="street_label">Street:</div> &nbsp; <input name="street_name" id="street_name" type="text" maxlength="128"/></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Home Address</legend>
                <div id="street_perm"><div class="label">Street:</div> &nbsp; <input type="text" name="street_perm" maxlength="128"/></div>
                <div id="city_perm"><div class="label">City:</div> &nbsp; <input type="text" name="city_perm" maxlength="32"/></div>
                <div id="state_perm"><div class="label">State:</div> &nbsp; <input type="text" name="state_perm" maxlength="2"/></div>
                <div id="zip_perm"><div class="label">Zip:</div> &nbsp; <input type="text" name="zip_perm" maxlength="5"/></div>
            </fieldset>

            <div id="major"><div class="label">Major:</div> &nbsp; <input type="text" name="major" maxlength="32"/></div>
            <div id="church"><div class="label">Church:</div> &nbsp; <input type="text" name="church" maxlength="128"/></div>
            <div id="other"><div class="label">Notes:</div> &nbsp; <input type="text" name="other" maxlength="255"/></div>
        </div>
            <input type="hidden" name="newRecord" value="true"/>
            <input type="hidden" name="streetNum_local" id="hiddenStreetNum"/>
            <input type="hidden" name="street_local" id="hiddenStreet"/>
            <div id="personButtons">
                <input type="submit" value="Add Student" onclick="fillAddress();"/>
                <button type="button" onclick="document.location.href = 'dbSearch.php';">Cancel</button>
            </div>
        </form>
        <div class="clearing"></div>
    </body>
</html>