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
                        v-model="password">
                </div>

                <button class="btn btn-primary"  @click="updateUser" :loading="loading" :disabled="loading">Создать</button>
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
        name: "UserUpdateComponent",
        props: ['user_id'],
        data () {
            return {
                id: '',
                name: '',
                email: '',
                password: '',
                passwordRules: [
                    v => (v && v.length >= 6) || 'Пароль должен быть больше 6 символов'
                ],
            }
        },
        computed: {
            user () {
                axios.get('/api/user/' + this.user_id).then((response) => {
                    let get_user = response.data.user;
                    if (get_user) {
                        this.id = get_user.id;
                        this.name = get_user.name;
                        this.email = get_user.email;
                    }

                }).catch(error => {
                    throw error;
                });
            },
            loading () {
                return this.$store.getters.loading
            }
        },
        methods: {
            updateUser () {
                if (this.name !== '' && this.email !== '') {
                    const user = {
                        id: this.id,
                        name: this.name,
                        email: this.email,
                        password: this.password
                    };

                    this.$store.dispatch('updateUser', user).then((response) => {
                        window.location.href = '/user';
                    }).catch(() => {})
                }
            },
        }
    }
</script>

<style scoped>

</style>
