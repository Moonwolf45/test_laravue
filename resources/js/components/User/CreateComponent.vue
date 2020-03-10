<template>
    <div>
        <div v-if="!loading">
            <form ref="form">
                <div class="form-group">
                    <label for="inputName">Имя</label>
                    <input type="text" class="form-control" id="inputName" :rules="[v => !!v || 'Имя обязательно']"
                        v-model="name" required>
                </div>

                <div class="form-group">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" class="form-control" id="inputEmail" :rules="[v => !!v || 'E-mail обязателен']"
                        v-model="email" required>
                </div>

                <div class="form-group">
                    <label for="inputPassword">Пароль</label>
                    <input type="password" class="form-control" id="inputPassword" :counter="6" :rules="passwordRules"
                        v-model="password" required>
                </div>

                <button class="btn btn-primary"  @click="createUser" :loading="loading" :disabled="loading">Создать</button>
            </form>
        </div>
        <div v-else>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserCreateComponent",
        data () {
            return {
                name: '',
                email: '',
                password: '',
                passwordRules: [
                    v => !!v || 'Пароль обязателен',
                    v => (v && v.length >= 6) || 'Пароль должен быть больше 6 символов'
                ],
            }
        },
        computed: {
            loading () {
                return this.$store.getters.loading
            }
        },
        methods: {
            createUser () {
                if (this.name !== '' && this.email !== '' && this.password !== '') {
                    const user = {
                        name: this.name,
                        email: this.email,
                        password: this.password
                    };

                    this.$store.dispatch('createUser', user).then((response) => {
                        window.location.href = '/user';
                    }).catch(() => {})
                }
            },
        }
    }
</script>

<style scoped>

</style>
