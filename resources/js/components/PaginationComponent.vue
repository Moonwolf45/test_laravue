<template>
    <div>
        <div class="card mb-3" v-if="nameComponent === 'sectionComponent'" v-for="section in paginatedData">
            <section-one-component :dataArray="section"></section-one-component>
        </div>
        <table v-if="nameComponent === 'userComponent'" class="table">
            <tbody v-for="user in paginatedData">
                <user-one-component :dataArray="user"></user-one-component>
            </tbody>
        </table>

        <nav v-if="pageCount > 1">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: pageNumber === 0 }">
                    <a class="page-link" @click="prevPage" tabindex="-1" aria-disabled="true">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item" :class="{ active: index === pageNumber }" v-if="pageCount > 1" v-for="(number, index) in pageCount">
                    <a class="page-link" @click="specificPage(index)">{{ index + 1 }}</a>
                </li>
                <li class="page-item" :class="{ disabled: pageNumber >= pageCount - 1 }">
                    <a class="page-link" @click="nextPage()">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: "PaginationComponent",
        data () {
            return {
                pageNumber: 0
            }
        },
        props: {
            nameComponent: {
                type: String,
                required: true
            },
            listData: {
                type: Array,
                required: true
            },
            size: {
                type: Number,
                required: false,
                default: 5
            }
        },
        methods: {
            nextPage() {
                this.pageNumber++;
            },
            prevPage() {
                this.pageNumber--;
            },
            specificPage(index) {
                this.pageNumber = index;
            }
        },
        computed: {
            pageCount() {
                let l = this.listData.length;
                let s = this.size;

                return Math.ceil(l/s);
            },
            paginatedData() {
                const start = this.pageNumber * this.size;
                const end = start + this.size;

                return this.listData.slice(start, end);
            }
        }
    }
</script>
