 <?php
session_start();

/* if( $_SESSION["loggedIn"] && $_SESSION['logMeOut']) {
    session_destroy(); 
}*/

if (isset($_POST["deleteUser"])) {

    
    $id = $_POST["deleteUser"];

    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    $users = $root->getElementsByTagName('users');
    $nbUsers = $root->getElementsByTagName('user');
    foreach ($nbUsers as $user) {
        if ($user->getAttribute('id') == $id) {
            $users[0]->removeChild($user);
        }
    }
    $dom->save('mirchidatabase.xml') or die('XML Create Error');
}

?>


 <!DOCTYPE html>
 <html lang="en">

 <head>

     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>MG | User List</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="/Back Store/userlist.css">




 </head>

 <body onload="loadDoc()">
     <header>
         <a href="/index.php">
             <img src="/imgs/Mirchi_Logo_oval_B.png" alt="Mirchi">
         </a>

         <nav id="nav-bar">
            <a href="../index.php" class="nav-item">Home</a>

            <a href="../ShoppingCart.php" class="nav-item">Shopping Cart</a>
            <span class="nav-item">
                <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "<a href=\"../Login/login.php\" class=\"nav-item\">Log in</a>";
}

?>
            </span>

<?php
if (isset($_SESSION['username'])) {
    echo "<a href=\"../Login/logout.php\" class=\"nav-item\">Log Out</a>";
}

?>
        </nav>
     </header>


     <section id="aisle-bar">
         <a href="/Back Store/productList.php">Product List</a>
         <a href="/Back Store/userlist.php">User List</a>
         <a href="/Back Store/orderList.php">Order List</a>
     </section>

     <section id="test-sec"></section>


     <section id="user-list">
         <h1>User List</h1>

         <div id="user-count">There are currently entries</div>
         <section id="add-user" class="container">
             <div class="row">
                 <div class="col-sm">
                     <a href="AddUser.php" id="new-user">Add User</a>
                 </div>
             </div>
         </section>
         <table id="user-table" class="table table-striped table-bordered table-hover"></table>
     </section>

     <script>
     var xmlDoc;

     function loadDoc() {

         xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 myFunction(this);
             }
         };
         xhttp.open("GET", "mirchidatabase.xml", true);
         xhttp.send();
     }

     function myFunction(xml) {
         var i;
         xmlDoc = xml.responseXML;
         var table =
             "<table><tr><th>ID</th><th>First name</th><th>Last Name</th><th>Email</th><th>Address</th><th>Phone</th><th>Edit</th><th>Delete</th></tr>";

         var x = xmlDoc.getElementsByTagName("user");
         for (i = 0; i < x.length; i++) {
             let id = x[i].getAttribute('id');
             let firstName = x[i].getElementsByTagName("first_name")[0].childNodes[0].nodeValue;
             let lastName = x[i].getElementsByTagName("last_name")[0].childNodes[0].nodeValue;
             let email = x[i].getElementsByTagName("email")[0].childNodes[0].nodeValue;
             let password = x[i].getElementsByTagName("password")[0].childNodes[0].nodeValue;
             let address = x[i].getElementsByTagName("address")[0].childNodes[0].nodeValue;
             let city = x[i].getElementsByTagName("city")[0].childNodes[0].nodeValue;
             let province = x[i].getElementsByTagName("province")[0].childNodes[0].nodeValue;
             let postalcode = x[i].getElementsByTagName("postalcode")[0].childNodes[0].nodeValue;
             let phone = x[i].getElementsByTagName("phone")[0].childNodes[0].nodeValue;

             table += "<tr><td id=\"user-id\">" +
                 x[i].getAttribute('id') +
                 "</td><td>" +
                 x[i].getElementsByTagName("first_name")[0].childNodes[0].nodeValue +
                 "</td><td>" +
                 x[i].getElementsByTagName("last_name")[0].childNodes[0].nodeValue +
                 "</td><td>" +
                 x[i].getElementsByTagName("email")[0].childNodes[0].nodeValue +
                 "</td><td>" +
                 x[i].getElementsByTagName("address")[0].childNodes[0].nodeValue + ", " +
                 x[i].getElementsByTagName("city")[0].childNodes[0].nodeValue + ", " +
                 x[i].getElementsByTagName("province")[0].childNodes[0].nodeValue + ", " +
                 x[i].getElementsByTagName("postalcode")[0].childNodes[0].nodeValue +
                 "</td><td>" +
                 x[i].getElementsByTagName("phone")[0].childNodes[0].nodeValue +
                 "</td><td>" +
                 "<a href=\"EditUserProfiles.php?first_name=" + firstName + "&last_name=" + lastName + "&email=" +
                 email + "&password=" + password + "&address=" + address + "&city=" + city + "&province=" + province +
                 "&postalcode=" + postalcode + "&phone=" + phone + "&userID=" + id + "\">" +
                 "<button onclick='editUser(" + "\"" + id + "\"" + ", " + "\"" + firstName + "\"" + ", " + "\"" +
                 lastName + "\"" + ", " + "\"" + email + "\"" + ", " + "\"" + password + "\"" + ", " + "\"" + address +
                 "\"" + ", " + "\"" + city + "\", " + "\"" + province + "\", \"" + postalcode + "\", \"" + phone +
                 "\")'>Edit</button></a>" + "</td><td>" +
                 "<form method=\"POST\" action=\"\">" +
                 "<input name=\"deleteUser\" type=\"submit\" value=\"Delete\" id=\"" + id + "\" onclick=\"delUser(" +
                 id + ")\" ></form>" +
                 "</td></tr>";
         }

         table += "</table>";
         document.getElementById("user-table").innerHTML = table;
         var userCount = "There are currently " + x.length + " entries";
         document.getElementById("user-count").innerHTML = userCount;
     }

     function delUser(userID) {
         if (userID == 1 || userID == 2) {
             alert("This user cannot be deleted dummy!")
         } else {
             var x = document.getElementById(userID);
             if (x.hasAttribute("value"))
                 x.setAttribute("value", userID);
         }

     }

     //delete user logic 
     function editUser(userID, firstName, lastName, email, password, address, city, province, postal, phone) {
         alert(userID);
         xmlhttp = new XMLHttpRequest();
         xmlhttp.open("POST", "EditUserSession.php?first_name=" + firstName + "&last_name=" + lastName + "&email=" +
             email + "&password=" + password + "&address=" + address + "&city=" + city + "&province=" + province +
             "&postal=" + postal + "&phone=" + phone, true);
         xmlhttp.send();
     }
     </script>


     </script>


     <footer>
        <ul>
            <li><a href="/Back Store/productlist.php">Product List</a></li>

            <li><a href="/Back Store/userlist.php">User List</a></li>

            <li><a href="/Back Store/orderList.php">Order List</a></li>
        
        </ul>

        <p class="copyright">Copyright 2021 MirchiGrocery</p>
    </footer>
 </body>