<script setup>
    import { useTasksStore } from '../stores/tasks.js';

    const tasksStore = useTasksStore();
    const props = defineProps({
        status: {
            type: Object,
            required: true
        },
    })

    const onDrop = (e) => {
        e.preventDefault();
        document.getElementById(`task-${e.dataTransfer.getData("Text")}`).style.scale = "1";
        let data = JSON.parse(e.dataTransfer.getData("Text"));
        tasksStore.tasks.find(task => task.id === parseInt(data)).status_id = props.status.id;
        tasksStore.updateTask(tasksStore.tasks.find(task => task.id === parseInt(data)));
    }
</script>
<template>
    <div
        class="flex flex-col min-h-[35vh] max-h-full col-span-3 mx-4 rounded-md dark:bg-slate-500 bg-slate-300"
        :dropzone="true"
        @dragover="e => e.preventDefault()"
        @drop="onDrop($event)"
        >
        <div class="flex flex-row justify-center rounded-t-md border-b border-b-white p-2"
            :style="{
                backgroundColor: status.color,
            }"
            >
            <h3 class="text-xl font-bold flex justify-center"
            >{{ status.name }}</h3>
        </div>
        <div class="flex flex-row px-4 py-2 justify-start items-center w-full">
            <div class="flex flex-col w-full gap-0">
                <slot/>
            </div>
        </div>
    </div>
</template>
