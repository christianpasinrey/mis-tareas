<script setup>
import { useTasksStore } from '../stores/tasks.js';
import { useToast } from 'vue-toast-notification';

const toast = useToast();
const emits = defineEmits(['toggleModal']);
const tasksStore = useTasksStore();

const addPanel = () => {
    emits('toggleModal', 'newPanel');
}
const editPanel = () => {
    emits('toggleModal', 'editPanel');
}
const checkIfCanAddTaskToPanel = () => {
    if (tasksStore.selectedPanel != null) {
        emits('toggleModal','newTask');
        return;
    }
    toast.info('Debes seleccionar un panel para añadir una tarea');
};
function hoverButton(e,panel){
    let element = document.getElementById(`panel-button-${panel.id}`);
    element.style.backgroundColor = panel.background_color;
    element.style.color = 'white';
};
function leaveButton(e,panel){
    let element = document.getElementById(`panel-button-${panel.id}`);
    if(tasksStore.selectedPanel == panel){
        return;
    }
    element.style.backgroundColor = 'white';
    //transform hex color to hsl and if the lightness is more than 50% then the text color is darkgray
    let hsl = hexToHsl(panel.background_color);
    let lightness = hsl.split(',')[2].split('%')[0];
    if(lightness > 50){
        element.style.color = 'darkgray';
        return;
    }
    element.style.color = panel.background_color;
};
const hexToHsl = (hexColor) =>{
    let r = parseInt(hexColor.slice(1, 3), 16),
        g = parseInt(hexColor.slice(3, 5), 16),
        b = parseInt(hexColor.slice(5, 7), 16),
        a = parseInt(hexColor.slice(7, 9), 16) / 255;
    r /= 255, g /= 255, b /= 255;
    let max = Math.max(r, g, b),
        min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;
    if (max == min) {
        h = s = 0;
    }
    else {
        let d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
        case r:
            h = (g - b) / d + (g < b ? 6 : 0);
            break;
        case g:
            h = (b - r) / d + 2;
            break;
        case b:
            h = (r - g) / d + 4;
            break;
        }
        h /= 6;
    }
    s = s * 100;
    s = Math.round(s);
    l = l * 100;
    l = Math.round(l);
    return "hsl(" + h + ", " + s + "%, " + l + "%)";
}
</script>
<template>
    <div class="flex flex-row w-full justify-between items-center gap-3 px-4 py-2">
        <div class="flex flex-wrap gap-3">
            <button v-for="panel in tasksStore.tasksPanels"
                class="hover:scale-105 transition duration-500 ease-in-out relative"
                :key="`panel-${panel.id}`"
                :id="`panel-button-${panel.id}`"
                :style="{
                    border: `2px solid ${panel.background_color}`,
                    backgroundColor: tasksStore.selectedPanel == panel ? panel.background_color : 'white',
                    borderRadius: '5px',
                    padding: '5px 10px',
                    color: tasksStore.selectedPanel == panel ? 'white' : hexToHsl(panel.backgroun_color).split(','[2].split('%')[0]) > 50 ? 'darkgray' : panel.background_color,
                    fontWeight: tasksStore.selectedPanel == panel ? 'bold' : 'normal',
                }"
                @click.prevent="tasksStore.selectedPanel = tasksStore.tasksPanels.find(p => p.id === panel.id)"
                @mouseover="hoverButton($event,panel)"
                @mouseleave="leaveButton($event,panel)"
            >
                {{ panel.name }}
                <button @click.prevent="editPanel" v-if="panel === tasksStore.selectedPanel"
                    class="absolute -bottom-3 -left-3 z-10 text-xs bg-yellow-500 hover:opacity-85 text-gray-900 hover:text-gray-50 font-bold p-1 rounded-full border border-slate-200 transition duration-500 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="bi bi-people w-4 h-4"
                        viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                    </svg>
                </button>
            </button>
            <button @click.prevent="addPanel"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded hover:scale-105 transition duration-500 ease-in-out">
                Añadir panel
            </button>
        </div>
        <button
            title="Añadir tarea al panel actual"
            @click.prevent="checkIfCanAddTaskToPanel"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded hover:scale-105 transition duration-500 ease-in-out">
            Nueva Tarea
        </button>
    </div>
    <div class="flex flex-row my-3 w-[96.5%] justify-between mx-4 px-4 bg-gray-300 rounded-md text-gray-500 hover:text-gray-50 hover:bg-gray-500">
        <div class="flex flex-wrap w-full gap-6 h-fit mx-4 px-4" v-if="tasksStore.selectedPanel!= null">
            <span v-for="user in tasksStore.selectedPanel.users" :key="`panel-user-${user.id}`"
                class="hover:scale-110 transition duration-500 ease-in-out"
            >
                <span class="text-xs font-bold cursor-default"
                    :title="user.alias!= null && user.alias != '' ? user.alias + ' - ' + user.email : user.name + ' - ' + user.email"
                > {{ user.alias!= null && user.alias != '' ? user.alias : user.name }} </span>
            </span>
        </div>
    </div>
</template>
