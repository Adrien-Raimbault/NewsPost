<header>
    <nav role="navigation">
        <ul>
            <li><a href="index.php?page=home">Home</a></li>
            <?php
                if(isset($_SESSION['login']) && $_SESSION['login'] === true) {
                    echo "<li><a href=\"index.php?page=logout\">Logout</a></li>";
                    echo "<li><a href=\"index.php?page=account\">Mon compte</a></li>";
                }
                else {
                    echo "<li><a href=\"index.php?page=login\">Login</a></li>";
                    echo "<li><a href=\"index.php?page=user_sub\">Inscription</a></li>";
                    echo "<li><a href=\"index.php?page=guest_sub\">Souscrire</a></li>";

                }
            ?>
            <?php
                if((isset($_SESSION['login']) && $_SESSION['login'] === true) && $_SESSION['role'] >= 2 ) {
                    echo "<li><a href=\"index.php?page=admin\">Administration</a></li>";
                }
            ?>
        </ul>
    </nav>
</header>
