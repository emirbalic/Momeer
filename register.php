<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    // echo 'whoami';
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue ($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Momeer</title>
    
    <link rel="stylesheet" type="text/css" href="assets/css/register.css"></link>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <div id="background">
        <div id="loginContainer">
            <div id='inputContainer'>
                <form action="register.php" id="loginForm" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>

                    <label for="loginUsername">Username</label>
                    
                    <input id="loginUsername" type="text" name="loginUsername" placeholder="e.g. John Doe"  required> 
                    </p>
                    <p>
                    <label for="loginPassword">Password</label>
                    <input id="loginPassword" type="password" name="loginPassword" placeholder="password" required> 
                    </p>
                    <button type="submit" name="loginButton">Submit</button>

                    <div class="hasAccountText"> 
                        <span id="hideLogin">Don't have an account yet? Signup here </span>
                    </div>
                </form>

                <form action="register.php" id="registerForm" method="POST">
                    <h2>Create your free account</h2>
                    <p>
                    <?php echo $account->getError(Constants::$usernameCharacters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
                    <br>
                    <label for="userName">User name</label>
                    <input id="userName" type="text" name="userName" placeholder="e.g. John Doe" value="<?php getInputValue('userName') ?>" required> 
                    </p>
                    <!-- <p> -->
                    <p>
                    <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                    <br>
                    <label for="firstName">First Name</label>
                    <input id="firstName" type="text" name="firstName" placeholder="e.g. John " value="<?php getInputValue('firstName') ?>" required> 
                    </p>
                    <!-- <p> -->
                    <p>
                    <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                    <br>
                    <label for="lastName">Last Name</label>
                    <input id="lastName" type="text" name="lastName" placeholder="e.g. Doe" value="<?php getInputValue('lastName') ?>" required> 
                    </p>
                    <!-- <p> -->
                    
                    <p>
                    <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                    <!-- <br> -->
                    <?php echo $account->getError(Constants::$emailTaken); ?>
                    <!-- <br> -->
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <!-- <br> -->
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="johndoe@gmail.com" value="<?php getInputValue('email') ?>" required> 
                    </p>
                    <!-- <p> -->
                    <p>
                    <label for="email2">Confirm email</label>
                    <input id="email2" type="email" name="email2" placeholder="johndoe@gmail.com" value="<?php getInputValue('email2') ?>" required> 
                    </p>
                    <p>
                    <?php echo $account->getError(Constants::$passwordsCharacters); ?>
                    <?php echo $account->getError(Constants::$passwordsNotAlfanumeric); ?>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="password" required> 
                    </p>
                    <p>
                    <label for="password2">Password</label>
                    <input id="password2" type="password" name="password2" placeholder="password" required> 
                    </p>
                    <button type="submit" name="registerButton">Sign Up</button>
                    <div class="hasAccountText"> 
                        <span id="hideRegister">Already have an account? Login here </span>
                    </div>
                </form>
            </div>
        </div> 
    </div>   
</body>
</html>