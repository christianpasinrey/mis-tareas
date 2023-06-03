<script setup>
    import { computed, onBeforeMount,ref } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import { useTasksStore } from '../stores/tasks.js';

    const props = defineProps({
        userId: {
            type: Number,
            required: true
        },
    })

    const tasksStore = useTasksStore();

    const dragStart = (e) => {
        e.dataTransfer.setData("Text",e.target.attributes.taskId.value);
    }
    const dragging = (e) => {
        e.target.style.opacity = "0.5";
        //animate the element with a slight rotation
        e.target.style.scale = "1.1";
        // light yellow background
        e.target.style.backgroundColor = "#fff3cd";
        e.target.style.color = "#856404";
    }
    const dragEnd = (e) => {
        e.target.style.opacity = "1";
    }
    const onDrop = (e, status) => {
        e.preventDefault();
        document.getElementById(`task-${e.dataTransfer.getData("Text")}`).style.scale = "1";
        let data = JSON.parse(e.dataTransfer.getData("Text"));
        tasksStore.tasks.find(task => task.id === parseInt(data)).status_id = status.id;
        tasksStore.updateTask(tasksStore.tasks.find(task => task.id === parseInt(data)));
    }
    onBeforeMount(() => {
        tasksStore.getUser(props.userId);
        tasksStore.getUsers();
    });
</script>
<template>
    <div v-if="tasksStore.loading" class="dark:text-gray-50">

    </div>
    <div v-else class="dark:text-gray-50 grid grid-cols-12 w-full h-full h-min-64">
        <div class="flex flex-col min-h-[15vh] max-h-full col-span-3 mx-4 rounded-md dark:bg-slate-500 bg-slate-300 px-4 py-2"
            v-for="status in tasksStore.tasksStatuses"
            :key="`status-${status.id}`"
            :dropzone="true"
            @dragover="e => e.preventDefault()"
            @drop="onDrop($event, status)"
            >
            <h3 class="text-xl font-bold"
                >{{ status.name }}</h3>
            <span
                :draggable="true"
                @dragstart="dragStart($event, task)"
                @drag="dragging"
                @dragend="dragEnd"
                v-for="task in tasksStore.tasks.filter(filtered=>filtered.status_id === status.id && filtered.tasks_panel_id === tasksStore.selectedPanel.id)"
                :key="`task-${task.id}`"
                :taskId="task.id"
                :id="`task-${task.id}`"
                class="rounded-md px-2 py-1 my-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-50 cursor-default"
                >{{ task.title }}</span>
        </div>
    </div>
</template>
