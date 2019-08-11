<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 08.08.2019
 * Time: 15:51
 */

if($core->isUserLoggedIn()) header("Location: dash");

if(!empty($_POST)){

    $username = $_POST['form_username'];
    $password = $_POST['form_password'];
    $remain = !empty($_POST['form_remain']);
    $stmt = $core->getPDO()->prepare("SELECT * FROM users WHERE user_name = :user_name AND user_password = :user_password LIMIT 1");
    $stmt->execute(array(":user_name" => $username, ":user_password" => $core->hash($password)));
    if($stmt->rowCount() == 1){
        $row = $stmt->fetch();
        $_SESSION['uid'] = $row['user_id'];

        if(!empty($remain)){
            //TODO: Securitytokens einfügen

        }

        print_r(json_encode(array("error" => "false")));
    }else $core->printError("wrong_login");

    exit;
}

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

<div class="container-fluid h-100">
    <div class="content text-center h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-8 col-md-5 col-xl-3">
                <div class="card text-left">
                    <div id="accordion">
                        <div class="card-body" id="collapse_login">
                            <div class="collapse show" data-parent="#accordion">
                                <h3 class="card-title" lang="login"></h3>
                                <div class="card-text">
                                    <form id="form_login">
                                        <div class="form-group">
                                            <label for="form_username" lang="username"></label>
                                            <div class="input-group">
                                                <input class="form-control" id="form_username" name="form_username" type="text" lang="username" lang_set="placeholder">
                                                <div class="invalid-feedback">
                                                    <span lang="username_invalid"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="form_password" lang="password"></label>
                                            <div class="input-group">
                                                <input class="form-control" id="form_password" name="form_password" type="password" lang="password" lang_set="placeholder">
                                                <div class="input-group-append" id="form_password_peak">
                                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash"></i></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    <span lang="password_invalid"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="form_remain" type="checkbox" name="form_remain">
                                            <label class="custom-control-label" for="form_remain" lang="remain_signed_in"></label>
                                        </div>
                                        <input class="btn btn-primary w-100 mt-3" id="form_submit" type="submit" name="form_submit" lang="login" lang_set="value">
                                    </form>
                                    <div class="row">
                                        <div class="col"><hr></div>
                                        <div class="col-auto"><span lang="or"></span></div>
                                        <div class="col"><hr></div>
                                    </div>
                                    <a href="register"><button class="btn btn-info w-100" lang="register"></button></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center" id="collapse_success">
                            <div class="collapse" data-parent="#accordion">
                                <h3 class="card-title" lang="login_successful"></h3>
                                <div class="card-text">
                                    <a href="dash"><button class="btn btn-success w-100" lang="continue"></button></a>
                                    <small lang="login_successful_long"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        $('#form_login').on('submit', function (event) {
            event.preventDefault();

            var data = $(this).serialize();
            $.ajax({
                url: window.location,
                type: 'post',
                data: data,
                success: function (data) {
                    var json = JSON.parse(data);

                    if(json.error == true){
                        $("#form_login input:not(input[type=checkbox])").addClass("is-invalid");
                    }else {
                        $('.collapse').collapse('show').find('button').focus();
                    }
                },
                error: function (data) {

                }
            });
        });
        $('input').on('input', function (event) {
            if($(this).val().length === 0) $(this).addClass('is-invalid').removeClass('is-valid');
            else $(this).addClass('is-valid').removeClass('is-invalid');
        });
        $('#form_password_peak').on('click', function (event) {
            var input = $('#form_password');
            var attr = input.attr("type");

            if(attr === "text") input.attr("type", "password");
            else input.attr("type", "text");

            $(this).find('i.fa-eye, i.fa-eye-slash').toggleClass("fa-eye-slash fa-eye");
        });
    });
</script>
</body>
</html>