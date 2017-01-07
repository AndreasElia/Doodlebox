<template>
    <nav class="text-right">
        <div class="col-xs-12 col-sm-1 form-group" style="margin: 22px 0;">
            <select class="form-control" v-model="pagination_limit">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <ul class="col-xs-12 col-sm-11 pagination">
            <li class="page-item">
                <a class="page-link" v-on:click="iteratePagePrevious" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <li class="page-item" v-for="page in pagination.max" v-bind:class="{ active: page == pagination.page }">
                <a class="page-link" v-on:click="changePage(page)">{{ page }}</a>
            </li>

            <li class="page-item">
                <a class="page-link" v-on:click="iteratePageNext" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        data () {
            return {
                pagination_limit: this.pagination.limit
            }
        },
        props: [
            'pagination'
        ],
        watch: {
            pagination_limit: function () {
                this.pagination.page = 1;

                this.pagination.limit = parseInt(this.pagination_limit);

                this.$parent.fetchData();
            }
        },
        methods: {
            changePage (page) {
                if (page != this.pagination.page) {
                    this.pagination.page = page;

                    this.$parent.fetchData();
                }
            },
            iteratePagePrevious () {
                if (this.pagination.page <= 1) {
                    this.pagination.page = this.pagination.max;
                } else {
                    this.pagination.page = this.pagination.page - 1;
                }

                this.$parent.fetchData();
            },
            iteratePageNext () {
                if (this.pagination.page >= this.pagination.max) {
                    this.pagination.page = 1;
                } else {
                    this.pagination.page = this.pagination.page + 1;
                }

                this.$parent.fetchData();
            }
        }
    }
</script>
