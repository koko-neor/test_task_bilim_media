<template>
    <div v-if="course">
        <h1 class="mb-4">{{ course.title }}</h1>
        <p>{{ course.description }}</p>
        <button @click="enroll" class="btn btn-success mb-4">Записаться на курс</button>
        <hr>
        <div class="mb-4">
            <h3>Уроки</h3>
            <div class="list-group">
                <div class="list-group-item" v-for="lesson in course.lessons" :key="lesson.id">
                    <h5>{{ lesson.title }}</h5>
                    <p>{{ lesson.content }}</p>
                    <p v-if="lesson.video_url">
                        <a :href="lesson.video_url" target="_blank" class="btn btn-secondary">Смотреть видео</a>
                    </p>
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
            course: null
        };
    },
    async created() {
        try {
            const response = await axios.get(`/api/courses/${this.$route.params.id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            this.course = response.data.data;
        } catch (error) {
            console.error('Ошибка загрузки курса:', error);
        }
    },
    methods: {
        async enroll() {
            try {
                const response = await axios.post(`/api/courses/${this.course.id}/enroll`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                alert('Вы успешно записались на курс!');
            } catch (error) {
                console.error('Ошибка при записи на курс:', error);
                alert(error.response.data.message || 'Ошибка при записи на курс');
            }
        }
    }
};
</script>
