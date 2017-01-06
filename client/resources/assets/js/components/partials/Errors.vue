<template>
    <div class="alert alert-danger" v-show="errors">
        <ul>
            <li v-for="error in errors">
                {{ error[0] }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: [
            'errors'
        ]
    }
</script>
