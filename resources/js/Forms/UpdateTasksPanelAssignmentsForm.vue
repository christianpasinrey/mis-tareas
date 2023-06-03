<script setup>
import { useTasksStore } from '../stores/tasks.js';
import { useToast } from 'vue-toast-notification';
import InputLabel from '@/Components/InputLabel.vue';

const tasksStore = useTasksStore();

</script>
<template>
    <form @submit.prevent="tasksStore.updateSelectedPanelAssignments">
        <div class="flex flex-row w-[400px] h-32">
            <div class="flex flex-col w-full px-4 justify-center">
                <InputLabel>Asignar usuarios</InputLabel>
                <v-select
                    :options="tasksStore.users"
                    v-model="tasksStore.selectedPanel.users"
                    multiple
                    :searchable="true"
                    label="label"
                ></v-select>
            </div>
        </div>
        <div class="flex flex-row justify-end py-4 px-4">
            <button type="submit" class="px-2 py-1 rounded-md bg-blue-500 h-fit text-gray-50 hover:scale-105 hover:opacity-85 transition duration-500 ease-in-out">Guardar</button>
        </div>
    </form>
</template>
