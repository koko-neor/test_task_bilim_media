<template>
    <div>
        <h1 class="mb-4">Мои курсы</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col" v-for="course in myCourses" :key="course.id">
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
            myCourses: []
        };
    },
    async created() {
        try {
            const response = await axios.get('/api/my-courses', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            this.myCourses = response.data;
        } catch (error) {
            console.error('Ошибка загрузки моих курсов:', error);
        }
    }
};
</script>

<style scoped>
.card {
    margin-bottom: 20px;
}
</style>
