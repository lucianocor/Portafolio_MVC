let listaMateriasGlobal = []; // Guarda las materias en memoria para no volver a pedirlas al editar

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-materia');
  const btnCancelar = document.getElementById('btn-cancelar');

  // Carga la tabla al abrir la página
  cargarMaterias();

  // 1. Guardar o Modificar materia
  form.addEventListener('submit', async (e) => {
    e.preventDefault(); // Evita que la página recargue

    const id = document.getElementById('id-materia').value;
    const url = id ? 'index.php?action=update' : 'index.php?action=store';

    try {
      const res = await fetch(url, {
        method: 'POST',
        body: new FormData(form) // Empaqueta todos los campos del form automáticamente
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Error en el servidor');

      resetearFormulario();
      cargarMaterias(); // Refresca la tabla
    } catch (error) {
      alert(error.message);
    }
  });

  // 2. Cancelar edición
  if (btnCancelar) {
    btnCancelar.addEventListener('click', resetearFormulario);
  }
});

// --- FUNCIONES CRUD (Accesibles globalmente para los onclick de la tabla) ---

// 3. Consultar y pintar materias
async function cargarMaterias() {
  const contenedor = document.getElementById('lista-materias');

  try {
    const res = await fetch('index.php?action=listar_json');
    listaMateriasGlobal = await res.json();

    contenedor.innerHTML = '';

    if (listaMateriasGlobal.length === 0) {
      contenedor.innerHTML = '<tr><td colspan="4" style="text-align:center;">No hay materias</td></tr>';
      return;
    }

    listaMateriasGlobal.forEach(m => {
      contenedor.innerHTML += `
        <tr id="materia-${m.MateriaId}">
          <td>${m.NombreMateria}</td>
          <td><span class="badge badge-${m.Estado.toLowerCase()}">${m.Estado}</span></td>
          <td>${m.Anio}° Año</td>
          <td class="acciones-crud">
            <button type="button" class="btn-accion" onclick="cargarParaEditar(${m.MateriaId})">Editar</button>
            <button type="button" class="btn-accion" onclick="eliminarMateria(${m.MateriaId})">Eliminar</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error al cargar materias:', error);
  }
}

// 4. Cargar datos en el formulario para editar
function cargarParaEditar(id) {
  const materia = listaMateriasGlobal.find(m => parseInt(m.MateriaId) === id);
  if (!materia) return;

  document.getElementById('id-materia').value = materia.MateriaId;
  document.getElementById('nombre-materia').value = materia.NombreMateria;
  document.getElementById('estado-materia').value = materia.Estado;
  document.getElementById('anio-materia').value = materia.Anio;

  document.getElementById('btn-guardar').textContent = 'Actualizar';
  const btnCancelar = document.getElementById('btn-cancelar');
  if (btnCancelar) btnCancelar.style.display = 'inline-flex';
}

// 5. Eliminar materia
async function eliminarMateria(id) {
  if (!confirm('¿Seguro que querés eliminar esta materia?')) return;

  const datos = new FormData();
  datos.append('id', id);

  try {
    const res = await fetch('index.php?action=delete', {
      method: 'POST',
      body: datos
    });

    const data = await res.json();
    if (!res.ok) throw new Error(data.error || 'Error al eliminar');

    // Quita la fila del DOM al instante
    const fila = document.getElementById(`materia-${id}`);
    if (fila) fila.remove();
  } catch (error) {
    alert(error.message);
  }
}

// 6. Limpiar formulario
function resetearFormulario() {
  const form = document.getElementById('form-materia');
  form.reset();
  document.getElementById('id-materia').value = '';
  document.getElementById('btn-guardar').textContent = 'Guardar';
  
  const btnCancelar = document.getElementById('btn-cancelar');
  if (btnCancelar) btnCancelar.style.display = 'none';
}