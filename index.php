<!--
Student Information Database
Created by: Nic Uebel (github.com/nuebel)
-->

<html>
<head>
  <link rel="stylesheet" href="directory.css">


<script type="text/javascript">
    var sortBy = "";
    function search() {
        sortBy = "";
        var searchString = document.getElementById('searchText').value;
        var searchCol = document.getElementById('searchColumn').value;
        var url = "dbSearch.php?" + searchCol + '=' + searchString;
        document.getElementById('dbFrame').src = url;
    }

    function clearSearch() {
        sortBy = "";
        document.getElementById('searchText').value = "";
        document.getElementById('dbFrame').src = "dbSearch.php?";
    }

    function sort(new_sortBy) {
        var url = document.getElementById('dbFrame').contentWindow.location.href;

        if ((url.indexOf("familyRoster.php") == -1) && (url.indexOf("dbSearch.php") == -1)) {
            //If some other page besides search or family roster is up, send to search page
            url = "dbSearch.php?sortBy=" + new_sortBy;
        } else {
            //If the url includes back=true, remove it
            var posBack = url.indexOf("back");
            if (posBack != -1) url = url.slice(0, posBack-1);

            var posSortBy = url.indexOf("sortBy");
            var posQ = url.indexOf('?');

            if (posSortBy != -1) {
                var posEq = url.indexOf('=', posSortBy);
                url = url.slice(0, posEq+1);
                url += new_sortBy;
            } else if (posQ == -1) {
                url += "?sortBy=" + new_sortBy;
            } else {
                url += "&sortBy=" + new_sortBy;
            }
        }
        document.getElementById('dbFrame').src = url;
    }

    function getFamilyRoster() {
        var url = "familyRoster.php?color=";
        url += document.getElementById('rosterColor').value;
        document.getElementById('dbFrame').src = url;
    }

    function generateLabels() {
        var url = "generateLabels.php";
        var topLine = prompt("Enter text for the top line of the label (for example, To the parents of:)", "");
        if ( (topLine!=null) && (topLine != "") ) {
            url += "?topLine=" + topLine;
        }
        document.getElementById('dbFrame').src = url;
    }

    function generateDirectory() {
        var url = "generateDirectory.php";
        var title = prompt("Enter a title for the directory", "");
        if ( (title!=null) && (title != "") ) {
            url += "?title=" + title;
        }
        document.getElementById('dbFrame').src = url;
    }
</script>
</head>

<body>
	<div id="title">
		<h1>Student Database</h1>
	</div>

	<div class="clearing"></div>

	<div id="content" class="page">
		<div id="left">

                    <iframe id="dbFrame" src="dbLogin.php" frameborder="0"></iframe>
                    Sort by:&nbsp;
                    <a href="#" onclick="sort('last_name');">Last Name</a>
                    &nbsp;|&nbsp;<a href="#" onclick="sort('first_name');">First Name</a>
                    &nbsp;|&nbsp;<a href="#" onclick="sort('class');">Class</a>
                    &nbsp;|&nbsp;<a href="#" onclick="sort('color');">Family Group</a>
                    &nbsp;|&nbsp;<a href="#" onclick="sort('address');">Address</a>
                    <br/>
                    <a href="#" onclick="generateDirectory();">Print Directory from Displayed List</a>
                    <br/>
                    <a href="#" onclick="document.getElementById('dbFrame').src='dbLogin.php?logout=true';">Log Out of Database</a>


		</div>

		<div id="right">
                    <div class="rightBlock">
                        <h3>Search the database</h3>
                        <div id="searchFor">For:&nbsp;<input type="text" name="searchText" id="searchText"/></div>
                        <div id="searchIn">In:&nbsp<select name="searchColumn" id="searchColumn">
                            <option value="last_name">Last Name</option>
                            <option value="first_name">First Name</option>
                            <option value="email">Email</option>
                            <option value="color">Family Group</option>
                            <option value="class">Class</option>
                            <option value="dorm">Dorm</option>
                            <option value="homeAdd">Home Address</option>
                            <option value="major">Major</option>
                            <option value="church">Church</option>
                            <option value="other">Notes</option>
                        </select></div>
                        <button type="submit" id="searchButton" onclick="search();">Search</button>
                        <button type="button" id="clearSearchButton" onclick="clearSearch();">Clear Results</button>
                    </div>
                    <div class="rightBlock">
                        <h3>Add a student</h3>
                        <button type="button" onclick="document.getElementById('dbFrame').src = 'addPerson.php';">Add Student</button>
                    </div>
                    <div class="rightBlock">
                        <h3>Family Rosters</h3>
                        <select name="rosterColor" id="rosterColor">
                            <option value="none">[No Family]</option>
                            <option value="blue">Blue</option>
                            <option value="brown">Brown</option>
                            <option value="gold">Gold</option>
                            <option value="green">Green</option>
                            <option value="maroon">Maroon</option>
                            <option value="navy">Navy</option>
                            <option value="orange">Orange</option>
				<option value="pink">Pink</option>
                            <option value="purple">Purple</option>
                            <option value="red">Red</option>
                            <option value="silver">Silver</option>
                            <option value="yellow">Yellow</option>
                        </select>
                        <button type="button" onclick="getFamilyRoster();">Get Roster</button>
                    </div>
                    <div class="rightBlock">
                        <h3>Mailing Labels</h3>
                        <button type="button" id="generateLabels" onclick="generateLabels();">Generate Labels</button>
                    </div>
                    <div class="rightBlock">
                        <h3>Links</h3>
                        <a href="#" onclick="document.getElementById('dbFrame').src='dbSearch.php';">Home</a><br/>
                        <a href="#" onclick="document.getElementById('dbFrame').src='studentStats.php';">Statistics</a><br/>
                        <a href="#" onclick="document.getElementById('dbFrame').src='bsAttendance.php';">Bible Studies</a><br/>
                        <a href="#" onclick="document.getElementById('dbFrame').src='operationFriendship.php';">Operation Friendship</a><br/>
                        <a href="#" onclick="document.getElementById('dbFrame').src='generateListserv.php';">Listserv Update</a><br/>
                        <a href="#" onclick="document.getElementById('dbFrame').src='changeDatabase.php';">Change Database</a>
                    </div>
		</div>

		<div class="clearing"></div>

	</div>
	<script type="text/javascript">
	document.querySelector("#searchText").addEventListener("keyup", function(event) {
	    if(event.key !== "Enter") return;
	    document.querySelector("#searchButton").click();
	    event.preventDefault();
	});
	document.querySelector("#searchColumn").addEventListener("keyup", function(event) {
		    if(event.key !== "Enter") return;
		    document.querySelector("#searchButton").click();
		    event.preventDefault();
	});
	</script>
</body>
</html>
