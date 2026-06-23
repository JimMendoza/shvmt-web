<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import Tab from 'primevue/tab';
import TabList from 'primevue/tablist';
import TabPanel from 'primevue/tabpanel';
import TabPanels from 'primevue/tabpanels';
import Tabs from 'primevue/tabs';
import Toast from 'primevue/toast';
import ToggleSwitch from 'primevue/toggleswitch';
import { actualizar, asignarPermisos, asignarRoles, crear, listar } from '@/modules/admin/servicios/admin.servicio';

const toast = useToast();

const usuarios = ref([]);
const roles = ref([]);
const permisos = ref([]);
const dialogoUsuario = ref(false);
const dialogoRol = ref(false);
const usuarioEditando = ref(null);
const rolEditando = ref(null);

const formularioUsuario = reactive({
    nombre: '',
    correo: '',
    contrasena: '',
    activo: true,
    debe_cambiar_contrasena: true,
    roles: [],
});

const formularioRol = reactive({
    nombre: '',
    descripcion: '',
    activo: true,
    permisos: [],
});

async function cargar() {
    const [usuariosRespuesta, rolesRespuesta, permisosRespuesta] = await Promise.all([
        listar('usuarios'),
        listar('roles'),
        listar('permisos'),
    ]);

    usuarios.value = usuariosRespuesta.data;
    roles.value = rolesRespuesta.data;
    permisos.value = permisosRespuesta.data;
}

function nuevoUsuario() {
    usuarioEditando.value = null;
    Object.assign(formularioUsuario, {
        nombre: '',
        correo: '',
        contrasena: '',
        activo: true,
        debe_cambiar_contrasena: true,
        roles: [],
    });
    dialogoUsuario.value = true;
}

function editarUsuario(usuario) {
    usuarioEditando.value = usuario;
    Object.assign(formularioUsuario, {
        nombre: usuario.nombre,
        correo: usuario.correo,
        contrasena: '',
        activo: usuario.activo,
        debe_cambiar_contrasena: usuario.debe_cambiar_contrasena,
        roles: usuario.roles?.map((rol) => rol.id) ?? [],
    });
    dialogoUsuario.value = true;
}

async function guardarUsuario() {
    const datos = { ...formularioUsuario };

    if (usuarioEditando.value) {
        await actualizar('usuarios', usuarioEditando.value.id, datos);
        await asignarRoles(usuarioEditando.value.id, datos.roles);
    } else {
        await crear('usuarios', datos);
    }

    toast.add({ severity: 'success', summary: 'Usuario guardado', life: 2500 });
    dialogoUsuario.value = false;
    await cargar();
}

function nuevoRol() {
    rolEditando.value = null;
    Object.assign(formularioRol, {
        nombre: '',
        descripcion: '',
        activo: true,
        permisos: [],
    });
    dialogoRol.value = true;
}

function editarRol(rol) {
    rolEditando.value = rol;
    Object.assign(formularioRol, {
        nombre: rol.nombre,
        descripcion: rol.descripcion,
        activo: rol.activo,
        permisos: rol.permisos?.map((permiso) => permiso.id) ?? [],
    });
    dialogoRol.value = true;
}

async function guardarRol() {
    const datos = { ...formularioRol };

    if (rolEditando.value) {
        await actualizar('roles', rolEditando.value.id, datos);
        await asignarPermisos(rolEditando.value.id, datos.permisos);
    } else {
        await crear('roles', datos);
    }

    toast.add({ severity: 'success', summary: 'Rol guardado', life: 2500 });
    dialogoRol.value = false;
    await cargar();
}

onMounted(cargar);
</script>

<template>
    <section class="pagina-seguridad">
        <Toast />

        <div class="encabezado-pagina">
            <span>Administración</span>
            <h1>Seguridad</h1>
        </div>

        <Tabs value="usuarios">
            <TabList>
                <Tab value="usuarios">Usuarios</Tab>
                <Tab value="roles">Roles y permisos</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="usuarios">
                    <Card>
                        <template #content>
                            <div class="acciones-tabla">
                                <Button label="Nuevo usuario" icon="pi pi-plus" @click="nuevoUsuario" />
                            </div>
                            <DataTable :value="usuarios" data-key="id" paginator :rows="10">
                                <Column field="nombre" header="Nombre" />
                                <Column field="correo" header="Correo" />
                                <Column header="Roles">
                                    <template #body="{ data }">
                                        {{ data.roles?.map((rol) => rol.nombre).join(', ') || '-' }}
                                    </template>
                                </Column>
                                <Column field="activo" header="Activo">
                                    <template #body="{ data }">{{ data.activo ? 'Sí' : 'No' }}</template>
                                </Column>
                                <Column header="Acciones">
                                    <template #body="{ data }">
                                        <Button icon="pi pi-pencil" text rounded @click="editarUsuario(data)" />
                                    </template>
                                </Column>
                            </DataTable>
                        </template>
                    </Card>
                </TabPanel>

                <TabPanel value="roles">
                    <Card>
                        <template #content>
                            <div class="acciones-tabla">
                                <Button label="Nuevo rol" icon="pi pi-plus" @click="nuevoRol" />
                            </div>
                            <DataTable :value="roles" data-key="id" paginator :rows="10">
                                <Column field="nombre" header="Rol" />
                                <Column field="descripcion" header="Descripción" />
                                <Column header="Permisos">
                                    <template #body="{ data }">
                                        {{ data.permisos?.length ?? 0 }}
                                    </template>
                                </Column>
                                <Column field="activo" header="Activo">
                                    <template #body="{ data }">{{ data.activo ? 'Sí' : 'No' }}</template>
                                </Column>
                                <Column header="Acciones">
                                    <template #body="{ data }">
                                        <Button icon="pi pi-pencil" text rounded @click="editarRol(data)" />
                                    </template>
                                </Column>
                            </DataTable>
                        </template>
                    </Card>
                </TabPanel>
            </TabPanels>
        </Tabs>

        <Dialog v-model:visible="dialogoUsuario" modal header="Usuario" class="dialogo-crud">
            <form class="formulario-crud" @submit.prevent="guardarUsuario">
                <label><span>Nombre</span><InputText v-model="formularioUsuario.nombre" /></label>
                <label><span>Correo</span><InputText v-model="formularioUsuario.correo" /></label>
                <label><span>Contraseña</span><Password v-model="formularioUsuario.contrasena" toggle-mask :feedback="false" /></label>
                <label><span>Roles</span><MultiSelect v-model="formularioUsuario.roles" :options="roles" option-label="nombre" option-value="id" /></label>
                <label class="campo-inline"><span>Activo</span><ToggleSwitch v-model="formularioUsuario.activo" /></label>
                <label class="campo-inline"><span>Cambiar contraseña</span><ToggleSwitch v-model="formularioUsuario.debe_cambiar_contrasena" /></label>
                <div class="acciones-dialogo">
                    <Button label="Cancelar" text type="button" @click="dialogoUsuario = false" />
                    <Button label="Guardar" icon="pi pi-save" type="submit" />
                </div>
            </form>
        </Dialog>

        <Dialog v-model:visible="dialogoRol" modal header="Rol" class="dialogo-crud">
            <form class="formulario-crud" @submit.prevent="guardarRol">
                <label><span>Nombre</span><InputText v-model="formularioRol.nombre" /></label>
                <label><span>Descripción</span><InputText v-model="formularioRol.descripcion" /></label>
                <label><span>Permisos</span><MultiSelect v-model="formularioRol.permisos" :options="permisos" option-label="nombre" option-value="id" filter /></label>
                <label class="campo-inline"><span>Activo</span><ToggleSwitch v-model="formularioRol.activo" /></label>
                <div class="acciones-dialogo">
                    <Button label="Cancelar" text type="button" @click="dialogoRol = false" />
                    <Button label="Guardar" icon="pi pi-save" type="submit" />
                </div>
            </form>
        </Dialog>
    </section>
</template>
