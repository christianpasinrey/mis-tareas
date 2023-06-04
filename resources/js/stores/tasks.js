import {defineStore} from 'pinia'
import {ref} from 'vue'
import axios from 'axios'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const toast = useToast();
export const useTasksStore = defineStore('tasks', ()=>{
    const tasks = ref([]);
    const assignedTasks = ref([]);
    const tasksStatuses = ref([]);
    const tasksPanels = ref([]);
    const selectedPanel = ref(null);
    const selectedTask = ref(null);
    const user = ref(null);
    const users = ref([]);
    const newTask = ref({
        user_id: null,
        title: '',
        description: '',
        due_date: '',
        status: 1,
        users: []
    });
    const newPanel = ref({
        name: '',
        description: '',
        users: []
    });

    const loading = ref(true);
    const getUser = async (id) => {
        axios.get(route('users.show',id))
        .then(response => {
            user.value = response.data;
        }).then(()=>{
            getTasks();
            getTasksPanels();
        }).catch(error => {
            console.log(error);
        })
    }

    async function getUsers(){
        const response = await axios.get(route('users.index'));
        users.value = response.data;
    }
    const getTasksPanels = () => {
        axios.get(route('tasks_panels.index'))
        .then(response => {
            tasksPanels.value = response.data.filter((panel)=>panel.user_id === user.value.id);
            loading.value = false;
        }).catch(error => {
            console.log(error);
        });
    }
    const getTasks = () => {
        loading.value = true;
        getTasksStatuses();
        axios.get(route('users.tasks',user.value.id))
        .then(response => {
            tasks.value = response.data.filter(task => task.user_id === user.value.id);
            assignedTasks.value = response.data.filter(task => task.users.some(u => u.id === user.value.id));
        }).then(()=>{
            loading.value = false;
        }).catch(error => {
            console.log(error);
        });
    }
    const getTasksStatuses = () => {
        axios.get(route('tasks_statuses.index'))
        .then(response => {
            tasksStatuses.value = response.data;
        }).catch(error => {
            console.log(error);
        });
    }
    const storeTask = async () => {
        axios.post(route('tasks.store'),newTask.value)
        .then(response => {
            newTask.value = {
                user_id: null,
                title: '',
                description: '',
                status: 1,
                users: []
            };
            tasks.value.push(response.data.task);
            toast.success('Tarea creada correctamente');
        }).catch(error => {
            console.log(error);
        });
    }

    const storeNewTasksPanel = async () => {
        axios.post(route('tasks_panels.store'),newPanel.value)
        .then(response => {
            tasksPanels.value.push(response.data.tasksPanel);
            newPanel.value = {
                name: '',
                background_color: '',
                description: '',
                users: []
            };
            toast.success('Panel creado correctamente');
        }).catch(error => {
            console.log(error);
        });
    }
    const updateSelectedPanelAssignments = () => {
        axios.post(route('tasks_panels.update_assignments',selectedPanel.value.id),{users: selectedPanel.value.users.map(u => u.id)})
        .then(response => {
            tasksPanels.value.find(p => p.id === response.data.id).users = response.data.users;
            toast.success('Panel actualizado correctamente');
        }).catch(error => {
            console.log(error);
        });
    }
    const updateTask = () => {
        let task = selectedTask.value;
        task.users = selectedTask.value.users.map(u => u.id);
        axios.put(route('tasks.update',task.id),task)
        .then(response => {
            tasks.value.find(t=>selectedTask.value.id === t.id).users = response.data.task.users;
            toast.success('Tarea actualizada correctamente');
        }).catch(error => {
            console.log(error);
        });
    }

    const deleteTask = async (id) => {
        await axios.delete(route('tasks.destroy',id));
        tasks.value = tasks.value.filter(task => task.id !== id);
    }
    return {
        tasks,
        tasksPanels,
        newPanel,
        selectedPanel,
        selectedTask,
        assignedTasks,
        tasksStatuses,
        user,
        users,
        newTask,
        loading,
        getUser,
        getUsers,
        getTasks,
        getTasksPanels,
        getTasksStatuses,
        storeTask,
        storeNewTasksPanel,
        updateSelectedPanelAssignments,
        updateTask,
        deleteTask,
    };
});
