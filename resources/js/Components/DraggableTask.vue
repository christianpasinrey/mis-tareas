<script setup>
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import ModalTitle from '@/Components/ModalTitle.vue';
    import { useTasksStore } from '../stores/tasks.js';
    import InputLabel from '@/Components/InputLabel.vue';

    const tasksStore = useTasksStore();
    const props = defineProps({
        task: {
            type: Object,
            required: true
        },
        statusId: {
            type: Number,
            required: true
        }
    });
    const selectedModal = ref(null);
    const toggleModal = (modal) => {
        selectedModal.value = modal;
    }
    const showModal = (modal) => {
        return selectedModal.value === modal;
    }
    const collapsed = ref(false);
    const dragStart = (e) => {
        collapsed.value = false;
        e.dataTransfer.setData("Text", JSON.stringify(props.task.id));
    }
    const dragging = (e) => {
        e.target.style.opacity = "0.5";
        e.target.style.scale = "1.1";
        e.target.style.backgroundColor = "#fff3cd";
        e.target.style.color = "#856404";
    }
    const dragEnd = (e) => {
        e.target.style.opacity = "1";
    }
    const seeDetails = () => {
        collapsed.value = !collapsed.value;
    }
    const editTask = () => {
        tasksStore.selectedTask = tasksStore.tasks.find(task => task.id === props.task.id);
        toggleModal('edit-task-assignments');
    }
    const updateTaskAssignments = () => {
        tasksStore.updateTask;
        toggleModal(null);
    }
</script>
<template>
    <div
        :draggable="true"
        @dragstart="dragStart($event)"
        @drag="dragging"
        @dragend="dragEnd"
        :key="`task-${task.id}`"
        :taskId="task.id"
        :id="`task-${task.id}`"
        class="flex flex-row mb-2 justify-between w-full px-2 py-1 bg-gray-200 dark:bg-gray-700 dark:text-gray-50 cursor-default transition duration-500 ease-in-out"
        :class="{
            'rounded-md': !collapsed,
            'rounded-t-md': collapsed,
            'hover:bg-slate-600 hover:text-gray-50':statusId === 1,
            'hover:bg-yellow-600 hover:text-gray-50':statusId === 2,
            'hover:bg-green-600 hover:text-gray-50':statusId === 3,
            'hover:bg-red-600 hover:text-gray-50':statusId === 4,
        }"
        >
        <div class="flex flex-row">
            <button @click.prevent="editTask"
                class="text-xs bg-yellow-500 mr-2 hover:opacity-85 text-gray-900 hover:text-gray-50 font-bold p-1 rounded-full border border-slate-200 transition duration-500 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    class="bi bi-people w-4 h-4"
                    viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                </svg>
            </button>
            <span>
                {{ task.title }}
            </span>
        </div>
        <span
            class="cursor-pointer hover:scale-105 text-gray-500 hover:text-gray-400"
            @click="seeDetails">
            <svg v-if="!collapsed" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="bi bi-caret-right w-6 h-6"
            viewBox="0 0 16 16">
                <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                class="bi bi-caret-down w-6 h-6"
                viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
            </svg>
        </span>
    </div>
    <hr class="border-gray-300" v-if="collapsed">
    <div class="flex flex-row justify-between rounded-b-md w-full px-2 py-1 bg-gray-200 dark:bg-gray-700 dark:text-gray-50 cursor-default"
        v-if="collapsed">
        <small class="font-medium indent-4">
            {{ task.description }}
        </small>
    </div>
    <Modal :show="showModal('edit-task-assignments')">
        <ModalTitle title="Asignaciones de tarea" @close="toggleModal(null)"/>
        <form @submit.prevent="updateTaskAssignments">
            <div class="flex flex-row w-min-[400px] px-4 min-h-[200px] max-h-[300px] overflow-auto">
                <div class="flex flex-col w-full py-6">
                    <InputLabel>Asignar usuarios</InputLabel>
                    <v-select
                        :options="tasksStore.users"
                        v-model="tasksStore.selectedPanel.users"
                        multiple
                        :searchable="true"
                        :reduce="option => option.id"
                        label="label"
                        :calculate-position="withPopper"
                    ></v-select>
                </div>
            </div>
            <div class="flex flex-row justify-end px-4 py-2">
                <button type="submit" class="rounded-md px-4 py-2 text-gray-50 bg-blue-500 font-bold hover:scale-105 hover:opacity-85">
                    Guardar
                </button>
            </div>
        </form>
    </Modal>
</template>
