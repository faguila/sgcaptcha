<?php
    // Example for the PHP simple geometric captcha
    session_start();
    $sent = (isset($_SESSION['captcha'])) ? TRUE : FALSE;
    if ($sent) {
        $value = stripslashes(strip_tags(trim($_POST['value'])));
        $captchaOk = ($value == $_SESSION['captcha']) ? TRUE : FALSE;
        unset($_SESSION['captcha']);
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta name="application-name" content="Simple geometric captcha for PHP" />
    <meta name="author" content="Francisco del Aguila. faguila@alboran.net" />
    <title>Simple geometric captcha example</title>
</head>
<body>
    <?php
        if ($sent) {
            if ($captchaOk) {
                echo 'CORRECT<br/><hr/>';
            } else {
                echo 'INCORRECT<br/><hr/>';
            }    
        }
    ?>
    <h1>Simple geometric captcha example</h1>
    <img src="sgcaptcha.php" style="width:350px;" alt="Captcha" />
    <br/>
    Input the digits inside the key figures.
    <br/>
    (Key figures are the ones equal to the black coloured, at the right)
    <br/>
    <form action="example.php" method="post">
        <input type="text" name="value" size="12" maxlength="12" />
        <br/>
        <input type="submit" value="submit" />
    </form>
    <br/><br/>
    <span style="font-size:.8em;">
        Copyright &copy; 2014, Francisco del Aguila<br/>
        This software is under the MIT license.<br/>
        See contents of file README.txt for more information.
    </span>
</body>
</html>
