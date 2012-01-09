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
        <div>
            <?php
            echo form_open('plans/addPlan');
            echo form_label('Name: ');
            echo form_input('name', '');

            echo form_label('My friends in this plan: ');
            if(count($friendsList) >= 1) {
                foreach($friendsList as $friend) {
                    echo form_checkbox("friends[]", $friend->id, FALSE);
                    echo $friend->fullname;
                }
            }else{
                echo "You have no friends! :(";
            }

            echo form_submit('submitPlan', 'Add plan!');
            echo form_close();
            ?>
        </div>
        <a href='<?=site_url("/home/index")?>'>Cancel</a>
        <a href='<?= site_url("/welcome/logout") ?>'>Logout</a>
    </body>
</html>