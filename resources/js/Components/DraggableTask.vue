<script setup>
    import { ref } from 'vue';
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
    const collapsed = ref(false);
    const dragStart = (e) => {
        collapsed.value = false;
        e.dataTransfer.setData("Text", JSON.stringify(props.task.id));
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
    const seeDetails = () => {
        collapsed.value = !collapsed.value;
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
        class="flex flex-row justify-between w-full px-2 py-1 bg-gray-200 dark:bg-gray-700 dark:text-gray-50 cursor-default transition duration-500 ease-in-out"
        :class="{
            'rounded-md': !collapsed,
            'rounded-t-md': collapsed,
            'hover:bg-slate-600 hover:text-gray-50':statusId === 1,
            'hover:bg-yellow-600 hover:text-gray-50':statusId === 2,
            'hover:bg-green-600 hover:text-gray-50':statusId === 3,
            'hover:bg-red-600 hover:text-gray-50':statusId === 4,
        }"
        >
        <span>
            {{ task.title }}
        </span>
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
</template>
