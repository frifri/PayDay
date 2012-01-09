<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title> PDFE login </title>
    </head>
    <body>
        <h3>PayDay login page</h3>
        <div>
            <?php
                echo form_open('welcome/login');
                echo form_label('Login: ');
                echo form_input('login', 'Enter your login');
                echo form_label('Password: ');
                echo form_password('password');
                echo form_submit('submitLogin', 'Login!');
                echo form_close();
            ?>
        </div>
        <a href='<?=site_url("/register")?>'>Register</a>
    </body>
</html>