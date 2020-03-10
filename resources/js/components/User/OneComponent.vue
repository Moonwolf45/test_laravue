<template>
    <tr>
        <td>{{ dataArray.name }}</td>
        <td>{{ dataArray.email }}</td>
        <td>{{ dataArray.email_verified_at }}</td>
        <td>
            <a :href="'/user/update/' + dataArray.id" class="btn btn-info">Редактировать</a>
            <a @click="deleteUser(dataArray.id)" class="btn btn-danger">Удалить</a>
        </td>
    </tr>
</template>

<script>
    import { EventBus } from "../../app";

    export default {
        name: "UserOneComponent",
        props: {
            dataArray: {
                type: Object,
                required: true
            }
        },
        methods: {
            deleteUser(id) {
                this.$store.dispatch('deleteUser', id).then((response) => {
                    EventBus.$emit('removeUserEl', id);
                }).catch((error) => {});
            }
        }
    }
</script>

<style scoped>

</style>
