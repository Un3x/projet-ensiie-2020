<?php
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
?>
<div class="container">
    <h2> Sign Up </h2>
    <p> Please fill this form to create an user account : </p>
    <form action="borrowBook.php?register=1" method="post">
        <label> Username</label>
        <input type="text" name="username" >
        <span><?php echo $username_err;?></span>

        <label>Password</label>
        <input type="password" name ="password">
        <span ><?php echo $password_err;?></span>

        <label>Confirm password</label>
        <input type="password" name ="confirm_password">
        <span ><?php echo $confirm_password_err;?></span>


        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
        </form>

        <p> Already have an account ?
        
        <a href="borrowBook.php?log=1">Login here</a>
        </p>

</div>
<script src="script.js"></script>