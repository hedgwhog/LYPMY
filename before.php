<?php
    session_start();
    $msg = $_SESSION['accountmsg'];
    $_SESSION['accountmsg'] = '';

    if (isset($_SESSION['user'])) { header('location: home.php'); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="before-container login-bg" id="beforeContainerWrapper">
        <div class="before-background-container">
            <div id="login-section" style="display: block;">
                <h2>Login</h2>
                <form action="./db/accounthandle.php" method="POST">
                    <!-- The login backend needs to be able to let the user login and get send to the homepage after the login succeeds -->
                    <label>Username: <input type="text" name="name"></label>
                    <label>Password: <input type="password" name="pass"></label>
                    <button type="submit" name="method" value="login">Login</button>
                    <a href="#" class="switch-button">Have no account? Sign up here!</a>
                    <h3><?= $msg ?></h3>
                </form>
            </div>

            <div id="signup-section" style="display: none;">
                <h2>Sign Up</h2>
                <form action="./db/accounthandle.php" method="POST">
                    <!-- After the signup, the user gets send back to the login form. With the new account info, a user should be able to log in with the new account -->
                    <label>Username: <input type="text" name="name"></label>
                    <label>Display Name: <input type="text" name="display"></label>
                    <label>Password: <input type="password" name="pass"></label>
                    <label>Repeat Password: <input type="password" name="repeat"></label>
                    <button type="submit" name="method" value="register">Register</button>
                    <a href="#" class="switch-button">Already have an account? Login here!</a>
                    <h3><?= $msg ?></h3>
                </form>
            </div>
        </div>
    </div>
<script>
    const wrapper = document.getElementById('beforeContainerWrapper');
    const login = document.getElementById('login-section');
    const signup = document.getElementById('signup-section');

    document.querySelectorAll('.switch-button').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault(); 

            wrapper.classList.toggle('login-bg');
            wrapper.classList.toggle('signup-bg');

            const isLoginVisible = login.style.display !== 'none';
            login.style.display = isLoginVisible ? 'none' : 'block';
            signup.style.display = isLoginVisible ? 'block' : 'none';
        });
    });
</script>
</body>
</html>