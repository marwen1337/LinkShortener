<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 08.08.2019
 * Time: 15:52
 */

if(!$core->isUserLoggedIn()) header("Location: login");

if(!empty($_POST)){


    print_r(json_encode(array("error" => false)));
    exit;
}

if(!empty($_GET['action'])){
    if($_GET['action'] == "getShortlinks"){
        $stmt = $core->getPDO()->prepare("SELECT * FROM shortlinks WHERE short_creator = :user_id");
        $stmt->execute(array(":user_id" => $core->getUserID()));
        print_r(json_encode(array($stmt->fetchAll())));
        exit;
    }
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

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card m-3">
                <div class="card-body">
                    <h3 lang="your_shortened_links"></h3>
                    <div class="card-text">
                        <table class="table table-hover mt-3 mb-0">
                            <thead>
                            <tr>
                                <th scope="col" lang="short_url"></th>
                                <th scope="col" lang="target_url"></th>
                                <th scope="col" lang="created"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2">Larry the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                        </table>
                        <?php
                        $stmt = $core->getPDO()->prepare("SELECT COUNT(short_id) as count_total FROM shortlinks WHERE short_creator = :user_id");
                        $stmt->execute(array(":user_id" => $core->getUserID()));
                        $shortlinks_count = $stmt->fetch()['count_total'];
                        ?>
                        <div class="text-right">
                            <small><?= $shortlinks_count ?></small>
                            <small lang="shortened_links"></small>
                        </div>
                        <button class="btn btn-primary w-100 mt-3" lang="create_new_shortlink" onclick="$('html,body').animate({scrollTop: $('#form_create_targeturl').offset().top}, function() {$('#form_create_targeturl').focus();});"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card m-3">
                <div id="form_create_accordion">
                    <div id="collapse_create_form">
                        <div class="collapse show" data-parent="#form_create_accordion">
                            <div class="card-body">
                                <h3 lang="create_new_shortlink"></h3>
                                <div class="card-text">
                                    <form id="form_create">
                                        <div class="form-group">
                                            <label for="form_create_targeturl" lang="target_url"></label>
                                            <input class="form-control" type="text" id="form_create_targeturl" placeholder="https://example.com">
                                            <div class="valid-feedback">
                                                <span lang="url_provided_is_valid"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                <span lang="url_provided_is_invalid"></span>
                                            </div>
                                        </div>
                                        <button class="btn btn-info mb-3 w-100" type="button" data-toggle="collapse" data-target="#collapse_create_customtoken" aria-expanded="false" aria-controls="collapse_create_customtoken" lang="use_customtoken"></button>
                                        <div class="collapse" id="collapse_create_customtoken">
                                            <div class="form-group">
                                                <label for="form_create_customtoken_customtoken" lang="customtoken"></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?= $core->getWebUrl() ?></span>
                                                    </div>
                                                    <input class="form-control" type="text" id="form_create_customtoken_customtoken">
                                                </div>
                                            </div>
                                        </div>
                                        <input class="btn btn-primary w-100" type="submit" id="form_create_submit" lang="create_new_shortlink" lang_scope="value">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapse_create_success">
                        <div class="collapse" data-parent="#form_create_accordion">
                            <div class="card-body text-center">
                                <div class="card-text">
                                    <h3 class="card-title" lang="shortlink_created"></h3>
                                    <button class="btn btn-primary w-100" lang="continue" onclick="$('#form_create').trigger('reset');$('#form_create_targeturl').removeClass('is-valid');$('#form_create_accordion').find('.collapse:not(#collapse_create_customtoken)').collapse('show');"></button>
                                    <small lang="shortlink_created_long"></small>
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

        $('#form_create').on('submit', function (event) {
            event.preventDefault();

            var targeturl = $('#form_create_targeturl');

            if(targeturl.hasClass('is-valid')){


                console.log("Valid");


                $("#form_create_accordion").find('.collapse:not(#collapse_create_customtoken)').collapse('show');

            }else targeturl.addClass('is-invalid');
        });

        $('#form_create_targeturl').on('input', function (event) {
            var valid = validURL($(this).val());
            if(!valid) $(this).addClass('is-invalid').removeClass('is-valid');
            else $(this).addClass('is-valid').removeClass('is-invalid');
        });

    });
</script>
</body>
</html>
