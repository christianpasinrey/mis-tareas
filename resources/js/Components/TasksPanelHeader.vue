<script setup>
import { useTasksStore } from '../stores/tasks.js';

const emits = defineEmits(['toggleModal']);
const tasksStore = useTasksStore();

const addPanel = () => {
    emits('toggleModal', 'newPanel');
}
</script>
<template>
    <div class="flex flex-row w-full justify-between items-center gap-3 px-4 py-2">
        <div class="flex flex-wrap gap-3">
            <button v-for="panel in tasksStore.tasksPanels"
                :key="`panel-${panel.id}`"
                :style="{
                    backgroundColor: panel.background_color ?? 'gray',
                    border: tasksStore.selectedPanel!=null && tasksStore.selectedPanel.id === panel.id ? '1px solid white' : 'none',
                    borderRadius: '5px',
                    padding: '5px 10px',
                    color: 'white',
                }"
                @click.prevent="tasksStore.selectedPanel = tasksStore.tasksPanels.find(p => p.id === panel.id)"
            >
                {{ panel.name }}
            </button>
        </div>
        <button @click.prevent="addPanel"
            class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Añadir panel
        </button>
    </div>
</template>
