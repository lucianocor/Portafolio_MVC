document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-materia');
  const inputId = document.getElementById('id-materia');
  const inputNombre = document.getElementById('nombre-materia');
  const selectEstado = document.getElementById('estado-materia');
  const inputAnio = document.getElementById('anio-materia');
  const btnGuardar = document.getElementById('btn-guardar');
  const btnCancelar = document.getElementById('btn-cancelar');
  const listaMaterias = document.getElementById('lista-materias');

  let listaLocalMaterias = [];

  cargarMaterias();

  // 1. Manejo del Submit (Crear o Editar apuntando al Router)
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const esEdicion = inputId.value !== '';
    
    // Apuntamos a la acción correspondiente del Router
    const url = esEdicion ? 'index.php?action=update' : 'index.php?action=store';[cite: 1]

    try {
      const res = await fetch(url, {
        method: 'POST',
        body: formData
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Error al procesar la materia');

      resetearFormulario();
      cargarMaterias();
    } catch (error) {
      alert(error.message);
    }
  });

  // 2. Evento del botón Cancelar
  btnCancelar.addEventListener('click', () => {
    resetearFormulario();
  });

  // 3. Cargar y renderizar registros desde el Router
  async function cargarMaterias() {
    try {
      const res = await fetch('index.php?action=listar_json');
      const materias = await res.json();
      listaLocalMaterias = materias;

      listaMaterias.innerHTML = '';

      if (materias.length === 0) {
        listaMaterias.innerHTML = '<tr><td colspan="4" style="text-align:center; color:#94a3b8;">No hay materias cargadas</td></tr>';
        return;
      }

      materias.forEach(materia => {
        const badgeClass = obtenerClaseBadge(materia.Estado);
        const tr = document.createElement('tr');
        tr.id = `materia-${materia.MateriaId}`;

        tr.innerHTML = `
          <td>${escaparHTML(materia.NombreMateria)}</td>
          <td><span class="badge ${badgeClass}">${materia.Estado}</span></td>
          <td>${materia.Anio}° Año</td>
          <td class="acciones-crud">
            <button type="button" class="btn-accion btn-editar" onclick="cargarParaEditar(${materia.MateriaId})">Editar</button>
            <button type="button" class="btn-accion btn-eliminar" onclick="eliminarMateria(${materia.MateriaId})">Eliminar</button>
          </td>
        `;

        listaMaterias.appendChild(tr);
      });
    } catch (error) {
      console.error('Error cargando materias:', error);
    }
  }

  // 4. Activar modo edición
  window.cargarParaEditar = function (id) {
    const materia = listaLocalMaterias.find(m => parseInt(m.MateriaId) === id);
    if (!materia) return;

    inputId.value = materia.MateriaId;
    inputNombre.value = materia.NombreMateria;
    selectEstado.value = materia.Estado;
    inputAnio.value = materia.Anio;

    btnGuardar.textContent = 'Actualizar';
    btnGuardar.classList.remove('btn-azul');
    btnGuardar.classList.add('btn-amarillo');

    btnCancelar.style.display = 'inline-flex';
    inputNombre.focus();
  };

  // 5. Eliminar registro apuntando al Router
  window.eliminarMateria = async function (id) {
    if (!confirm('¿Seguro que querés eliminar esta materia?')) return;

    const formData = new FormData();
    formData.append('id', id);

    try {
      const res = await fetch('index.php?action=delete', {
        method: 'POST',
        body: formData
      });[cite: 1]

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Error al eliminar');

      const fila = document.getElementById(`materia-${id}`);
      if (fila) fila.remove();

      if (inputId.value == id) resetearFormulario();
    } catch (error) {
      alert(error.message);
    }
  };

  // 6. Resetear formulario
  function resetearFormulario() {
    form.reset();
    inputId.value = '';
    btnGuardar.textContent = 'Guardar';
    btnGuardar.classList.remove('btn-amarillo');
    btnGuardar.classList.add('btn-azul');
    btnCancelar.style.display = 'none';
  }

  function obtenerClaseBadge(estado) {
    switch (estado) {
      case 'Aprobada': return 'badge-aprobada';
      case 'Regular': return 'badge-regular';
      default: return 'badge-cursando';
    }
  }

  function escaparHTML(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
  }
});