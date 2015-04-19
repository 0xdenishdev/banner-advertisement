<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php print ucfirst($banner->name); ?> | Web Templates | Template Monster</title>
        <link rel="icon" href="http://static.tmimgcdn.com/img/favicon.ico?037f475" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="../style/jumbotron-narrow.css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h3 class="text-muted" style="color: DodgerBlue;">Banner <span style="color: red;"><?php print $banner->name; ?></span></a></h3>
            </div>

            <div class="jumbotron">
                <!-- <h1><?php //print $banner->name; ?></h1> -->
                <div align="left">
                    <span class="label label-primary">Width:</span>
                    <?php print $banner->width; ?>
                </div>
                <div align="left">
                    <span class="label label-primary">Height:</span>
                    <?php print $banner->height; ?>
                </div>
                <div align="left">
                    <span class="label label-primary">Display:</span>
                    <?php print $banner->display; ?>
                </div>
                <div align="left">
                    <span class="label label-primary">Page:</span>
                    <?php print $banner->page_address; ?>
                </div>
                <div align="left">
                    <span class="label label-primary">Banner html code:</span>
                    <?php print htmlspecialchars($banner->banner_body); ?>
                </div>
                <div align="left">
                    <span class="label label-primary">Banner:</span><br /><br />
                    <?php print $banner->banner_body; ?>
                </div>
            </div>

            <footer class="footer">
                <p>&copy; Ninjava 2015</p>
            </footer>
        </div><!-- container -->
    </body>
</html>
