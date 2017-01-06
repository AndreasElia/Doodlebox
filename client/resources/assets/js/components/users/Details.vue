<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">My Details</div>

                    <div class="panel-body">
                        <errors v-bind:errors="errors"></errors>

                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="first_name">First name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" v-model="form.first_name">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" v-model="form.last_name">
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" v-model="form.password">
                            </div>


                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" v-model="form.password_confirmation">
                            </div>

                            <input type="submit" value="Update" class="btn btn-default">
                        </form>
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
                form: {
                    first_name: null,
                    last_name: null,
                    password: null,
                    password_confirmation: null
                },
                errors: null
            }
        },
        mounted() {
            this.form.first_name = this.$root.user.first_name;
            this.form.last_name = this.$root.user.last_name;
        },
        methods: {
            submit() {
                this.$http.put(
                    window.api + '/users/details',
                    this.form
                ).then((response) => {
                    if (response.data.status == 'success') {
                        this.$root.user.first_name = response.data.user.first_name;
                        this.$root.user.last_name = response.data.user.last_name;

                        this.$router.push({ name: 'home' });
                    }

                    if (response.data.status == 'error') {
                        this.errors = response.data.errors;
                    }
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    .btn {
        width: 100%;
    }
</style>
