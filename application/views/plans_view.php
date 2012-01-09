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
        <h3>Expense(s) for <?=$plan_name?></h3>

        <?php
        if(count($expenseslist) >= 1) {   
        ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            <?php
            foreach($expenseslist as $expense) {
                echo '<tr>';
                echo '<td><a href="' . site_url("/expenses/index") . '?id=' . $expense->id . '">'.$expense->title.'</a></td>';
                echo '<td>'.$expense->amount.'</td>';
                echo '<td><a href="'. site_url("/expenses/deleteExpense") .'?id='.$expense->id.'">delete</a></td>';
                echo '</tr>';
            }
            ?>    
        </table>
        <a href='<?= site_url("/plans/getSummary") ?>'>get The summury</a>
        <?php
        } else {
            echo "No expenses for this plan";
        }
        ?>

        <a href='<?= site_url("/expenses/indexAdd") ?>'>Adding an expense</a>
        <a href='<?= site_url("/welcome/logout") ?>'>Logout</a>
    </body>
</html>