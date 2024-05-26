<template>
    <div>
        <h1 class="mb-4">Управление курсами</h1>
        <form @submit.prevent="createCourse" class="mb-4">
            <div class="mb-3">
                <input v-model="title" class="form-control" placeholder="Название" required>
            </div>
            <div class="mb-3">
                <textarea v-model="description" class="form-control" placeholder="Описание" required></textarea>
            </div>
            <div class="mb-3">
                <input v-model="category" class="form-control" placeholder="Категория" required>
            </div>
            <button type="submit" class="btn btn-success">Создать курс</button>
        </form>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col" v-for="course in courses" :key="course.id">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ course.title }}</h5>
                        <p class="card-text">{{ course.description }}</p>
                        <p>Категория: {{ course.category }}</p>
                        <button @click="deleteCourse(course.id)" class="btn btn-danger">Удалить</button>
                        <router-link :to="{ name: 'edit-course', params: { id: course.id } }" class="btn btn-warning">Редактировать</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            title: '',
            description: '',
            category: '',
            courses: []
        };
    },
    async created() {
        const response = await axios.get('/api/courses');
        this.courses = response.data.data;
    },
    methods: {
        async createCourse() {
            const response = await axios.post('/api/courses', {
                title: this.title,
                description: this.description,
                category: this.category
            });
            this.courses.push(response.data.data);
            this.title = '';
            this.description = '';
            this.category = '';
        },
        async deleteCourse(id) {
            await axios.delete(`/api/courses/${id}`);
            this.courses = this.courses.filter(course => course.id !== id);
        }
    }
};
</script>
