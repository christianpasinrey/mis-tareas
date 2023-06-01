<script setup>
    const props = defineProps({
        title: {
            type: String,
            default: null
        },
        classes: {
            type: String,
            default: null
        }
    });
    const emit = defineEmits(['close']);
</script>
<template>
    <div class="flex flex-row justify-between py-2 px-2">
       <div class="flex flex-col justify-center pl-2">
            <div class="flex flex-row">
                <h2 v-if="props.title" :class="{
                        'font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight uppercase': !props.classes,
                        [props.classes]: props.classes
                    }">
                    {{ title }}
                </h2>
            </div>
       </div>
       <div class="flex flex-col justify-center">
            <span @click.prevent="emit('close')"
                class="cursor-pointer hover:opacity-75 hover:scale-105 transform transition-all duration-500 ease-in-out dark:text-gray-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    class="bi bi-x-square w-8 h-8"
                    viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </span>
        </div>
    </div>
</template>
