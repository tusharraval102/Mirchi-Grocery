<?php
session_start();
$isSuccessful = false;
if (isset($_POST['submit'])) {
    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);

    $root = $dom->documentElement;
    $users = $root->getElementsByTagName('users');

    $isSuccessful = true;
    $nbUsers = $root->getElementsByTagName('user');
    foreach ($nbUsers as $user) {
        if ($_POST['email'] == $user->getElementsByTagName("email")[0]->childNodes[0]->nodeValue) {
            $isSuccessful = false;
        }
    }

    if ($isSuccessful == true) {
        $newUser = $users[0]->appendChild($dom->createElement('user'));

        $nbUsers = $root->getElementsByTagName('user');
        $usersIDLength = ($nbUsers->length) - 1;

        $id = $nbUsers[intval($usersIDLength) - 1]->getAttribute('id');
        $id_num = 1 + intval($id);

        $newUser->setAttribute('id', $id_num);
        $newUser->appendChild($dom->createElement('first_name', $_POST['first_name']));
        $newUser->appendChild($dom->createElement('last_name', $_POST['last_name']));
        $newUser->appendChild($dom->createElement('email', $_POST['email']));
        $newUser->appendChild($dom->createElement('password', $_POST['password']));
        $newUser->appendChild($dom->createElement('cpassword', $_POST['cpassword']));
        $newUser->appendChild($dom->createElement('address', $_POST['address']));
        $newUser->appendChild($dom->createElement('city', $_POST['city']));
        $newUser->appendChild($dom->createElement('postalcode', $_POST['postalcode']));
        $newUser->appendChild($dom->createElement('province', $_POST['province']));
        $newUser->appendChild($dom->createElement('phone', $_POST['phone']));
        $newUser->appendChild($dom->createElement('cart'));

        $dom->save('mirchidatabase.xml') or die('XML Create Error');
        header("refresh: 1; url=/Back Store/userlist.php");
        echo '<div font-family: "Handlee", cursive; style="font-size: 2rem; border-radius: 5px;  color: #79b572; height:15%; width:20%; position:fixed; top:42.5%;left: 40%; background-color:white; text-align: center; padding: 10px auto;padding-top: 30px; z-index: 10"><p id="login-success">Success! Redirecting to login</p>' .
            '<img width="30px" height="30px" src="../imgs/login.gif"></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG Edit User Profile</title>



    <link rel="stylesheet" href="editUserProfile.css">

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
            <h1>Add a User</h1>
    </div>
    <?php
        if ($isSuccessful) {
            echo "<b>Signup successful!</b>";
            
        } else if (isset($_POST['submit'])) {
            echo "<span id=\"email-taken\"> Email is already assigned to a user</span>";
        } 
    ?>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Personal Information</div>
                        <div class="card-body">
                            <form action="" method="post">

                                <div class="rowsss">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-right">*FIRST
                                        NAME</label>
                                    <div class="col-md-6">
                                        <input type="text" id="first_name" class="form-control" name="first_name"
                                            required autofocus>
                                    </div>
                                </div>
                                <div class="rowsss">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">*LAST
                                        NAME</label>
                                    <div class="col-md-6">
                                        <input type="text" id="last_name" class="form-control" name="last_name" required
                                            autofocus>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

       
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Contact information</div>
                            <div class="card-body">
                                <form action="" method="">
                                    <div class="rowsss">
                                        <label for="province"
                                            class="col-md-4 col-form-label text-md-right">PROVINCE</label>
                                        <div class="col-md-6">
                                            <input type="text" id="province" class="form-control" name="province"
                                                placeholder="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="rowsss">
                                        <label for="address"
                                            class="col-md-4 col-form-label text-md-right">*ADDRESS</label>
                                        <div class="col-md-6">
                                            <input type="text" id="address" class="form-control" name="address"
                                                placeholder="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="rowsss">
                                        <label for="city" class="col-md-4 col-form-label text-md-right">*CITY</label>
                                        <div class="col-md-6">
                                            <input type="text" id="city" class="form-control" name="city" placeholder=""
                                                required autofocus>
                                        </div>
                                    </div>
                                    <div class="rowsss">
                                        <label for="postalcode" class="col-md-4 col-form-label text-md-right">*POSTAL
                                            CODE</label>
                                        <div class="col-md-6">
                                            <input type="text" id="postalcode" class="form-control" pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]" name="postalcode"
                                                placeholder="H1H 1H1" required autofocus>
                                        </div>
                                    </div>
                                    <div class="rowsss">
                                        <label for="phone" class="col-md-4 col-form-label text-md-right">PHONE
                                            NUMBER</label>
                                        <div class="col-md-6">
                                            <input type="text" id="phone" class="form-control" name="phone"
                                                placeholder="555-555-5555" required autofocus>
                                        </div>
                                    </div>

                                    <div class="rowsss">
                                        <label for="email_address"
                                            class="col-md-4 col-form-label text-md-right">*EMAIL</label>
                                        <div class="col-md-6">
                                            <input type="text" id="email" class="form-control" name="email" required
                                                autofocus>
                                        </div>
                                    </div>


                                    <div class="rowsss">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">*PASSWORD</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" name="password"
                                                required>
                                        </div>
                                    </div>
                                    <!--
                                        <div class="rowsss">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">*CONFIRM
                                                PASSWORD</label>
                                            <div class="col-md-6">
                                                <input type="password" id="cpassword" class="form-control" name="cpassword"
                                                    required>
                                            </div>
                                        </div>
                                    -->
                                    <br>

                                    <div class="rowsss">
                                        <input name="submit" type="submit" class="btn btn-primary">
                                        <input type="reset" class="btn btn-primary">
                                        <br><br>

                                    </div>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

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
