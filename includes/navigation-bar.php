<!-- Navigation bar -->
<div class="nav-bar">
    <div class="nav-brand">
        <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/">
            <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/images/SRDC-Logo.png" alt="" class="img-responsive">
        </a>
    </div>
    <div>
        <a class="nav-link text-maroon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/schedule">Lessen</a>
    </div>
    <div>
        <a class="nav-link text-maroon" href="#">Workshops</a>
    </div>
    <div>
        <a class="nav-link text-maroon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/parties">Parties</a>
    </div>
    <div>
        <a class="nav-link text-maroon" href="#">Shows</a>
    </div>
    <?php if (isset($_SESSION['user'])) { ?>
        <div class="dropdown-mobile">
            <a class="nav-link text-maroon" href="#">Profiel</a>
            <a class="nav-link text-maroon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/register.php">Registreer nieuwe gebruiker</a>
            <form method="post" action="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/logout.php">
                <input type="submit" name="submit" value="Uitloggen" class="nav-link text-maroon">
            </form>
        </div>
        <div class="dropdown-desktop">
            <a class="nav-link text-maroon">Admin</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profiel</a></li>
                <li><a class="dropdown-item" href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/register.php">Registreer nieuwe gebruiker</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="post" action="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/logout.php">
                        <input type="submit" name="submit" value="Uitloggen" class="dropdown-item">
                    </form>
                </li>
            </ul>
        </div>
    <?php } else { ?>
        <div>
            <a class="nav-link text-maroon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/CLE2/login.php">Inloggen</a>
        </div>
    <?php } ?>
</div>