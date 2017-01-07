<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ (user != null) ? user.first_name : '' }}'s Doodles</div>

                    <div class="panel-body text-center">
                        <doodle-preview v-for="doodle in doodles" v-bind:doodle="doodle"></doodle-preview>

                        <paginate v-bind:pagination="pagination"></paginate>
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
                user: null,
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
                this.user = null;

                this.$http.get(window.api + '/users/doodles/' + this.$route.params.id).then((response) => {
                    if (response.data.status == 'success') {
                        this.user = response.data.user;

                        this.doodles = response.data.user.doodles;
                    }
                });
            },
        }
    }
</script>
