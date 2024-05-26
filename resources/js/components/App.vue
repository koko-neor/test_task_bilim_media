<template>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Сайт курсов</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Главная</router-link>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <router-link class="nav-link" to="/admin/courses">Управление курсами</router-link>
                        </li>
                        <li class="nav-item" v-if="isLoggedIn">
                            <router-link class="nav-link" to="/my-courses">Мои курсы</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item" v-if="!isLoggedIn">
                            <router-link class="nav-link" to="/register">Регистрация</router-link>
                        </li>
                        <li class="nav-item" v-if="!isLoggedIn">
                            <router-link class="nav-link" to="/login">Войти</router-link>
                        </li>
                        <li class="nav-item" v-if="isLoggedIn">
                            <button class="btn btn-outline-danger" @click="logout">Выйти</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';

export default {
    name: 'App',
    setup() {
        const token = ref(localStorage.getItem('token'));
        const isAdmin = computed(() => {
            const user = JSON.parse(localStorage.getItem('user'));
            return user && user.role === 'admin';
        });
        const isLoggedIn = computed(() => !!token.value);

        const logout = () => {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            token.value = null;
            window.location.href = '/';
        };

        return {
            isAdmin,
            isLoggedIn,
            logout,
        };
    }
};
</script>

<style>
nav {
    margin-bottom: 20px;
}
</style>
