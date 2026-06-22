import { defineStore } from 'pinia';

export const usarSitioStore = defineStore('sitio', {
    state: () => ({
        nombre: 'Festividad del Señor de Huanca VMT',
        lema: 'Fe, tradición y comunidad',
    }),
});
