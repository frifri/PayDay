<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    if(!$this->session->userdata['user_login'])
        redirect('/welcome');
    ?>
    <head>
        <title> PDFE </title>
    </head>
    <body>
        <h3>My friends</h3>
        <div>
            <?php
            if(count($friendsList) >= 1) {
                foreach($friendsList as $friend) {
                    echo "<div>Name: ".$friend->fullname."</div><br />";
                }
            } else {
                echo "<div>You have no friends! :(</div>";
            }
            ?>
        </div>
        <a href='<?=site_url("/home/index")?>'>Cancel</a>
        <a href='<?=site_url("/welcome/logout")?>'>Logout</a>
    </body>
</html>