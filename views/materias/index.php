<?php require_once __DIR__ . '/../layouts/header.php'; ?>


<section id="inicio" class="seccion-hero">
  <div> 
    <h1 class="titulo-principal">
      Desarrollo Web & <br>
      <span class="color-cian">Software Seguro</span>
    </h1>

    <p class="descripcion">
      Estudiante de programación enfocado en construir aplicaciones web robustas, código limpio y buenas prácticas de seguridad.
    </p>

    <div class="grupo-botones">
      <!-- <a href="#proyectos" class="btn-azul">Ver Proyectos</a>  en proceso-->
      <a href="https://github.com/lucianocor" target="_blank" class="btn-borde">GitHub</a>
      <!-- <a href="mailto:luboss369@gmail.com" class="btn-borde">Email</a> -->
    </div>
  </div>

  <div class="columna-tarjeta">
    <div class="tarjeta-perfil">
      <div class="marco-foto">
        <img src="img/perfil.jpg" class="foto" alt="Foto de perfil">
      </div>
    </div>
  </div>
</section>


<section id="materias" class="seccion-materias">
  <div class="encabezado-seccion">
    <h2>Seguimiento de Materias</h2>
    <p>Registro y control de estado académico</p>
  </div>

  <div class="panel-materias">
    <form id="form-materia" class="form-crud-materia" autocomplete="off">
      <input type="hidden" id="id-materia" name="id" value="">

      <div class="campo-crud">
        <label for="nombre-materia">Nombre de la materia</label>
        <input type="text" id="nombre-materia" name="nombre" placeholder="Ej: Programación I" required>
      </div>

      <div class="campo-crud">
        <label for="estado-materia">Condición</label>
        <select id="estado-materia" name="estado" class="select-crud" required>
          <option value="Cursando">Cursando</option>
          <option value="Regular">Regularizada</option>
          <option value="Aprobada">Aprobada</option>
          <option value="Libre">Libre</option>
        </select>
      </div>

      <div class="campo-crud">
        <label for="anio-materia">Año</label>
        <input type="number" id="anio-materia" name="anio" min="1" max="3" placeholder="Ej: 1° Año" required>
      </div>

      <div class="botones-crud">
        <button type="submit" id="btn-guardar" class="btn-azul btn-crud">Guardar</button>
        <button type="button" id="btn-cancelar" class="btn-borde btn-crud" style="display: none;">Cancelar</button>
      </div>
    </form>

    <div class="tabla-contenedor">
      <table class="tabla-materias">
        <thead>
          <tr>
            <th>Materia</th>
            <th>Estado</th>
            <th>Año</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="lista-materias">
        
        </tbody>
      </table>
    </div>
  </div>
</section>




<section id="formulario">
  <form action="index.php?action=contacto_enviar" method="POST" class="card-formulario">
    <h1>Formulario de contacto</h1>
    <div class="form_input">
      <label>Nombre</label>
      <input type="text" name="nombre" placeholder="Nombre" required />
    </div>
    <div class="form_input">
      <label>Apellido</label>
      <input type="text" name="apellido" placeholder="Apellido" required />
    </div>
    <div class="form_input">
      <label>Mail</label>
      <input type="email" name="email" placeholder="Correo" required />
    </div>
    <div class="form_input">
      <label>Mensaje</label>
      <textarea name="mensaje1" placeholder="Mensaje" required></textarea>
    </div>
    <div class="form_input">
      <details>
        <summary>¿Quieres agregar algo?</summary>
        <textarea name="mensaje2" placeholder="Mensaje adicional..."></textarea>
      </details>
    </div>
    <div class="boton">
      <button type="submit" class="btn-azul">Enviar</button>
    </div>
  </form>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>