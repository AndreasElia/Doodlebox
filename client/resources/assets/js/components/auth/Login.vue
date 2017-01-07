<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <errors v-bind:errors="errors"></errors>

                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" v-model="form.email">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" v-model="form.password">
                            </div>

                            <input type="submit" value="Login" class="btn btn-default">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import auth from '../auth';

    export default {
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                errors: null
            }
        },
        methods: {
            login() {
                this.$http.post(
                    window.api + '/auth/login',
                    this.form
                ).then((response) => {
                    if (response.data.status == 'success') {
                        localStorage.setItem('access_token', response.data.user.token);

                        Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');

                        this.$root.user = response.data.user;

                        this.$router.push({ name: 'doodles' });
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
