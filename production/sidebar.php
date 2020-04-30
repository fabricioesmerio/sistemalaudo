<!-- sidebar menu -->
<?php

if ($_SESSION['tipo'] == "Med") { ?>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3 class="text-center">Menu</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="index.php">Página Inicial</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-users"></i> Usuário <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="newUser.php"> <i class="fa fa-user-plus"></i> Novo</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-mobile"></i> Mobile <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="http://localhost/iOviyam2/patient.html"> <i class="fa fa-share" aria-hidden="true"></i>Acessar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
<?php
} elseif($_SESSION['tipo'] == "Pat") { ?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3 class="text-center">Menu</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="area_paciente.php">Página Inicial</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
<?php
}
?>
<!-- /sidebar menu -->


<!-- /menu footer buttons -->
</div>
</div>