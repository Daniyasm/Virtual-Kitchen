
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration System</title>
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
            <form class="form" method="POST" action="../action/register_action.php">
                <p class="title">Register </p>
                <p class="message">Signup now to add, edit and delete your own recipes! </p>

                <label>
                    <input name="username" required placeholder="" type="text" class="input">
                    <span>Username</span>
                </label> 

                <label>
                    <input name="email" required placeholder="" type="email" class="input">
                    <span>Email</span>
                </label> 
                    
                <label>
                    <input name="password" required placeholder="" type="password" class="input">
                    <span>Password</span>
                </label>

                <button class="submit" type="submit">Register</button>
                <p class="signin">Already a user? <a href="login.php">Log In</a> </p>
            </form>
        </main>
    </body>
</html>