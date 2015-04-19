<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="icon" href="http://static.tmimgcdn.com/img/favicon.ico?037f475" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="../style/jumbotron-narrow.css" />
        <title><?php print htmlentities($title); ?></title>
    </head>
    <body>
        <?php
        if ($errors) {
            print '<ul>';
            foreach ($errors as $value => $error) {
                print '<li>' . htmlentities($error) . '</li>';
            }
            print '</ul>';
        }
        ?>
        <div class="container">
            <div class="header">
                <h3 class="text-muted" style="color: DodgerBlue;">Add<span style="color: red;">Banner</span></a></h3>
            </div>

            <div class="jumbotron">
                <form method="POST" action="">
                    <label for="name" class="label label-primary">Name:</label><br/>
                    <input type="text" name="name" value="<?php print htmlentities($name) ?>"/>
                    <br />          
                    <label for="width" class="label label-primary">Width:</label><br/>
                    <input type="text" name="width" value="<?php print htmlentities($width) ?>"/>
                    <br />
                    <label for="height" class="label label-primary">Height:</label><br/>
                    <input type="text" name="height" value="<?php print htmlentities($height) ?>" />
                    <br />
                    <label for="display" class="label label-primary">Display:</label><br/>
                    <input type="text" name="display" value="<?php print htmlentities($display) ?>" />
                    <br />
                    <label for="page" class="label label-primary">Page:</label><br/>
                    <input type="text" name="page" value="<?php print htmlentities($page) ?>" />
                    <br />
                    <label for="bnrBody" class="label label-primary">Body:</label><br/>
                    <textarea name="bnrBody" rows="5" cols="70"><?php print htmlentities($bnrBody) ?></textarea>
                    <br /><br />
                    <input type="hidden" name="form-submitted" value="1" />
                    <input class="btn btn-success" type="submit" value="Submit" />
                </form>
            </div>

            <footer class="footer">
                <p>&copy; Ninjava 2015</p>
            </footer>
        </div><!-- container -->
    </body>
</html>
