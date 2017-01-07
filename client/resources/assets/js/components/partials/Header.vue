<template>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <router-link :to="{ name: 'home' }">
                            <a class="navbar-brand">Doodlebox</a>
                        </router-link>
                    </div>

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <router-link tag="li" :to="{ name: 'login' }" v-if="! this.$root.user">
                                <a>Login</a>
                            </router-link>

                            <router-link tag="li" :to="{ name: 'register' }" v-if="! this.$root.user">
                                <a>Register</a>
                            </router-link>

                            <router-link tag="li" :to="{ name: 'doodles' }" v-if="this.$root.user" exact>
                                <a>Doodles</a>
                            </router-link>

                            <router-link tag="li" :to="{ name: 'create-doodle' }" v-if="this.$root.user" exact>
                                <a>Create a Doodle</a>
                            </router-link>

                            <router-link tag="li" :to="{ name: 'details' }" v-if="this.$root.user" exact>
                                <a>My Details</a>
                            </router-link>

                            <li v-if="this.$root.user">
                                <a v-on:click="this.$root.logout" style="cursor: pointer;">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
