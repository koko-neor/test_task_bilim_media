<template>
    <div>
        <h1 class="mb-4">Курсы</h1>
        <form @submit.prevent="searchCourses" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input v-model="searchKeyword" class="form-control" placeholder="Поиск по ключевому слову">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Поиск</button>
                </div>
            </div>
        </form>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col" v-for="course in courses" :key="course.id">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ course.title }}</h5>
                        <p class="card-text">{{ course.description }}</p>
                        <router-link :to="{ name: 'course', params: { id: course.id } }" class="btn btn-primary">Просмотреть курс</router-link>
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
            courses: [],
            searchKeyword: '',
        };
    },
    async created() {
        await this.loadCourses();
    },
    methods: {
        async loadCourses() {
            try {
                const response = await axios.get('/api/courses', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.courses = response.data.data;
            } catch (error) {
                console.error('Ошибка загрузки курсов:', error);
            }
        },
        async searchCourses() {
            try {
                const response = await axios.get('/api/search', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    },
                    params: {
                        keyword: this.searchKeyword
                    }
                });
                this.courses = response.data.data;
            } catch (error) {
                console.error('Ошибка поиска курсов:', error);
            }
        }
    }
};
</script>

<style scoped>
.card {
    margin-bottom: 20px;
}
</style>
