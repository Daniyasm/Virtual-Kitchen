<!-- <?php echo file_exists('../action/login_action.php') ? 'Found action file!' : 'Missing action file!'; ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" type="text/css" href="../stylesheet-form.css?v=1.1">
</head>
<body>
    <header>
        <h1> 
            Gram's Kitchen     
        </h1>
           
        <ul id="nav">
            <li><a href="recipes.php">Recipes</a></li>
            <li><a href="search.php"> Search </a></li>
            <li><a href="login.php"> Login </a></li>
            <!-- <li><a href="contact-us.html"> Contact Us </a></li> -->
        </ul>
           
    </header>
    <main>
        <form class="form" method="POST" action="../action/login_action.php">
            <p class="title">Log In</p>
            <p class="message">Welcome back! Please enter your login details.</p>

            <label>
                <input name="username" required placeholder="" type="text" class="input">
                <span>Username</span>
            </label> 

            <label>
                <input name="password" required placeholder="" type="password" class="input">
                <span>Password</span>
            </label>

            <button class="submit" type="submit">Log In</button>
            <p class="signin">Don't have an account? <a href="register.php">Register</a> </p>
        </form>
    </main>

</body>
</html>
