import {defineStore} from 'pinia'
import {ref} from 'vue'
import axios from 'axios'

export const useTasksStore = defineStore('tasks', ()=>{
    const tasks = ref([]);
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

    const getUser = async (id) => {
        axios.get(route('users.show',id))
        .then(response => {
            user.value = response.data;
        }).then(()=>{
            getTasks();
        }).catch(error => {
            console.log(error);
        })
    }

    const getUsers = async () => {
        const response = await axios.get(route('users.index'));
        users.value = response.data;
    }

    const getTasks = async () => {
        const response = await axios.get(route('users.tasks',user.value.id));
        tasks.value = response.data;
    }

    const storeTask = async (task) => {
        axios.post(route('tasks.store'),newTask.value)
        .then(response => {
            newTask.value = {
                user_id: null,
                title: '',
                description: '',
                status: 1,
                users: []
            };
            tasks.value.push(response.data);
        }).catch(error => {
            console.log(error);
        });
    }

    const updateTask = async (task) => {
        const response = await axios.put(route('tasks.update',task.id),task);
        tasks.value = tasks.value.map(t => t.id === task.id ? response.data : t);
    }

    const deleteTask = async (id) => {
        await axios.delete(route('tasks.destroy',id));
        tasks.value = tasks.value.filter(task => task.id !== id);
    }
    return {
        tasks,
        user,
        users,
        newTask,
        getUser,
        getUsers,
        getTasks,
        storeTask,
        updateTask,
        deleteTask
    };
});
