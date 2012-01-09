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
            echo form_open('expenses/addExpense');
            echo form_label('Title: ');
            echo form_input('title', '');
            echo form_label('Amount: ');
            echo form_input('amount', '');
            
            // TODO: give the ability to the user to change the date of the event
//            echo form_label('Date: ');
//            echo form_input(array('name' => "date", 'id' => "exp_date"));
            
            echo form_label('Location: ');
            echo form_input('location', '');
            echo form_label('Description: ');
            echo form_textarea('description', '');
            
            $optionPayer = array();
            $optionPayer[$user_id] = "Me";
            
            echo form_label('Who\'s gonna pay? ');
            if(count($friendsList) >= 1) {
                foreach($friendsList as $friend) {
                    $optionPayer[$friend->id] = $friend->fullname;
                }
            }
            
            echo form_dropdown("payer", $optionPayer);
            
            echo form_label('My friends in this expense: ');
            if(count($friendsList) >= 1) {
                foreach($friendsList as $friend) {
                    echo form_checkbox("friends[]", $friend->id, FALSE);
                    echo $friend->fullname;
                }
            }else{
                echo "You have no friends to share this expense with! :(";
            }

            echo form_submit('submitExpense', 'Add expense!');
            echo form_close();
            ?>
        </div>
        <a href='<?=site_url("/plans/index")?>'>Cancel</a>
        <a href='<?=site_url("/welcome/logout")?>'>Logout</a>
    </body>
</html>