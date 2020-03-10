<template>
    <div class="row no-gutters">
        <div class="col-md-2 item-center">
            <img v-if="dataArray.logo != 0" :src="dataArray.logo" class="card-img" alt="">
            <img v-else :src="'/logo/placeHolder.png'" class="card-img" alt="">
        </div>
        <div class="col-md-5">
            <div class="card-body">
                <h5 class="card-title">{{ dataArray.name }}</h5>
                <p class="card-text">{{ dataArray.description }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-body">
                <h5 class="card-title">Пользователи</h5>
                <p v-if="dataArray.users.length !== 0" v-for="(user, key) in dataArray.users" class="card-text">
                    {{ key+1 }}. {{ user.name }}
                </p>
                <p v-if="dataArray.users.length === 0" class="card-text">Нет привязанных пользоателей</p>
            </div>
        </div>
        <div class="col-md-2 item-center">
            <a :href="'/section/update/' + dataArray.id" class="btn btn-info">Редактировать</a>
            <a @click="deleteSection(dataArray.id)" class="btn btn-danger">Удалить</a>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../../app.js';
    export default {
        name: "SectionOneComponent",
        props: {
            dataArray: {
                type: Object,
                required: true
            }
        },
        methods: {
            deleteSection(id) {
                this.$store.dispatch('deleteSection', id).then((response) => {
                    EventBus.$emit('removeSectionEl', id);
                }).catch((error) => {});
            }
        }
    }
</script>

<style scoped>
    .card-text {
        margin-bottom: 0;
    }
</style>
