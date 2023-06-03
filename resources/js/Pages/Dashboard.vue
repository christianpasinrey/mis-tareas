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
const selectedPanel = ref(null);
const tasksStore = useTasksStore();
const selectedModal = ref(null);

const toggleModal = (modal) => {
    if(selectedModal.value === modal){
        selectedModal.value = null;
        return;
    }
    selectedModal.value = modal;
};

const handleNewPanelModal = () => {
    if(selectedModal.value === 'newPanel'){
        toggleModal(null);
        return;
    }
    toggleModal('newPanel');
};
const checkIfCanAddTaskToPanel = () => {
    if (tasksStore.selectedPanel != null) {
        toggleModal('newTask');
    } else {
        toast.info('Debes seleccionar un panel para añadir una tarea');
    }
};
const showModal = (modal) => {
    return selectedModal.value === modal;
};

const addTask = () => {
    tasksStore.addTask();
};

const updateTask = () => {
    tasksStore.updateTask();
};

const deleteTask = () => {
    tasksStore.deleteTask();
};

onBeforeMount(()=>{
    tasksStore.getTasksPanels();
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center content-center align-middle justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Mi panel de tareas</h2>
                <button
                    title="Añadir tarea al panel actual"
                    @click.prevent="checkIfCanAddTaskToPanel"
                    class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                    Nueva Tarea
                </button>
            </div>
        </template>

        <div class="py-12 h-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
                <TasksPanelHeader @toggleModal="toggleModal"/>
                <hr class="my-2">
                <div class="flex flex-row w-full justify-center items-center" v-if="tasksStore.selectedPanel!=null">
                    <TasksPanel :userId="props.user.id"/>
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
    </AuthenticatedLayout>
</template>
