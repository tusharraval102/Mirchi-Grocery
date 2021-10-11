<?php

session_start();

if(isset($_REQUEST['userID'])) {
    $_SESSION['userID'] = $_REQUEST['userID'];
}

if (isset($_POST['submit'])) {
    echo'WE MADE IT!!';
    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    
    $root = $dom->documentElement;
    $users = $root->getElementsByTagName('user');
    foreach($users as $user) {
        if($user->getAttribute('id') == $_SESSION['userID']) {
            $user->childNodes[0]->childNodes[0]->nodeValue = $_POST['first_name'];
            $user->childNodes[1]->childNodes[0]->nodeValue = $_POST['last_name'];
            $user->childNodes[2]->childNodes[0]->nodeValue = $_POST['email'];
            $user->childNodes[3]->childNodes[0]->nodeValue = $_POST['password'];
            $user->childNodes[4]->childNodes[0]->nodeValue = $_POST['password'];
            $user->childNodes[5]->childNodes[0]->nodeValue = $_POST['address'];
            $user->childNodes[6]->childNodes[0]->nodeValue = $_POST['city'];
            $user->childNodes[7]->childNodes[0]->nodeValue = $_POST['postalcode'];
            $user->childNodes[8]->childNodes[0]->nodeValue = $_POST['province'];
            $user->childNodes[9]->childNodes[0]->nodeValue = $_POST['phone'];
            echo 'USER HAS BEEN MODIFIED';
            break;
        }
    }
    $setSuccessful = true;
    $dom->save('mirchidatabase.xml') or die('XML Create Error');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG | Edit User Profile</title>



    <link rel="stylesheet" href="/Back Store/editUserProfile.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
</head>

<body>
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


        <div class="user_info">
            <h1>User Profile Settings</h1>
            <?php
                if(isset($setSuccessful)) {
                    echo '<h1 style="color:green; padding-top: 0px;">User has been modified</h1>';
                }
            ?>
            <form action="EditUserProfiles.php" method = "post" class="user_data">

                <div class="user_attribute">
                    <label for="first_name" class="labels">Edit First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $_REQUEST['first_name']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="last_name" class="labels">Edit Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $_REQUEST['last_name']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="email" class="labels">Edit Email:</label><br>
                    <input type="email" id="email" name="email" value="<?php echo $_REQUEST['email']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="password" class="labels">Edit Password:</label><br>
                    <input type="password" id="password" name="password" value="<?php echo $_REQUEST['password']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="address" class="labels">Edit Address:</label><br>
                    <input type="text" id="address" name="address" value="<?php echo $_REQUEST['address']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="city" class="labels">Edit City:</label><br>
                    <input type="text" id="city" name="city" value="<?php echo $_REQUEST['city']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="postalcode" class="labels">Edit Postal Code:</label><br>
                    <input type="text" id="postalcode" name="postalcode" value="<?php echo $_REQUEST['postalcode']; ?>" class="inputs" required><br> 
                </div>
                <!--pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]"--><!--Canadian Potal Codde Pattern obtained from https://www.html5pattern.com/Postal_Codes-->

                <div class="user_attribute">
                    <label for="province" class="labels">Edit Province:</label><br>
                    <input type="text" id="province" name="province" value="<?php echo $_REQUEST['province']; ?>" class="inputs" required><br>
                </div>

                <div class="user_attribute">
                    <label for="phone">Edit Phone Number:</label><br>
                    <input type="tel" id="phone" name="phone" value="<?php echo $_REQUEST['phone']; ?>" required> 
                </div>
                <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"--> <!--info on pattern attribute gathered from https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/tel-->

                <input type="reset" value="Reset User Profile" class="user_buttons">
                <input type="submit" name="submit" value="Save Changes" class="user_buttons">
              </form>
        </div>


        <footer>
        <ul>
            <li><a href="/Back Store/productlist.php">Product List</a></li>

            <li><a href="/Back Store/userlist.php">User List</a></li>

            <li><a href="/Back Store/orderList.php">Order List</a></li>
        
        </ul>

        <p class="copyright">Copyright 2021 MirchiGrocery</p>
    </footer>

    </body>

</html>c