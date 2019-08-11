<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 08.08.2019
 * Time: 15:51
 */

?>

<!doctype html>
<html lang="<?= $_COOKIE['lang']; ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $core->getWebUrl();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $core->getWebUrl();?>/assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo $core->getWebUrl();?>/assets/css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
    <title>Login</title>

    <script>
        var lang = <?php echo json_encode($core->fullLang());?>;
    </script>

</head>
<body>

<?php include "navbar.php";?>

<div class="container">
    <div class="row">
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col">

        </div>
    </div>
</div>

<script src="<?php echo $core->getWebUrl();?>/assets/js/jquery.min.js"></script>
<script src="<?php echo $core->getWebUrl();?>/assets/js/popper.min.js"></script>
<script src="<?php echo $core->getWebUrl();?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo $core->getWebUrl();?>/assets/js/script.js"></script>
<script>

    $(document).ready(function (event) {
        doLanguage();
    });
</script>
</body>
</html>

