<template>
    <div>
        <h2>Вход</h2>
        <form @submit.prevent="login">
            <input v-model="email" placeholder="Электронная почта" required>
            <input type="password" v-model="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                await axios.get('/sanctum/csrf-cookie');

                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                });
                localStorage.setItem('token', response.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.user));
                this.$router.push('/');
            } catch (error) {
                console.error('Ошибка входа:', error);
            }
        },
    },
};
</script>
