<template>
    <div>
        <div v-if="!loading">
            <form ref="form" v-model="valid">
                <div class="form-group">
                    <label for="inputName">Имя</label>
                    <input type="text" class="form-control" id="inputName" :rules="[v => !!v || 'Title is required']" v-model="name" required>
                </div>

                <div class="form-group">
                    <label for="inputDescription">Описание</label>
                    <textarea class="form-control" id="inputDescription" v-model="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="inputDescription">Лого</label>

                    <div class="preview">
                        <img :src="imageSrc" height="100" alt="" v-if="imageSrc" class="img-thumbnail rounded">
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFile" accept="image/*" @change="onFileChange">
                        <label class="custom-file-label" for="inputFile" @click="triggerUpload">Choose file...</label>
                    </div>
                </div>

                <div>
                    <h3>Пользователи</h3>
                    <div class="form-group">
                        <div class="form-check" v-for="(user, key) in users">
                            <input class="form-check-input" type="checkbox" :id="'user_' + key" :value="user.id" v-model="userArr">
                            <label class="form-check-label">
                                {{ user.name }} ({{ user.email }})
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <button class="btn btn-primary"  @click="createSection" :loading="loading" :disabled="!valid || loading">Создать</button>
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
        name: "SectionCreateComponent",
        data () {
            return {
                name: '',
                description: '',
                image: null,
                imageSrc: '',
                userArr: [],
                valid: false,
            }
        },
        mounted () {
            this.$store.dispatch('fetchUsers');
        },
        computed: {
            users () {
                return this.$store.getters.users;
            },
            loading () {
                return this.$store.getters.loading
            }
        },
        methods: {
            createSection () {
                if (this.$refs.form.validate()) {
                    const section = {
                        name: this.name,
                        description: this.description,
                        image: this.image,
                        users: this.userArr
                    };

                    this.$store.dispatch('createSection', section).then((response) => {
                        window.location.href = '/section';
                    }).catch(() => {})
                }
            },
            triggerUpload () {
                this.$refs.fileInput.click();
            },
            onFileChange (event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = e => {
                    this.imageSrc = reader.result;
                };
                reader.readAsDataURL(file);
                this.image = file;
            }
        }
    }
</script>
