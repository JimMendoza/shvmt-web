<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import ConfirmDialog from 'primevue/confirmdialog';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Toast from 'primevue/toast';
import ToggleSwitch from 'primevue/toggleswitch';
import Toolbar from 'primevue/toolbar';
import { recursosAdmin } from '@/modules/admin/config/recursos';
import { actualizar, crear, eliminar, listar } from '@/modules/admin/servicios/admin.servicio';

const props = defineProps({
    recurso: {
        type: String,
        required: true,
    },
});

const confirm = useConfirm();
const toast = useToast();

const registros = ref([]);
const cargando = ref(false);
const dialogo = ref(false);
const editando = ref(null);
const formulario = reactive({});

const clave = computed(() => props.recurso);
const configuracion = computed(() => recursosAdmin[clave.value]);
const titulo = computed(() => configuracion.value?.titulo ?? 'Administración');

function prepararFormulario(datos = {}) {
    Object.keys(formulario).forEach((campo) => delete formulario[campo]);

    configuracion.value.campos.forEach((campo) => {
        if (campo.tipo === 'booleano') {
            formulario[campo.campo] = Boolean(datos[campo.campo]);
        } else {
            formulario[campo.campo] = datos[campo.campo] ?? null;
        }
    });
}

async function cargar() {
    cargando.value = true;
    try {
        const { data } = await listar(configuracion.value.recurso);
        registros.value = data;
    } finally {
        cargando.value = false;
    }
}

function nuevo() {
    editando.value = null;
    prepararFormulario();
    dialogo.value = true;
}

function editar(registro) {
    editando.value = registro;
    prepararFormulario(registro);
    dialogo.value = true;
}

async function guardar() {
    const datos = { ...formulario };

    if (editando.value) {
        await actualizar(configuracion.value.recurso, editando.value.id, datos);
    } else {
        await crear(configuracion.value.recurso, datos);
    }

    toast.add({ severity: 'success', summary: 'Guardado', life: 2500 });
    dialogo.value = false;
    await cargar();
}

function confirmarEliminacion(registro) {
    confirm.require({
        message: '¿Eliminar este registro?',
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Eliminar',
        rejectLabel: 'Cancelar',
        accept: async () => {
            await eliminar(configuracion.value.recurso, registro.id);
            toast.add({ severity: 'success', summary: 'Eliminado', life: 2500 });
            await cargar();
        },
    });
}

function valor(registro, campo) {
    const dato = registro[campo];

    if (typeof dato === 'boolean') {
        return dato ? 'Sí' : 'No';
    }

    return dato ?? '-';
}

watch(clave, cargar);
onMounted(cargar);
</script>

<template>
    <section v-if="configuracion" class="pagina-crud">
        <Toast />
        <ConfirmDialog />

        <div class="encabezado-pagina">
            <span>Administración</span>
            <h1>{{ titulo }}</h1>
        </div>

        <Card>
            <template #content>
                <Toolbar class="barra-crud">
                    <template #start>
                        <Button label="Nuevo" icon="pi pi-plus" @click="nuevo" />
                    </template>
                    <template #end>
                        <Button label="Actualizar" icon="pi pi-refresh" outlined @click="cargar" />
                    </template>
                </Toolbar>

                <DataTable :value="registros" :loading="cargando" data-key="id" paginator :rows="10">
                    <Column field="id" header="ID" />
                    <Column
                        v-for="columna in configuracion.columnas"
                        :key="columna"
                        :field="columna"
                        :header="columna"
                    >
                        <template #body="{ data }">
                            {{ valor(data, columna) }}
                        </template>
                    </Column>
                    <Column header="Acciones" class="columna-acciones">
                        <template #body="{ data }">
                            <Button icon="pi pi-pencil" text rounded @click="editar(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="confirmarEliminacion(data)" />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog v-model:visible="dialogo" :header="editando ? 'Editar registro' : 'Nuevo registro'" modal class="dialogo-crud">
            <form class="formulario-crud" @submit.prevent="guardar">
                <label v-for="campo in configuracion.campos" :key="campo.campo">
                    <span>{{ campo.etiqueta }}</span>

                    <ToggleSwitch
                        v-if="campo.tipo === 'booleano'"
                        v-model="formulario[campo.campo]"
                    />
                    <InputNumber
                        v-else-if="campo.tipo === 'numero'"
                        v-model="formulario[campo.campo]"
                        input-class="w-full"
                    />
                    <Textarea
                        v-else-if="campo.tipo === 'texto'"
                        v-model="formulario[campo.campo]"
                        rows="4"
                    />
                    <InputText
                        v-else
                        v-model="formulario[campo.campo]"
                    />
                </label>

                <div class="acciones-dialogo">
                    <Button label="Cancelar" text type="button" @click="dialogo = false" />
                    <Button label="Guardar" icon="pi pi-save" type="submit" />
                </div>
            </form>
        </Dialog>
    </section>
</template>
