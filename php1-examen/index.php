<?php
session_start();

// Database class for DB operations. These work, they are NOT been tampered with.
// Do not change this class.
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('./dbase/comments.db');
    }

    function get_comments()
    {
        $result = $this->query('SELECT * FROM comments where published = 1 order by hierarchy');
        $comments = array();
        $i = 0;
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            $comments[$i]['id'] = $res['id'];
            $comments[$i]['parentid'] = $res['parent_id'];
            $comments[$i]['author'] = $res['author'];
            $comments[$i]['email'] = $res['email'];
            $comments[$i]['comment'] = urldecode($res['comment']);
            $comments[$i]['offset'] = sizeof(explode('-', $res['hierarchy'])) - 1;
            $i += 1;
        }
        return $comments;
    }
}

// database object
$db = new MyDB();
// Vraag alle comments op.
$db->get_comments();

// Set some variables for easier use.
$name = $_COOKIE['commentname'];
$email = $_COOKIE['commentemail'];
$comment = $_SESSION['comment'];
$_SESSION['parent_id'] = $_GET['commentid'];
// reset the name
$name = null;
// We might have a stale error message. Clear it
if (true) {
    unset($_SESSION['errormsg']);
}
?>

<html>
<head>
    <!-- Some bootstrap, just for fun -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/bootstrap.min.js"></script>
</head>

<body>        
    <div id="wrapwrap">
        <div class="container">
            <div id="header" class="row">
                <!-- Vergeet je naam niet! -->
                <h1>Examen PHP: &lt; Lander Neufcourt &gt; </h1>
            </div>
            <!-- Het artikel -->
            <div id="main" class="row">
                <div class="col-md-8 offset-md-2">
                    <h2>Lorem ipsum dolor sit amet.</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam optio consequatur impedit, voluptatem exercitationem, nihil sit adipisci sunt maxime delectus sapiente reiciendis? Repudiandae tempora ratione quia laborum, sunt iusto suscipit.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti temporibus eos, perspiciatis, voluptatibus praesentium minus fugiat corporis omnis explicabo, cupiditate consequuntur! Ratione voluptates nulla rerum qui atque exercitationem saepe provident molestiae sint! Ad voluptate reprehenderit nostrum laborum quam, rem perspiciatis.</p>
                </div>
            </div>
            <!-- De comments-sectie, hier begint de actie! -->
            <div id="comments" class="row">
                <?php 
                if ($_SESSION['errormsg'] != '') {
                    ?>
                    <!-- if error, show the error message -->
                    <div class="alert alert-danger" role="alert">
                       <?php $_SESSION['errormsg']; ?>
                    </div>
                <?php

            }
            ?>
                <div class="col-md-8 offset-md-2">
                    <hr/>
                    <!-- If we want to add a comment, call ourselves with the right commentid 
                    commentid 0 = a comment to the article itself-->
                    <a href="index.php?commentid=0" class="link">Leave a comment</a>
                    <?php if (isset($_GET['commentid']) && $_GET['commentid'] == '0') { ?>
                    <form action="savecomment.php" method="POST">
                        <div class="form-group">
                            <label for="name">Author</label>
                            <input id="name" name="name" type="text" class="form-control" value="<?php echo $name; ?>"></input>
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="<?php echo $email; ?>"></input>
                            <label for="comment">Comment</label>
                            <textarea id="comment" name="comment" type="textarea" class="form-control" value="<?php echo $comment; ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success mt-16">Submit</button>
                    </form>
                    <?php 
                } ?>
                    <h4>Comments</h4>
                        <?php
                        // Voor elke comment, toon deze
                        foreach ($comments as $row) {
                            ?>
                                <!-- Offset the card with each sublevel of cmments, use $row['offset'] -->
                                <div class="card offset-md-" >
                                    <div class="card-body">
                                    <h5 class="card-title">Comment <?php echo $row['id']; ?></h5>
                                    <blockquote class="blockquote-footer mb-0"><?php echo $row['author']; ?></blockquote>
                                    <p class="card-text"><?php echo $row['comment']; ?></p> 
                                    </div>
                                    <div class="card-footer text-muted">
                                    <!-- If we want to add a comment, call ourselves with the right commentid of the comment
                                    we are commenting -->
                                        <a href="index.php?commentid=$row['id']" class="card-link">Reply to this comment</a>
                                            <?php 
                                            // als commentid == deze rij, toon het formulier 
                                            if (isset($_POST['commentid']) && $_POST['parent_id'] == $row['id']) ?>
                                            <!-- het formulier, vul waarden in waar mogelijk -->
                                            <form action="savecomment.php" method="POST">
                                                <div class="form-group">
                                                    <label for="name">Author</label>
                                                    <input id="name" name="name" type="text" class="form-control" value="<?php echo $name; ?>"></input>
                                                    <label for="email">Email</label>
                                                    <input id="email" name="email" type="email" class="form-control" value="<?php echo $email; ?>"></input>
                                                    <label for="comment">Comment</label>
                                                    <textarea id="comment" name="comment" type="textarea" class="form-control" value="<?php echo $comment; ?>"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success mt-16 ">Submit</button>
                                            </form>
                                        
                                    
                                   
                               </div>
                        </div>
                                    <?php 
                                } ?>
                                
                </div>
            </div>
            <div id=" footer " class=" row "></div>
        </div>
        
    </div>
</body>
</html>