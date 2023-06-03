<script setup>
    import { computed, onBeforeMount,ref } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import { useTasksStore } from '../stores/tasks.js';

    const emits = defineEmits(['submitted'])
    const tasksStore = useTasksStore();
    const search = ref('');
    const store = ()=>{
        tasksStore.storeNewTasksPanel();
        emits('submitted');
    }
    onBeforeMount(() => {
       tasksStore.getUsers();
    });
</script>
<template>
    <div class="sm:p-2 md:p-4">
        <form @submit.prevent="store">
            <div class="grid grid-cols-12 w-screen md:w-[600px] gap-3">
                <div class="col-span-12 md:col-span-8">
                    <InputLabel>Título</InputLabel>
                    <input type="text" v-model="tasksStore.newPanel.name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="col-span-12 md:col-span-4">
                    <InputLabel>Color</InputLabel>
                    <input type="color" v-model="tasksStore.newPanel.background_color" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                </div>
                <div class="col-span-12">
                    <InputLabel>Descripción</InputLabel>
                    <textarea v-model="tasksStore.newPanel.description" :rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="col-span-12 relative h-12">
                    <InputLabel>Asignar usuarios</InputLabel>
                        <v-select
                            :options="tasksStore.users"
                            v-model="tasksStore.newPanel.users"
                            multiple
                            :searchable="true"
                            :reduce="option => option.id"
                            label="label"
                        ></v-select>
                </div>
                <div class="col-span-12 justify-center text-end content-end items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
