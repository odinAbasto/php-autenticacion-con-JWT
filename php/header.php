<div class="header-container">
<header>
    <img src="img/books.png" alt="" width="70" height="70">
    <a href="index.php">
        <h1>Biblioteca</h1>
    </a>
    <?php
        session_start();
        if(isset($_SESSION['login'])){
            echo "<div class='login-container'>";
            echo "<p>Usuario: " . $_SESSION['login'] . "</p>";
            echo "<p>Rol: " . $_SESSION['rol'] . "</p>";
            echo "<a class='btn' href='editar-usuario.php?login=" . $_SESSION['login'] . "'>Editar perfil</a>";
            echo "<a class='' href='logout.php'>Cerrar sesión</a>";
            echo "</div>";

        }
    ?>
</header>
    <div class="nav-container">
    <?php
            if(isset($_SESSION['login'])){
                if($_SESSION['rol']=='administrador'){
                    echo "<nav>
                        <ul>
                            <li><a href='index.php'><img src='img/home.svg'  ></a></li>
                            <li><a href='listar.php'>Listar libros</a></li>
                            <li><a href='insertar.php'>Insertar libro</a></li>
                            <li><a href='buscar.php'>Buscar libros</a></li>
                            <li><a href='gestion-usuarios.php'>Gestionar usuarios</a></li>                         
                        </ul>
                    </nav>";
                }elseif($_SESSION['rol']=='bibliotecario'){
                    echo "<nav>
                        <ul>
                            <li><a href='index.php'><img src='img/home.svg'  ></a></li>
                            <li><a href='listar.php'>Listar libros</a></li>
                            <li><a href='insertar.php'>Insertar libro</a></li>
                            <li><a href='buscar.php'>Buscar libros</a></li>                          
                        </ul>
                    </nav>";
                }elseif($_SESSION['rol']=='registrado'){
                    echo "<nav>
                        <ul>
                            <li><a href='index.php'><img src='img/home.svg'  ></a></li>
                            <li><a href='listar.php'>Listar libros</a></li>
                            <li><a href='buscar.php'>Buscar libros</a></li>                          
                        </ul>
                    </nav>";
                }
            }
        ?>
    </div>
</div>