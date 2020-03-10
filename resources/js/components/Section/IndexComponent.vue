<template>
    <div>
        <div v-if="!loading && sections.length !== 0">
            <pagination-component :listData="sections" :size="5" :nameComponent="'sectionComponent'"></pagination-component>
        </div>
        <div v-else-if="!loading && sections.length === 0">
            <div  class="col-12 text-xs-center">
                <h1 class="text--primary">У вас нет созданных отделов</h1>
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
        name: "SectionIndexComponent",
        mounted () {
            this.$store.dispatch('fetchSections');
            EventBus.$on('removeSectionEl', (id) => {
                let section = this.sections.findIndex(sec => sec.id === id);
                this.sections.splice(section, 1);
            });
        },
        computed: {
            sections () {
                return this.$store.getters.sections;
            },
            loading () {
                return this.$store.getters.loading;
            }
        }
    }
</script>
