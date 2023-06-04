<script setup>
    import { computed, onBeforeMount,ref } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import DraggableTask from '@/Components/DraggableTask.vue';
    import TasksPanelDroppable from '@/Components/TasksPanelDroppable.vue';
    import { useTasksStore } from '../stores/tasks.js';

    const props = defineProps({
        userId: {
            type: Number,
            required: true
        },
    })

    const tasksStore = useTasksStore();

    const dragging = (e) => {

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
    <div class="dark:text-gray-50 flex flex-wrap gap-3 w-full h-full h-min-64 px-4">
        <TasksPanelDroppable v-for="status in tasksStore.tasksStatuses"
            :key="`status-${status.id}`" :status="status">
            <DraggableTask
                v-for="task in tasksStore.tasks.filter(filtered=>filtered.status_id === status.id && filtered.tasks_panel_id === tasksStore.selectedPanel.id)"
                :key="`task-${task.id}`"
                :task="task"
                :statusId="status.id"
            />
        </TasksPanelDroppable>
    </div>
</template>
