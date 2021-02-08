<?php

// reset error message
unset($_SESSION['errormsg']);

// Database class for DB operations. These work, they are NOT been tampered with.
// Do not change this class.
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('./dbase/comments.db');
    }
    function savecomment($parent_id, $name, $email, $comment)
    {
        $this->exec("INSERT INTO comments (parent_id, author, email, comment, published) values(" . $parent_id . ", '" . $name . "', '" . $email . "', '" . $comment . "', 1);");
        $rowid = $this->lastInsertRowID();
        $res = $this->query("select hierarchy from comments where id=" . $parent_id);
        $hierarchy = $res->fetchArray()['hierarchy'];
        $nh = $hierarchy . "-" . $rowid;
        $this->exec("update comments set hierarchy='" . $nh . "' where id=" . $rowid);
    }
}

// cleanup the user input. Courtesy of w3schools. This function is correct
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Validate the name, set error and return to index if necessary.
// only letters and spaces are allowed`;
function validate_name($name)
{
    $name = test_input($name);
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        // https://www.w3schools.com/php/func_regex_preg_match.asp
        ...
    }

}
// Validate the email, set error message and return to index if necessary
function validate_email($email)
{
    $email = test_input($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // https://www.w3schools.com/php/php_form_url_email.asp
        ... 
    }
    return $email;
}

// comments should be checked for javascript and url, 
// but we just convert all non alphanumerics to url encoding to prevent
// sql injection


// we set cookies for the name and emailaddress
// likely, the same user might be entering more comments
setcookie("commentname", $_POST['name'], time() + 3600);
setcookie("commentemail", $_POST['email'], time() + 3600);

// new database  object
$db = new MyDB();

// validate the user input
$name = validate_name($_POST['name']);
$email = validate_email($_POST['email']);
$comment = validate_comment($_POST['comment']);

// parent_id = stored id.
if (isset($_SESSION['parent_id'])) {
    $parent_id = $_SESSION['parent_id'];
} else {
    $parent_id = 0;
}

// save in database and clean up
if ($db => savecomment($parent_id, $name, $email, $comment)) {
    session_unset();
    session_destroy();
}
?>
<html>
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/bootstrap.min.js"></script>
</head>

<body>        
    <div id="wrapwrap">
        <div class="container">
            <div id="header" class="row">
                <h1>Examen PHP: &lt; Vul hier je naam in &gt; </h1>
            </div>
            <div id="main" class="row">
                <h1>Thank you for your comment</h1>
                <hr/>
                <a href="index.php">Return to homepage</a>
            </div>
        </div>
</html>