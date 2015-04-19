<?php 

    require_once 'model/BannersService.php';

    $bannersService = new BannersService();
    $id = $bannersService->getUserId(Session::get()[0]);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Admin Panel | Web Templates | Template Monster</title>
        <link rel="icon" href="http://static.tmimgcdn.com/img/favicon.ico?037f475" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="../style/jumbotron-narrow.css" />
    </head>
    <body>
        <div class="container">
            <div id="badge-login">
                <a href="#" style="line-height: 0px;"><?php print Session::get()[0]; ?></a>
                <a href="index.php?op=signout">sign out</a>
            </div>

            <div class="header">
                <h3 class="text-muted" style="color: DodgerBlue;">Admin<span style="color: red;">Panel</span></a></h3>
            </div>

            <div class="jumbotron">
                <div class="btn btn-success"><a href="index.php?op=new">Add new banner</a></div><br /><br />
                <!-- <div class="btn btn-danger"><a href="index.php?op=signout"><?php //echo Session::get()[0]; ?> signout</a></div> -->
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><a href="?orderby=name">Name</a></th>
                            <th><a href="?orderby=width">Width</a></th>
                            <th><a href="?orderby=height">Height</a></th>
                            <th><a href="?orderby=display">Display</a></th>
                            <th><a href="?orderby=page_address">Page</a></th>
                            <th><a href="?orderby=banner_body">Banner</a></th>
                            <th><img src='../images/delete.png' style='width: 20px; height: 20px;'></th>
                            <th><img src='../images/edit.png' style='width: 20px; height: 20px;'></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($banners as $banner): ?>
                        <tr>
                            <td><a href="index.php?op=show&id=<?php print $banner->banner_id; ?>"><?php print htmlentities($banner->name); ?></a></td>
                            <td><?php print htmlentities($banner->width); ?></td>
                            <td><?php print htmlentities($banner->height); ?></td>
                            <td><?php print htmlentities($banner->display); ?></td>
                            <td><?php print htmlentities($banner->page_address); ?></td>
                            <td><?php print htmlentities($banner->banner_body); ?></td>
                            <td><a href="index.php?op=delete&id=<?php print $banner->banner_id; ?>">delete</a></td>
                            <td><a href="index.php?op=update&id=<?php print $banner->banner_id; ?>">edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <table class="contacts" border="0" cellpadding="0" cellspacing="0">
                    <p>Generated code:</p> 
                    <p>Insert current link into head of your web-site:</p>
                    <textarea rows="1" cols="90">
                    <script type="text/javascript" src="../mvc/admin/js/bannerAds.js"></script>
                    </textarea>
                    <p>Insert current code into any place you want:</p>
                    <textarea rows="8" cols="90">
                        <iframe
                            id="banner"
                            src=""
                            width=""
                            height=""
                            style="display: none;"
                            page="">
                          </iframe>
                          <script>
                            var author = <?php print $id; ?>;
                            showBanner(author);
                          </script>
                    </textarea>
                </table>
            </div>

            <footer class="footer">
                <p>&copy; Ninjava 2015</p>
            </footer>
        </div><!-- container -->
    </body>
</html>
