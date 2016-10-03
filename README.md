# sgcaptcha
Simple graphics captcha for PHP

USAGE

    Include the next line in your HTML/PHP webpage:
    
    <img src="{path}/sgcaptcha.php" alt="Captcha" />
    
    The captcha solution value is stored in $_SESSION['captcha']
    The key figure appears at right with no value.
    User must input digits inside the key figures. The result may be an empty string.

    See the 'example.php' file.
    
    You can change the colour schema and length of the key editing the file 'captcha.php'.


REQUIREMENTS

    Requires GD library enabled in PHP. 


LICENSE

    This software is published under the MIT license. (see http://opensource.org/licenses/MIT)
    This information must remain in all copies of this software.


HISTORY
    Version 1, 2014-06-07. First version.
