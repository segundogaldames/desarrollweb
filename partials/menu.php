<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">DesarrolloWeb</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>

                <?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] != 'Cliente'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administracion
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_COMUNAS; ?>">Comunas</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_REGIONES; ?>">Regiones</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_TIPOS; ?>">Producto Tipos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_PERSONAS; ?>">Personas</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_ROLES; ?>">Roles</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(!isset($_SESSION['autenticado'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_USUARIOS . 'login.php'; ?>">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo ucwords($_SESSION['usuario_nombre']); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a href="<?php echo BASE_USUARIOS . 'editPassword.php?id=' . $_SESSION['usuario_id']; ?>" class="dropdown-item">Editar Password</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo BASE_USUARIOS . 'logout.php'; ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>