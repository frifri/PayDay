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
        <h3>Home</h3>

        <?php
        if(count($planList) >= 1) {   
        ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php
            foreach($planList as $plan) {
                echo '<tr>';
                echo '<td><a href="' . site_url("/plans/index") . '?id=' . $plan->id . '">'.$plan->name.'</a></td>';
                echo '<td>'.$plan->date.'</td>';
                echo '<td><a href="'. site_url("/plans/deletePlan") .'?id='.$plan->id.'">delete</a></td>';
                echo '</tr>';
            }
            ?>    
        </table>
        <?php
        } else {
            echo "No plans right now...";
        }
        ?>

        <a href='<?= site_url("/plans/indexAdd") ?>'>Adding a plan</a>
        <a href='<?= site_url("/friends/loadFriends") ?>'>My friends</a>
        <a href='<?= site_url("/welcome/logout") ?>'>Logout</a>
    </body>
</html>