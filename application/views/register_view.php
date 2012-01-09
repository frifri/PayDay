<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title> PDFE </title>
    </head>
    <body>
        <h3>Register a user</h3>
        <div>
            <?php echo $errorDesc; ?>
        </div>
        <div>
            <?php
                echo form_open('register/addUser');
                echo form_label('Login: ');
                echo form_input('login', 'Enter your login');
                echo form_label('Password: ');
                echo form_password('password');
                echo form_label('Email: ');
                echo form_input('email', 'Enter your email');
                echo form_label('Full Name: ');
                echo form_input('fullName', 'Enter your full name');
                echo form_submit('submitLogin', 'Register!');
                echo form_close();
            ?>
        </div>
        <a href='<?=site_url("/welcome")?>'>Cancel</a>
    </body>
</html>