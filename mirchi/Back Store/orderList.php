<?php
session_start();

if(isset($_POST['delete'])) {
    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    $orders = $root->getElementsByTagName('order');
    foreach($orders as $order) {
        if($order->getAttribute('id') == $_POST['orderID']) {
            $order->parentNode->removeChild($order);
            break;
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
    <title>MG | Order List</title>

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

    <!--user list begin-->

    <section id="user-list">
        <h1>Order List</h1>

        <div id="order-count"></div>


        <table id="user-table" class="table table-striped table-bordered table-hover">
           
        </table>
    </section>

    <script>
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
            "<thead><tr><th scope=\"col\">Order Number</th><th scope=\"col\">User Email</th><th scope=\"col\">Total Cost</th><th scope=\"col\">Edit Order</th><th scope=\"col\">Delete Order</th></tr></thead>";

        var x = xmlDoc.getElementsByTagName("order");
        for (i = 0; i < x.length; i++) {
            //alert(i + " times");
            let id = x[i].getAttribute('id');
            let orderProductEmail = x[i].getElementsByTagName("orderProductEmail")[0].childNodes[0].nodeValue;
            let orderProductQuantity = x[i].getElementsByTagName('orderProductQuantity');
            let orderProductPrice = x[i].getElementsByTagName('orderProductPrice');
            let totalCost = 0;
          
            for(var z = 0; z < orderProductQuantity.length; z++) {
                //alert("pq " + z + " : "+ orderProductQuantity.length);
                //alert(orderProductQuantity[z].childNodes[0].nodeValue);
                totalCost += (parseFloat(orderProductQuantity[z].childNodes[0].nodeValue) * parseFloat(orderProductPrice[z].childNodes[0].nodeValue));
            }

            table += "<tr><td id=\"user-id\">" +
                x[i].getAttribute('id') +
                "</td><td>" +
                orderProductEmail +
                "</td><td>$" +
                (totalCost * 1.14975).toFixed(2) +
                "</td><td>" +
                "<form action=\"OrderProfile.php\" method=\"post\">" +
                "<input type=\"hidden\" name=\"orderID\" value=\"" + id +"\">" +
                "<input type=\"submit\" name=\"edit\" value=\"Edit\">"+
                "</form>" +
                "</td><td>" +
                "<form action=\"\" method=\"post\">" +
                "<input type=\"hidden\" name=\"orderID\" value=\"" + id +"\">" +
                "<input type=\"submit\" name=\"delete\" value=\"Delete\">"+
                "</form>" +
                "</td></tr>";
        }
        document.getElementById("user-table").innerHTML = table;
        var orderCount = "There are currently " + x.length + " orders";
        document.getElementById("order-count").innerHTML = orderCount;
    }
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


</html>