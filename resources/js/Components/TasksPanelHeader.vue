<script setup>
import { useTasksStore } from '../stores/tasks.js';
import { useToast } from 'vue-toast-notification';

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
</script>
<template>
    <div class="flex flex-row w-full justify-between items-center gap-3 px-4 py-2">
        <div class="flex flex-wrap gap-3">
            <button v-for="panel in tasksStore.tasksPanels"
                :key="`panel-${panel.id}`"
                :style="{
                    border: `2px solid ${panel.background_color}`,
                    backgroundColor: tasksStore.selectedPanel == panel ? panel.background_color : 'white',
                    borderRadius: '5px',
                    padding: '5px 10px',
                    color: tasksStore.selectedPanel == panel ? 'white' : panel.background_color,
                }"
                @click.prevent="tasksStore.selectedPanel = tasksStore.tasksPanels.find(p => p.id === panel.id)"
            >
                {{ panel.name }}
            </button>
            <button
                title="Añadir tarea al panel actual"
                @click.prevent="checkIfCanAddTaskToPanel"
                class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                Nueva Tarea
            </button>
        </div>
        <button @click.prevent="addPanel"
            class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Añadir panel
        </button>
    </div>
</template>
