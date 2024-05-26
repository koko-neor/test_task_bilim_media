import { createRouter, createWebHistory } from 'vue-router';
import CourseList from '../components/CourseList.vue';
import CourseDetail from '../components/CourseDetail.vue';
import AdminCourses from '../components/AdminCourses.vue';
import EditCourse from '../components/EditCourse.vue';
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import MyCourses from '../components/MyCourses.vue';

const routes = [
    { path: '/', component: CourseList, name: 'home' },
    { path: '/course/:id', component: CourseDetail, name: 'course' },
    { path: '/admin/courses', component: AdminCourses, name: 'admin-courses' },
    { path: '/admin/courses/:id/edit', component: EditCourse, name: 'edit-course' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/my-courses', component: MyCourses, name: 'my-courses' }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if ((to.name === 'admin-courses' || to.name === 'edit-course' || to.name === 'my-courses') && !token) {
        next({ name: 'login' });
    } else {
        next();
    }
});

export default router;
