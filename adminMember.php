<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ACCOUNT DETAILS</title>
        <link href="css/adminEdit.css" rel="stylesheet" type="text/css"/>
        <?php
        
        global $adminid;
        ?>
    </head>
    <body style="background-image:url('images/3.jpg');background-size:cover;background-repeat:no-repeat;">
        <?php
        require_once './config/php.php';
        include './adminHeader1.php';
        ?>


        <?php
// Retrieve adminid or email from cookie, isset
        if (isset($_COOKIE['AdminID'])) {
            $adminID = $_COOKIE['AdminID'];
            $sql = "SELECT * FROM logina WHERE AdminID = '$adminid'";
} elseif (isset($_COOKIE['Aemail'])) {
            $aemail = $_COOKIE['Aemail'];
            $sql = "SELECT * FROM logina WHERE Aemail = '$aemail'";
} else {
            echo "<center><div class='msg'>You haven't logged in! [<a href='login-admin.php'>LOG IN</a>]</div></center>";
            exit();
        }


        ?>


    <center><h1>Account Details</h1></center>

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


    <div class="adminDetails">
            <div class="AdminIDetails">
                <span class="display">Admin ID</span>
            <br>
            <center><?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

             if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
} elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
}

if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        printf("


                       <span class='output'>%s</span>


                             ", $record->AdminID);
                    }
                }
                $result->free();
                $con->close();
                ?></center>
        </div>

            <div class="AdminEmails">
                <span class="display">Email Address</span>
            <br>
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
} elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
}

if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("


                       <span class='output'>%s</span>


                             ", $record->Aemail);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
            </div>
            <div class="AdminFullNames">
                <span class="display">Full Name</span>
            <br>
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                  if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
} elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
}

if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("


                       <span class='output'>%s</span>


                             ", $record->Aname);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
            </div>
            <div class="AdminPasswords">
                <span class="display">Password</span>
            <br>
            <span class="outputS" style="margin-left: 572px;">**********</span>
            <?php
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
            printf("<a href='adminChange.php?adminid=%s'>Change Password</a>", $record->AdminID);
                    }
                }
                $result->free();
                $con->close();
                ?>
                    </div>
        <div class="AdminContactNumber">
            <span class="display">Contact Number</span>
            <br>
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                   if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("


                       <span class='output'>%s</span>


                             ", $record->Acontact);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
        </div>
            <div class="AdminGender">
                <span class="display">Gender</span>
                <br>
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("


                       <span class='output'>%s</span>


                             ", getGender()[$record->Agender]);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
            </div>
            <div class="AdminLocation">
                <span class="display">Street</span>
                <br>
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                   if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("


                       <span class='output'>%s</span>


                             ", $record->Astreet);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
            </div>
            <div class="AdminLocation">
                    <span class="display">Town/City</span>
                    <br>
                    <center><?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                      if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                            while ($record = $result->fetch_object()) {
                                printf("


                       <span class='output'>%s</span>


                             ", $record->ATown);
                            }
                        }
                        $result->free();
                        $con->close();
                        ?></center>
                </div>
            <div class="AdminLocation">
                    <span class="display">Postcode</span>
                    <br>
                    <center><?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                       if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                            while ($record = $result->fetch_object()) {
                                printf("


                       <span class='output'>%s</span>


                             ", $record->APostcode);
                            }
                        }
                        $result->free();
                        $con->close();
                        ?></center>
                </div>
            <div class="AdminLocation">
                    <span class="display">State</span>
                    <br>
                    <center><?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                            while ($record = $result->fetch_object()) {
                                printf("


                       <span class='output'>%s</span>


                             ", $record->AState);
                            }
                        }
                        $result->free();
                        $con->close();
                        ?></center>
                </div>
            <div class="memberEditbtn">
                <center><?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                   if (isset($_COOKIE['AdminID'])) {
    $sql = "SELECT * FROM logina WHERE AdminID = '{$_COOKIE['AdminID']}'";
            } elseif (isset($_COOKIE['Aemail'])) {
    $sql = "SELECT * FROM logina WHERE Aemail = '{$_COOKIE['Aemail']}'";
            }
if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf(" <a href='editAdmin.php?adminid=%s' class='EditAdminBtn'>EDIT</a>", $record->AdminID);
                        }
                    }
                    $result->free();
                    $con->close();
                    ?></center>
            </div>
    </div>




</body>
</html>