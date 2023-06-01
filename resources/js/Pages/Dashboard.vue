<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import ModalTitle from '@/Components/ModalTitle.vue';
import ToastNotification from '@/Components/ToastNotification.vue';
import { useTasksStore } from '../stores/tasks.js';
import { ref, computed, onBeforeMount } from 'vue';
import StoreTaskForm from '../Forms/StoreTaskForm.vue';
import {usePage} from '@inertiajs/vue3';

const { props } = usePage().props;
const tasksStore = useTasksStore();
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success');
const selectedModal = ref(null);

const toggleModal = (modal) => {
    selectedModal.value = modal;
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

onBeforeMount(() => {
    console.log(props);
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center content-center align-middle justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Mi panel de tareas</h2>
                <button
                    @click.prevent="toggleModal('newTask')"
                    class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                    Nueva Tarea
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            </div>
        </div>
        <Modal :show="true" maxWidth="3xl">
            <ModalTitle title="Nueva tarea" @close="toggleModal(null)"/>
            <StoreTaskForm @submitted="toggleModal(null)"/>
        </Modal>
        <ToastNotification v-if="showToast" :message="toastMessage" :type="toastType" @close="showToast = false" />
    </AuthenticatedLayout>
</template>
