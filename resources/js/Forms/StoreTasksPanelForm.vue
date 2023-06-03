<script setup>
    import { computed, onBeforeMount,ref } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import { useTasksStore } from '../stores/tasks.js';
    import { createPopper } from '@popperjs/core'

    const emits = defineEmits(['submitted'])
    const tasksStore = useTasksStore();
    const search = ref('');
    const store = ()=>{
        tasksStore.storeNewTasksPanel();
        emits('submitted');
    }
    const withPopper = (dropdownList, component, { width }) => {
      /**
       * We need to explicitly define the dropdown width since
       * it is usually inherited from the parent with CSS.
       */
      dropdownList.style.width = width

      /**
       * Here we position the dropdownList relative to the $refs.toggle Element.
       *
       * The 'offset' modifier aligns the dropdown so that the $refs.toggle and
       * the dropdownList overlap by 1 pixel.
       *
       * The 'toggleClass' modifier adds a 'drop-up' class to the Vue Select
       * wrapper so that we can set some styles for when the dropdown is placed
       * above.
       */
      const popper = createPopper(component.$refs.toggle, dropdownList, {
        placement: this.placement,
        modifiers: [
          {
            name: 'offset',
            options: {
              offset: [0, -1],
            },
          },
          {
            name: 'toggleClass',
            enabled: true,
            phase: 'write',
            fn({ state }) {
              component.$el.classList.toggle(
                'drop-up',
                state.placement === 'top'
              )
            },
          },
        ],
      })

      /**
       * To prevent memory leaks Popper needs to be destroyed.
       * If you return function, it will be called just before dropdown is removed from DOM.
       */
      return () => popper.destroy()
    }
    onBeforeMount(() => {
       tasksStore.getUsers();
    });
</script>
<template>
    <div class="sm:p-2 md:p-4">
        <form @submit.prevent="store">
            <div class="grid grid-cols-12 w-screen md:w-[600px] gap-3">
                <div class="col-span-12 md:col-span-8">
                    <InputLabel>Título</InputLabel>
                    <input type="text" v-model="tasksStore.newPanel.name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="col-span-12 md:col-span-4">
                    <InputLabel>Color</InputLabel>
                    <input type="color" v-model="tasksStore.newPanel.background_color" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                </div>
                <div class="col-span-12">
                    <InputLabel>Descripción</InputLabel>
                    <textarea v-model="tasksStore.newPanel.description" :rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="col-span-12">
                    <InputLabel>Asignar usuarios</InputLabel>
                        <v-select
                            :options="tasksStore.users"
                            v-model="tasksStore.newPanel.users"
                            multiple
                            :searchable="true"
                            :reduce="option => option.id"
                            label="label"
                            :calculate-position="withPopper"
                        ></v-select>
                </div>
                <div class="col-span-12 justify-center text-end content-end items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<style>
.v-select.drop-up.vs--open .vs__dropdown-toggle {
  border-radius: 0 0 4px 4px;
  border-top-color: transparent;
  border-bottom-color: rgba(60, 60, 60, 0.26);
}

[data-popper-placement='top'] {
  border-radius: 4px 4px 0 0;
  border-top-style: solid;
  border-bottom-style: none;
  box-shadow: 0 -3px 6px rgba(0, 0, 0, 0.15);
}
</style>
