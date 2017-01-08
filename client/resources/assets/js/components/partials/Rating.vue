<template>
    <div class="star-rating">
        <label class="star" v-for="rating in ratings" v-bind:class="{ 'is-selected': (value >= rating && value != null), 'is-disabled': disabled }" @click="set(rating)" v-on:mouseover="star_over(rating)" v-on:mouseout="star_out">

        <input class="star-rating star-rating-checkbox" type="radio" :value="rating" v-model="value" :disabled="disabled">★</label>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                temp_value: null,
                ratings: [1, 2, 3, 4, 5],
                form: {
                    doodle_id: null,
                    rating: null
                }
            }
        },
        props: {
            'doodle': null,
            'name': String,
            'value': null,
            'id': String,
            'disabled': Boolean,
            'required': Boolean
        },
        methods: {
            star_over: function (index) {
                var self = this;

                if (! this.disabled) {
                    this.temp_value = this.value;
                    return this.value = index;
                }
            },
            star_out: function () {
                var self = this;

                if (! this.disabled) {
                    return this.value = this.temp_value;
                }
            },
            set: function (value) {
                var self = this;

                if (! this.disabled) {
                    this.form.doodle_id = this.doodle.id;
                    this.form.rating = this.value;

                    this.$http.post(
                        window.api + '/doodle-ratings',
                        this.form
                    ).then((response) => {
                        if (response.data.status == 'success') {
                            this.doodle = response.data.doodle;
                        }
                    });

                    this.temp_value = value;
                    return this.value = value;
                }
            }
        }
    }
</script>

<style lang="sass" scoped>
    .star-rating {
        display: inline-block;

        .star-rating-checkbox {
            position: absolute;
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 1px;
            width: 1px;
            margin: -1px;
            padding: 0;
            border: 0;
        }

        .star {
            display: inline-block;
            padding: 3px;
            vertical-align: middle;
            line-height: 1;
            font-size: 1.5em;
            color: #ABABAB;

            &:hover {
                cursor: pointer;
            }

            &.is-selected {
                color: #FFD700;
            }

            &.is-disabled:hover {
                cursor: default;
            }
        }
    }
</style>
