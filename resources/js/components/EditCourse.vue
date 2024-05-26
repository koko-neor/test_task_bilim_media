<template>
    <div v-if="course">
        <h1 class="mb-4">Редактировать курс</h1>
        <form @submit.prevent="updateCourse" class="mb-4">
            <div class="mb-3">
                <input v-model="course.title" class="form-control" placeholder="Название" required>
            </div>
            <div class="mb-3">
                <textarea v-model="course.description" class="form-control" placeholder="Описание" required></textarea>
            </div>
            <div class="mb-3">
                <input v-model="course.category" class="form-control" placeholder="Категория" required>
            </div>
            <button type="submit" class="btn btn-success">Обновить курс</button>
        </form>
        <h2 class="mb-4">Управление уроками</h2>
        <form @submit.prevent="createLesson" class="mb-4">
            <div class="mb-3">
                <input v-model="lessonTitle" class="form-control" placeholder="Название урока" required>
            </div>
            <div class="mb-3">
                <textarea v-model="lessonContent" class="form-control" placeholder="Содержание урока" required></textarea>
            </div>
            <div class="mb-3">
                <input v-model="lessonOrder" type="number" class="form-control" placeholder="Порядок урока" required>
            </div>
            <div class="mb-3">
                <input v-model="lessonVideoUrl" class="form-control" placeholder="URL видео">
            </div>
            <button type="submit" class="btn btn-primary">Добавить урок</button>
        </form>
        <div v-if="course.lessons && course.lessons.length" class="list-group">
            <div class="list-group-item" v-for="lesson in course.lessons" :key="lesson.id">
                <h5>{{ lesson.title }}</h5>
                <p>{{ lesson.content }}</p>
                <p>Порядок: {{ lesson.order }}</p>
                <p v-if="lesson.video_url">
                    <a :href="lesson.video_url" target="_blank" class="btn btn-secondary">Смотреть видео</a>
                </p>
                <button @click="editLesson(lesson)" class="btn btn-warning me-2">Редактировать</button>
                <button @click="deleteLesson(lesson.id)" class="btn btn-danger">Удалить</button>
            </div>
        </div>
        <div v-else>
            <p>Для этого курса нет уроков.</p>
        </div>

        <div class="modal fade" id="editLessonModal" tabindex="-1" aria-labelledby="editLessonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLessonModalLabel">Редактировать урок</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateLesson">
                            <div class="mb-3">
                                <input v-model="editingLesson.title" class="form-control" placeholder="Название урока" required>
                                <div v-if="errors.title" class="text-danger">{{ errors.title[0] }}</div>
                            </div>
                            <div class="mb-3">
                                <textarea v-model="editingLesson.content" class="form-control" placeholder="Содержание урока" required></textarea>
                                <div v-if="errors.content" class="text-danger">{{ errors.content[0] }}</div>
                            </div>
                            <div class="mb-3">
                                <input v-model="editingLesson.order" type="number" class="form-control" placeholder="Порядок урока" required>
                                <div v-if="errors.order" class="text-danger">{{ errors.order[0] }}</div>
                            </div>
                            <div class="mb-3">
                                <input v-model="editingLesson.video_url" class="form-control" placeholder="URL видео">
                                <div v-if="errors.video_url" class="text-danger">{{ errors.video_url[0] }}</div>
                            </div>
                            <button type="submit" class="btn btn-success">Обновить урок</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <p>Загрузка...</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            course: null,
            lessonTitle: '',
            lessonContent: '',
            lessonOrder: '',
            lessonVideoUrl: '',
            editingLesson: {},
            errors: {}
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
            if (!this.course.lessons) {
                this.course.lessons = [];
            }
        } catch (error) {
            console.error('Ошибка загрузки курса:', error);
            this.course = null;
        }
    },
    methods: {
        async updateCourse() {
            try {
                await axios.put(`/api/courses/${this.course.id}`, {
                    title: this.course.title,
                    description: this.course.description,
                    category: this.course.category
                });
                this.$router.push({ name: 'admin-courses' });
            } catch (error) {
                console.error('Ошибка обновления курса:', error);
            }
        },
        async createLesson() {
            try {
                const response = await axios.post(`/api/courses/${this.course.id}/lessons`, {
                    title: this.lessonTitle,
                    content: this.lessonContent,
                    order: this.lessonOrder,
                    video_url: this.lessonVideoUrl
                });
                this.course.lessons.push(response.data);
                this.lessonTitle = '';
                this.lessonContent = '';
                this.lessonOrder = '';
                this.lessonVideoUrl = '';
                this.errors = {};
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error('Ошибка создания урока:', error);
                }
            }
        },
        async deleteLesson(id) {
            try {
                await axios.delete(`/api/lessons/${id}`);
                this.course.lessons = this.course.lessons.filter(lesson => lesson.id !== id);
            } catch (error) {
                console.error('Ошибка удаления урока:', error);
            }
        },
        editLesson(lesson) {
            this.editingLesson = { ...lesson };
            this.errors = {};
            const modal = new bootstrap.Modal(document.getElementById('editLessonModal'));
            modal.show();
        },
        async updateLesson() {
            try {
                await axios.put(`/api/lessons/${this.editingLesson.id}`, this.editingLesson);
                const index = this.course.lessons.findIndex(lesson => lesson.id === this.editingLesson.id);
                if (index !== -1) {
                    this.course.lessons.splice(index, 1, this.editingLesson);
                }
                this.editingLesson = {};
                const modal = bootstrap.Modal.getInstance(document.getElementById('editLessonModal'));
                modal.hide();
                this.errors = {};
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error('Ошибка обновления урока:', error);
                }
            }
        }
    }
};
</script>
