<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>MANAGE CUSTOMER</title>
        <link href="css/manageUser.css" rel="stylesheet" type="text/css"/>
        <?php
        global $gender;
        global $state;
        global $adminid;
        global $hideform;
        ?>
    </head>
    <body style="background-image:url(images/3.jpg);background-size:cover;background-repeat:no-repeat;">
        <?php
        include './adminHeader1.php';
        require_once './config/php.php';
        ?>
        <?php
// Retrieve adminid or email from cookie, if set
        if (isset($_COOKIE['AdminID'])) {
            $adminID = $_COOKIE['AdminID'];
            $sql = "SELECT * FROM logina WHERE AdminID = '$adminID'";
} elseif (isset($_COOKIE['Aemail'])) {
            $aemail = $_COOKIE['Aemail'];
            $sql = "SELECT * FROM logina WHERE Aemail = '$aemail'";
} else {
            echo "<center><div class='msg'>You haven't logged in! [<a href='login-admin.php'>LOG IN</a>]</div></center>";
            exit();
        }
        ?>
<?php
        
//perform "GET" function to retrieve id from url and then retrieve record from DB.dislay in the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //perform GET method
            //retrieve User ID from URL
    (isset($_GET['username'])) ?
                            $username = strtoupper(trim($_GET['username'])) :
                            $username = "";

            //STEP 1: connect
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //STEP 2: SQL statement
            $sql = "SELECT * FROM loginc";

    //STEP 3:Execute sql
            $result = $con->query($sql);
            if ($record = $result->fetch_object()) {
                //record found
                $username = $record->UserID;
                $email = $record->Email;
                $password = $record->Password;
                $fname = $record->Fname;
                $lname = $record->Lname;
                $contact = $record->Contact;
                $gender = $record->Gender;
                $street = $record->Street;
                $town = $record->Town;
                $postcode = $record->Postcode;
                $state = $record->State;
                $securityCode = $record->SecurityCode;
            } else {
                echo "<center><div class='msg'>No record found![<a href='admin-homepage.php'>Back to home</a>]</div></center>";
                $hideform = true;
            }
            $con->close();
            $result->free();
        }
        ?>
<?php
$header = array(
            'UserID' => 'User ID',
            'Email' => 'Email',
            'Fname' => 'First Name',
            'Lname' => 'Last Name',
            'Contact' => 'Contact Number',
            'Street' => 'Street',
            'Town' => 'Town/City',
            'Postcode' => 'Postcode',
            'State' => 'State',
            'Gender' => 'Gender',
            'SecurityCode'=> 'SecurityCode'
);
        
global $sort, $order;
if (isset($_GET['sort']) && isset($_GET['order'])) {
    $sort = (array_key_exists($_GET['sort'], $header) ? $_GET['sort'] : 'UserID');
//how to arrange order sequence ASC/DESC
    $order = ($_GET['order'] == 'DESC') ? 'DESC' : 'ASC';
} else {
    $sort = "UserID";
    $order = "ASC";
}
if (isset($_GET['state'])) {
    $state = (array_key_exists($_GET['state'], getState()) ? $_GET['state'] : '%');
} else {
    $state = "%";
}
        
        ?>


<?php if ($hideform == false): ?>
        <center><h1>Manage Customer</h1></center>
    <?php
    //handle multiple delete
    //check if user clicked the delete button?
    if (isset($_POST['btnDeleteChecked'])) {
        //yes, User clicked the button
        $checked = $_POST["checked"]; //this is an array
        if (!empty($checked)) {
            //proceed to delete
//step1 :Establish  establish connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            foreach ($checked as $value) {
                $esChecked[] = $con->real_escape_string($value);
            }
            //Step 2 :sql statement
            //convert array to string
            //DELETE FROM STUDENT WHERE STUDENT ID IN ('22PMD00001','22PMD00002');
            $sql = "DELETE FROM loginc WHERE UserID IN('" . implode("','", $esChecked) . "')";

            if ($con->query($sql)) {
                printf("<div class='info'><b>%d</b> record(s) has been deleted.</div>", $con->affected_rows);
            }
            $con->close();
        }
    }
    ?>
    <div>
        <table style="margin-left: auto; margin-right: auto;">
            <tr>
                <td class="setting">
                        <?php
                        $adminid = isset($_GET["adminid"]) ? $_GET["adminid"] : $adminid = "";
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        if (isset($_COOKIE['AdminID'])) {
                            $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
    } elseif (isset($_COOKIE['Aemail'])) {
                            $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
    }

                        if ($result = $con->query($sql)) {
                            if ($record = $result->fetch_object()) {
                                printf("<a href='adminMember.php?adminid=%s' class='admin'>Setting</a> </td>", $record->AdminID);
                            }
                        }
                        ?>
                    </td>
                        <td class="setting">
                            <?php
                            $adminid = isset($_GET["adminid"]) ? $_GET["adminid"] : $adminid = "";
                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                            if (isset($_COOKIE['AdminID'])) {
                                $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
    } elseif (isset($_COOKIE['Aemail'])) {
                                $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
    }
                            if ($result = $con->query($sql)) {
                                if ($record = $result->fetch_object()) {
                                    printf("<a href='manageuser.php?adminid=%s' class='admin'>Manage</a> </td>", $record->AdminID);
                                }
                            }
                            ?>
                        </td>
                </tr>
        </table>
    </div>

    <div class="divMng">
        <form action="" method="POST">
            <table class="mngTable" border="1px">
                <tr class="manageTR">
                <th></th>
                <?php
                foreach ($header as $key => $value) {
                    if ($key == $sort) {
                        //YES,user clicked to perform sorting
                        printf('<th class="mng"><a href="?sort=%s&order=%s&state=%s">%s</a>%s
                            </th>'
                                , $key
                                , $order == 'ASC' ? 'DESC' : 'ASC'
                                , $state//to retain the filter eefect even after i sort the record
                , $value
                                , $order == 'ASC' ? '🔺' : '🔻');
    } else {
                        //NO, user never click anything, default
                        printf('<th>
                        <a href="?sort=%s&order=ASC"&state=%s>%s</a>
                            </th>', $key, $state, $value);
    }
                }
                ?>
                <th></th>
            </tr>
            <?php
            // Step 2 link php application with Database
            //object-oriented method OOP
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //step 3 SQL Statement
            $sql = "SELECT * FROM loginc
                    WHERE State LIKE'$state'
                    ORDER BY $sort $order";

//step 4 Run SQL
            //NOTE : $result - contains all records
            if ($result = $con->query($sql)) {
                while ($record = $result->fetch_object()) {
                    printf("
                        <tr class='manageTR'>
                        <td class='mng'><input type='checkbox'name='checked[]' value='%s' /></td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'>%s</td>
                       <td class='mng'><a href='admineditcust.php?username=%s'>Edit</a> | <a href='admindeletecust.php?username=%s'>Delete</a></td>
                        </tr>
                             ", $record->UserID
                            , $record->UserID,
                            $record->Email,
                            $record->Fname,
                            $record->Lname,
                            $record->Contact,
                            $record->Street,
                            $record->Town,
                            $record->Postcode,
                            $record->State,
                getGender()[$record->Gender],
                            $record->SecurityCode,
                            $record->UserID,
                            $record->UserID);
                }
            }
            //STEP 5 Close database connection
            $result->free();
            $con->close();
            ?>

        </table>
        <input type="submit" value="Delete Checked" name="btnDeleteChecked" onclick="return confirm('This will delete all checked records. \n Are you sure?')" />
        </form>
    </div>

    <?php endif; ?>
</body>
</html>