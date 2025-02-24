<div id="menu_admin">
    <div v-for="gestion in menu">
        <button @click="viewMenu(gestion.id)">{{ gestion.title }}</button>
    </div>
    <div v-if="verCat" class="d-flex gap-2">
        <div class="w-75">
            <h2>Gestión de servicios especiales</h2>
            <table id="categorias" class="table table-striped table-hover">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Borrado</th>
                    <th>Acciones</th>
                </tr>
                <tr v-for="categoria in categorias">
                    <td>{{ categoria.id }}</td>
                    <td>{{ categoria.nombre }}</td>
                    <td>{{ categoria.borrado?'Si':'No' }}</td>
                    <td class="d-flex gap-2">
                        <button @click="editarCategoria(categoria)" class="btn btn-info"><i class="mdi mdi-pencil-outline"></i></button>
                        <form action="<?= BASE_URL ?>categorias/delete" method="post" v-if="categoria.borrado == false">
                            <input type="hidden" name="id" id="id" v-model="categoria.id">
                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-outline"></i></button>
                        </form>
                        <form action="<?= BASE_URL ?>categorias/reactive" method="post" v-if="categoria.borrado == true">
                            <input type="hidden" name="id" id="id" v-model="categoria.id">
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-reload"></i></button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <form action="<?= BASE_URL ?>categorias" method="post">
            <h2>{{formularioCategoria.id ? 'Editar' : 'Crear nueva'}} categoría</h2>
            <input type="number" name="id" id="id" v-model="formularioCategoria.id" readonly hidden>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required v-model="formularioCategoria.nombre">
            <button type="submit">{{ formularioCategoria.id ? 'Editar' : 'Crear' }}</button>
            <button type="button" v-if="formularioCategoria.id" @click="formularioCategoria={}">Cancelar</button>
        </form>
    </div>

    <div v-if="verMed">
        <h2>Gestión de médicos</h2>
        <table id="medicos" class="table table-striped table-hover">
            <tr>
                <th>Id</th>
                <th>Especialidad</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Telefono</th>

            <tr v-for="medico in medicos">
                <td>{{ medico.id }}</td>
                <td>{{ medico.especialidad }}</td>
                <td>{{ medico.nombre }}</td>
                <td>{{ medico.telefono }}</td>
                <td>{{ medico.borrado }}</td>

                <td class="d-flex gap-2">
                    <button @click="editarMedico(medico)" class="btn btn-info"><i class="mdi mdi-pencil-outline"></i></button>

                    <form action="<?= BASE_URL ?>medicos/delete" method="POST" v-if="medico.borrado == false">
                        <input type="hidden" name="id" id="id" v-model="medico.id">
                        <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-outline"></i></button>
                    </form>
                    <form action="<?= BASE_URL ?>medicos/reactive" method="POST" v-if="medico.borrado == true">
                        <input type="hidden" name="id" id="id" v-model="medico.id">
                        <button type="submit" class="btn btn-success"><i class="mdi mdi-reload"></i></button>
                    </form>
                </td>
            </tr>
        </table>
        <form action="<?= BASE_URL ?>medicos" method="post">
    <h2>{{ formularioMedico.id ? 'Editar' : 'Crear nuevo' }} médico</h2>

    <input type="hidden" name="id" v-model="formularioMedico.id">

    <label for="nombre">Nombre</label>
    <input type="text" v-model="formularioMedico.nombre" required>

    <label for="apellidos">Apellidos</label>
    <input type="text" v-model="formularioMedico.apellidos" required>

    <label for="telefono">Teléfono</label>
    <input type="text" v-model="formularioMedico.telefono" required pattern="[0-9]{9}" title="Debe contener 9 dígitos numéricos">

    <label for="especialidad">Especialidad</label>
    <input type="text" v-model="formularioMedico.especialidad" required>

    <button type="submit">{{ formularioMedico.id ? 'Editar' : 'Crear' }}</button>
    <button type="button" v-if="formularioMedico.id" @click="resetFormMedico">Cancelar</button>
        </form>
        <div v-if="verCitas">
        <h2>Gestión de citas</h2>
        <table id="citas" class="table table-striped table-hover">
            <tr>
                <th>Id</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <tr v-for="cita in citas">
                <td>{{ cita.id }}</td>
                <td>{{ cita.paciente_nombre }}</td>
                <td>{{ cita.medico_nombre }}</td>
                <td>{{ cita.fecha }}</td>
                <td>{{ cita.hora }}</td>
                <td>{{ cita.estado }}</td>
                <td class="d-flex gap-2">
                    <button class="btn btn-info" @click="editarCita(cita)">
                        <i class="mdi mdi-pencil-outline"></i>
                    </button>
                    <form action="<?= BASE_URL ?>citas/delete" method="POST">
                        <input type="hidden" name="id" v-model="cita.id">
                        <button type="submit" class="btn btn-danger">
                            <i class="mdi mdi-delete-outline"></i>
                        </button>
                    </form>
                </td>
            </tr>
        </table>

        <form action="<?= BASE_URL ?>citas" method="post" id="formularioCita">
            <h2>{{ formularioCita.id ? 'Editar' : 'Crear nueva' }} cita</h2>
            <input type="hidden" name="id" v-model="formularioCita.id">

            <label for="paciente_id">Paciente</label>
            <select name="paciente_id" v-model="formularioCita.paciente_id" required>
                <option v-for="paciente in pacientes" :value="paciente.id">
                    {{ paciente.nombre }}
                </option>
            </select>

            <label for="medico_id">Médico</label>
            <select name="medico_id" v-model="formularioCita.medico_id" required>
                <option v-for="medico in medicos" :value="medico.id">
                    {{ medico.nombre }} - {{ medico.especialidad }}
                </option>
            </select>

            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" v-model="formularioCita.fecha" required>

            <label for="hora">Hora</label>
            <input type="time" name="hora" v-model="formularioCita.hora" required>

            <label for="estado">Estado</label>
            <select name="estado" v-model="formularioCita.estado">
                <option value="pendiente">Pendiente</option>
                <option value="confirmada">Confirmada</option>
                <option value="cancelada">Cancelada</option>
            </select>

            <button type="submit">
                {{ formularioCita.id ? 'Editar' : 'Crear' }}
            </button>
            <button type="button" v-if="formularioCita.id" @click="resetFormCita">Cancelar</button>
        </form>
    </div>
    </div>

    

    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    menu: <?php echo json_encode($menu); ?>,
                    verCat: false,
                    verMed: false,
                    verPed: false,
                    categorias: <?php echo json_encode($categorias); ?>,
                    medicos: <?php echo json_encode($medicos); ?>,
                    pedidos: <?php echo json_encode($pedidos); ?>,
                    formularioCategoria: {
                        id: null,
                        nombre: ''
                    },
                    formularioMedico: {
                        id: null,
                        nombre: '',
                        apellidos: '',
                        telefono: '',
                        especialidad: ''

                    },
                    formularioCita: {
                        id: null,
                        paciente_id: '',
                        medico_id: '',
                        fecha: '',
                        hora: '',
                        estado: 'pendiente'
                    }
                }
            },
            methods: {
                viewMenu(gestion) {
                    switch (gestion) {
                        case 0:
                            this.verCat = true;
                            this.verMed = false;
                            this.verPed = false;
                            break;
                        case 1:
                            this.verMed = true;
                            this.verCat = false;
                            this.verPed = false;
                            break;
                        case 2:
                            this.verPed = true;
                            this.verCat = false;
                            this.verMed = false;
                            break;
                    }
                },
                editarCategoria(cat) {
                    this.formularioCategoria = cat;
                },
                editarMedico(med) {
                    this.formularioMedico = med;
                },
                editarCita(cita) {
                    this.formularioCita = { ...cita };
                },
                resetFormCita() {
                    this.formularioCita = {
                        id: null,
                        paciente_id: '',
                        medico_id: '',
                        fecha: '',
                        hora: '',
                        estado: 'pendiente'
                    };
                }
            }
        }).mount('#menu_admin')
    </script>
</div>