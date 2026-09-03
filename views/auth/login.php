<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="seccion-login">
  <!-- max-width y margin:auto garantizan que la tarjeta no supere los 400px y quede centrada -->
  <div class="card-login" style=" width: 800px; margin: 40px auto;">
    <h2 class="login-titulo">Iniciar Sesión</h2>
    
    <?php if (isset($error)): ?>
      <p class="msg-error">
        <?= $error === 'campos_vacios' ? 'Completá todos los campos.' : 'Email o clave incorrectos.' ?>
      </p>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST" class="form-login">
      <div class="campo-crud">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="admin@ciber.dev" required>
      </div>

      <div class="campo-crud">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn-azul btn-login">Ingresar</button>
    </form>
  </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>