<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 10.08.2019
 * Time: 14:08
 */
?>

<nav class="navbar navbar-expand-lg navbar-light rounded fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
            <div class="nav-item dropdown">
                <?php $languages = $core->languages(); ?>
                <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo '<span class="flag-icon flag-icon-' . $_COOKIE['lang'] . '"></span>&nbsp;<span lang="' . $languages[$_COOKIE['lang']] . '"></span>';?></a>
                <div class="dropdown-menu" aria-labelledby="dropdown09">
                    <?php

                    foreach ($languages as $key => $value){
                        echo '<a class="dropdown-item" href="?lang=' . $key . '"><span class="flag-icon flag-icon-' . $key . '"></span>&nbsp;<span lang="' . $value . '"></span></a>';
                    }

                    ?>
                </div>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="home" lang="home"></a>
            </div>
            <?php

            if($core->isUserLoggedIn()):
                ?>
                <div class="nav-item">
                    <a class="nav-link" href="dash" lang="dashboard"></a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="logout" lang="logout"></a>
                </div>
            <?php
            else:
                ?>
                <div class="nav-item">
                    <a class="nav-link" href="login" lang="login"></a>
                </div>
            <?php
            endif

            ?>
        </div>
    </div>
</nav>
