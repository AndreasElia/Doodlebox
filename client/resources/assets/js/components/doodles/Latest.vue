<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Latest Doodles</div>

                    <div class="panel-body">
                        <doodle-preview v-for="doodle in doodles" v-bind:doodle="doodle"></doodle-preview>
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
                doodles: []
            }
        },
        mounted() {
            this.$http.get(
                window.api + '/doodles/latest/4'
            ).then((response) => {
                if (response.data.status == 'success') {
                    var doodles = [];

                    response.data.doodles.forEach(function (doodle, index) {
                        doodle.image = JSON.parse(doodle.image);
                        doodles[index] = doodle;
                    });

                    this.doodles = doodles;
                }

                if (response.data.status == 'error') {
                    this.errors = response.data.errors;
                }
            });
        }
    }
</script>
