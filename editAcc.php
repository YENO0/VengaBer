<?php
if (!isset($_COOKIE["UserID"])) {
            echo "<script>alert('PLEASE LOGIN TO SEE YOUR PROFILE!!!')</script>";
            echo "<script>window.location.href='./login-customer.php';</script>";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PROFILE DETAILS</title>
        <link rel="stylesheet" href="css/editCust.css"type="text/css"/>
        <?php
        global $gender;
        global $hideform;
        global $username;
        
        ?>
    </head>
    <body style="background-image: url('image./background_3.jpg'); 
          background-repeat: no-repeat; background-size: cover; 
          background-position: center;">
        <?php
        include './header1.php';
        require_once './config/php.php';

//array map between table field name & table display name
$header = array(
'UserID' => 'Username',
 'Email' => 'Email Address',
    'Fname' => 'First Name',
    'Lname' => 'Last Name',
    'Contact' => 'Contact Number',
    'Gender' => 'Gender'
);
?>
        <?php
        if (isset($_COOKIE['UserID'])) {
            $username = $_COOKIE['UserID'];
        } else {           
            echo "<center><div class='msg'>You haven't Log In![<a href='login-customer.php'>LOG IN</a>]</div></center>";
        }
        ?>
<?php
//perform "GET" function to retrieve id from url and then retrieve record from DB.dislay in the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //perform GET method
            //retrieve Studen ID from URL
            $username = isset($_GET['username']) ? strtoupper(trim($_GET['username'])) : $username;

    // Connect to the database
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Retrieve record from the database
    $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";
    $result = $con->query($sql);
    if ($record = $result->fetch_object()) {
                //record found
                $username = $record->UserID;
                $email = $record->Email;
                $password = $record->Password;
                $fname = $record->Fname;
                $lname = $record->Lname;
                $contact = $record->Contact;
                $street = $record->Street;
                $town = $record->Town;
                $postcode = $record->Postcode;
                $state = $record->State;
                $gender = $record->Gender;
            } else {
                echo "<center><div class='msg'>No record found![<a href='homepage.php'>Back to home</a>]</div></center>";
               
            }
            $con->close();
            $result->free();
        }
        ?>

        <div class="dropdown">
            <button class="accBtn"><img src="images/Myaccount.png" class="logo1"/></button>
            <div class="accContent">
                <h3>My Account</h3>
                <?php
                
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
                    if ($record = $result->fetch_object()) {
        printf("
                <a href='editAcc.php?username=%s' class='content'>Profile</a>
                <a href='editAdd.php?username=%s' class='content'>Address</a>
                <a href='changePass.php?username=%s' class='content'>Password</a>
                             ", $record->UserID, $record->UserID, $record->UserID);
                    }
                }
                $result->free();
                $con->close();
                ?>

            </div>
        </div>

        <form action="" method="POST">
            <table class="editAcc">
            <tr class="acc1">
            <caption><h2 class="h2acc">Profile Details</h2></caption>
            </tr>
        <tr class="acc1">
            <td class="customiao"><label for="eusername" class="head">Username</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->UserID);
            }
        }
        $result->free();
        $con->close();
        ?>
        <tr class="acc1">
            <td class="customiao"><label for="editemail" class="head">Email</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Email);
            }
        }
        $result->free();
        $con->close();
        ?>
        <tr class="acc1">
            <td class="customiao"><label for="editname" class="head">First Name</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Fname);
            }
        }
        $result->free();
        $con->close();
        ?>
        <tr class="acc1">
            <td class="customiao"><label for="editname" class="head">Last Name</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Lname);
            }
        }
        $result->free();
        $con->close();
        ?>
        <tr class="acc1">
            <td class="customiao"><label for="editCont" class="head">Contact Number</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                             ", $record->Contact);
            }
        }
        $result->free();
        $con->close();
        ?>
        <tr class="acc1">
            <td class="customiao"><label for="editGen" class="head">Gender:</label></td>
        </tr>
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM loginc WHERE UserID='{$_COOKIE['UserID']}'";

if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("
                        <tr class='acc1'>

                       <td class='column1'>%s</td>

                        </tr>
                         <tr class='acc1'><td><a class='editbtn' href='edit_Acc.php?username=%s'>EDIT</a></td></tr>
                             ", getGender()[$record->Gender], $record->UserID);
            }
        }
        $result->free();
        $con->close();
        ?>



            </table>
        </form>

        <?php
    include './footer1.php';
    ?>
</body>
</html>