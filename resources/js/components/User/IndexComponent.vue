<template>
    <div>
        <div v-if="!loading && users.length !== 0">
            <pagination-component :listData="users" :size="5" :nameComponent="'userComponent'"></pagination-component>
        </div>
        <div v-else-if="!loading && users.length === 0">
            <div  class="col-12 text-xs-center">
                <h1 class="text--primary">У вас нет созданных пользователей</h1>
            </div>
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
    import { EventBus } from '../../app.js';
    export default {
        name: "UserIndexComponent",
        mounted () {
            this.$store.dispatch('fetchUsers');
            EventBus.$on('removeUserEl', (id) => {
                let user = this.users.findIndex(us => us.id === id);
                this.users.splice(user, 1);
            });
        },
        computed: {
            users () {
                return this.$store.getters.users;
            },
            loading () {
                return this.$store.getters.loading;
            }
        }
    }
</script>

<style scoped>

</style>
