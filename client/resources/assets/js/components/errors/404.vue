<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">404 Not Found</div>

                    <div class="panel-body text-center">
                        <p>Oops. The page you were looking for doesn't exist.</p>

                        <router-link :to="'doodles'">
                            <a>Take me back to the home page</a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
    a {
        font-weight: 600;
    }
</style>
