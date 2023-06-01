<script setup>
    import { onBeforeMount } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import { useTasksStore } from '../stores/tasks.js';

    const tasksStore = useTasksStore();
    onBeforeMount(() => {
       tasksStore.getUsers();
    });
</script>
<template>
    <div class="sm:p-2 md:p-4">
        <form @submit.prevent="tasksStore.storeTask">
            <div class="grid grid-cols-12 w-screen md:w-[600px] gap-3">
                <div class="col-span-12 md:col-span-8">
                    <InputLabel>Título</InputLabel>
                    <input type="text" v-model="tasksStore.newTask.title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="col-span-12 md:col-span-4">
                    <InputLabel>Fecha límite</InputLabel>
                    <input type="date" v-model="tasksStore.newTask.due_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="col-span-12">
                    <InputLabel>Descripción</InputLabel>
                    <textarea v-model="tasksStore.newTask.description" :rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="col-span-12">
                    <InputLabel>Asignar usuarios</InputLabel>
                    <multiselect
                        v-model="tasksStore.newTask.users"
                        :options="tasksStore.users"
                        :multiple="true"
                        placeholder="Selecciona usuarios para asignar a la tarea"
                        label="label"
                        track-by="label"
                    />
                </div>
                <div class="col-span-12 justify-center text-end content-end items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded" @click.prevent="addTask()">
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
