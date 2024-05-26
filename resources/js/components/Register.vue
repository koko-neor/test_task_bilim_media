<template>
    <div>
        <h2>Регистрация</h2>
        <form @submit.prevent="register">
            <input v-model="name" placeholder="Имя" required>
            <input v-model="email" placeholder="Электронная почта" required>
            <input type="password" v-model="password" placeholder="Пароль" required>
            <select v-model="role" required>
                <option value="student">Студент</option>
                <option value="admin">Администратор</option>
            </select>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            role: 'student',
        };
    },
    methods: {
        async register() {
            try {
                await axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role: this.role,
                });
                this.$router.push('/login');
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
