<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import ModalTitle from '@/Components/ModalTitle.vue';
import { useTasksStore } from '../stores/tasks.js';
import { ref, computed, onBeforeMount } from 'vue';
import TasksPanelHeader from '../Components/TasksPanelHeader.vue';
import StoreTaskForm from '../Forms/StoreTaskForm.vue';
import StoreTasksPanelForm from '../Forms/StoreTasksPanelForm.vue';
import UpdateTasksPanelAssignmentsForm from '../Forms/UpdateTasksPanelAssignmentsForm.vue';
import {usePage} from '@inertiajs/vue3';
import TasksPanel from '../Components/TasksPanel.vue';
import AddIcon from '@/Icons/AddIcon.vue';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const toast = useToast();

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
});

const tasksStore = useTasksStore();
const selectedModal = ref(null);

const toggleModal = (modal) => {
    if(selectedModal.value === modal){
        selectedModal.value = null;
        return;
    }
    selectedModal.value = modal;
};

const showModal = (modal) => {
    return selectedModal.value === modal;
};

onBeforeMount(()=>{
    tasksStore.getUsers();
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 min-h-[80vh]">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-[60vh]">
                <TasksPanelHeader @toggleModal="toggleModal"/>
                <hr class="my-2">
                <div class="flex flex-row w-full justify-center items-start" v-if="tasksStore.selectedPanel!=null">
                    <TasksPanel :userId="props.user.id"/>
                </div>
                <div class="flex flex-row w-full justify-center items-center min-h-[60vh] flex-grow" v-else>
                    <div class="flex flex-col w-full justify-center items-center">
                        <h1 class="text-2xl font-bold text-gray-500">No hay paneles de tareas</h1>
                        <p class="text-gray-500">Crea uno para empezar a trabajar</p>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showModal('newTask')" maxWidth="3xl">
            <ModalTitle title="Nueva tarea" @close="toggleModal(null)"/>
            <StoreTaskForm @submitted="toggleModal(null)"/>
        </Modal>
        <Modal :show="showModal('newPanel')" maxWidth="3xl">
            <ModalTitle title="Nuevo panel de tareas" @close="toggleModal(null)"/>
            <StoreTasksPanelForm @submitted="toggleModal(null)"/>
        </Modal>
        <Modal :show="showModal('editPanel')">
            <ModalTitle @close="toggleModal(null)">
                <h2 class="uppercase">{{ `Asignaciones de tareas ${tasksStore.selectedPanel.name}` }}</h2>
            </ModalTitle>
            <UpdateTasksPanelAssignmentsForm @submitted="toggleModal(null)"/>
        </Modal>
    </AuthenticatedLayout>
</template>
