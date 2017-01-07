<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Latest Doodles</div>

                    <div class="panel-body">
                        <doodle-preview v-for="doodle in doodles" v-bind:doodle="doodle"></doodle-preview>

                        <paginate v-bind:pagination="pagination" v-show="! loading"></paginate>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                doodles: [],
                pagination: {
                    page: 1,
                    limit: 10,
                    total: 10,
                    max: 5
                }
            }
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData: function () {
                this.doodles = null;
                this.loading = true;

                this.$http.get(window.api + '/doodles/all/' + this.pagination.page + '/' + this.pagination.limit).then((response) => {
                    this.loading = false;

                    if (response.data.status == 'success') {
                        this.doodles = response.data.doodles;

                        this.pagination.total = response.data.count;

                        this.pagination.max = Math.ceil(this.pagination.total / parseInt(this.pagination.limit));
                    }
                });
            },
        }
    }
</script>
