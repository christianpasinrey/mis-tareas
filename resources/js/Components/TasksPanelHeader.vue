<script setup>
import { useTasksStore } from '../stores/tasks.js';
import { useToast } from 'vue-toast-notification';

const toast = useToast();
const emits = defineEmits(['toggleModal']);
const tasksStore = useTasksStore();

const addPanel = () => {
    emits('toggleModal', 'newPanel');
}
const checkIfCanAddTaskToPanel = () => {
    if (tasksStore.selectedPanel != null) {
        emits('toggleModal','newTask');
    } else {
        toast.info('Debes seleccionar un panel para añadir una tarea');
    }
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
    element.style.color = panel.background_color;
};
</script>
<template>
    <div class="flex flex-row w-full justify-between items-center gap-3 px-4 py-2">
        <div class="flex flex-wrap gap-3">
            <button v-for="panel in tasksStore.tasksPanels"
                class="hover:scale-105 transition duration-500 ease-in-out"
                :key="`panel-${panel.id}`"
                :id="`panel-button-${panel.id}`"
                :style="{
                    border: `2px solid ${panel.background_color}`,
                    backgroundColor: tasksStore.selectedPanel == panel ? panel.background_color : 'white',
                    borderRadius: '5px',
                    padding: '5px 10px',
                    color: tasksStore.selectedPanel == panel ? 'white' : panel.background_color,
                    fontWeight: tasksStore.selectedPanel == panel ? 'bold' : 'normal',
                }"
                @click.prevent="tasksStore.selectedPanel = tasksStore.tasksPanels.find(p => p.id === panel.id)"
                @mouseover="hoverButton($event,panel)"
                @mouseleave="leaveButton($event,panel)"
            >
                {{ panel.name }}
            </button>
            <button
                title="Añadir tarea al panel actual"
                @click.prevent="checkIfCanAddTaskToPanel"
                class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded hover:scale-105 transition duration-500 ease-in-out">
                Nueva Tarea
            </button>
        </div>
        <button @click.prevent="addPanel"
            class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Añadir panel
        </button>
    </div>
</template>
