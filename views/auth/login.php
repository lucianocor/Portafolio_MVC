<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="seccion-hero" style="justify-content: center; min-height: 60vh;">
  <div style="max-width: 400px; width: 100%;">
    <div class="panel-materias">
      <h2 style="font-size: 22px; text-align: center;">Iniciar Sesión</h2>
      
      <?php if (isset($error)): ?>
        <p style="color: #ef4444; font-size: 14px; text-align: center;">
          <?= $error === 'campos_vacios' ? 'Completá todos los campos.' : 'Email o clave incorrectos.' ?>
        </p>
      <?php endif; ?>

      <form action="index.php?action=login" method="POST" style="box-shadow: none; margin-top: 10px; padding: 0;">
        <div class="campo-crud" style="margin-bottom: 15px;">
          <label>Email</label>
          <input type="email" name="email" placeholder="admin@ciber.dev" required>
        </div>

        <div class="campo-crud" style="margin-bottom: 20px;">
          <label>Contraseña</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-azul" style="width: 100%; border: none; cursor: pointer;">Ingresar</button>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>