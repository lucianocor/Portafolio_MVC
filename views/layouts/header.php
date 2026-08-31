<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Luciano | Portafolio</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="css/estilosCiber.css">
</head>
<body>

  <header class="navbar">
    <div class="logo">
      <span></span>Luciano<span>.dev</span>
    </div>
    
    <nav class="menu">
      <a href="index.php#inicio" class="enlace">Inicio</a>
      <a href="index.php#proyectos" class="enlace">Proyectos</a>
      <a href="index.php#habilidades" class="enlace">Habilidades</a>
      <a href="index.php#materias" class="enlace">Materias</a>
      <a href="index.php#formulario" class="btn-contacto">Contacto</a>

      <!-- Si está autenticado muestra Cerrar Sesión, si no muestra Login -->
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <span style="font-size: 13px; color: #00e5ff;">(<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>)</span>
        <a href="index.php?action=logout" class="btn-borde" style="border-color: #ef4444; color: #ef4444;">Salir</a>
      <?php else: ?>
        <a href="index.php?action=login" class="btn-borde">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <main class="contenedor">