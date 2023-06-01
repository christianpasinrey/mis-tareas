<script setup>
    const props = defineProps({
        position:{
            type: String,
            default: 'top-right'
        },
        title: {
            type: String,
            default: null
        },
        message: {
            type: String,
            default: null
        },
        type: {
            type: String,
            default: 'success'
        },
    });

    const emit = defineEmits(['close']);
</script>

<template>
    <div class="absolute font-medium text-sm py-2 px-4 rounded shadow-xl"
        :class="{
            'top-0 right-0': props.position == 'top-right',
            'top-0 left-0': props.position == 'top-left',
            'bottom-0 right-0': props.position == 'bottom-right',
            'bottom-0 left-0': props.position == 'bottom-left',
            'bg-green-500': props.type == 'success',
            'bg-red-500': props.type == 'error',
            'bg-yellow-500': props.type == 'warning',
            'bg-blue-500': props.type == 'info',
            'text-gray-50': props.type == 'success',
            'text-gray-50': props.type == 'error',
            'text-gray-900': props.type == 'warning',
            'text-gray-50': props.type == 'info',
        }"
        >
        <div class="flex flex-row relative">
            {{ props.message }}
            <span class="hover:scale-105 absolute top-1 right-1"
                :class="{
                     'text-gray-50': props.type == 'success',
                    'text-gray-50': props.type == 'error',
                    'text-gray-900': props.type == 'warning',
                    'text-gray-50': props.type == 'info',
                }"
            >
                &times;
            </span>
        </div>

    </div>
</template>
