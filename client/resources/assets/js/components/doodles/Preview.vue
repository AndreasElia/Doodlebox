<template>
    <router-link :to="{ name: 'show-doodle', params: { id: doodle.id }}" class="preview text-center">
        <canvas class="game" v-bind:id="'game-' + doodle.id"></canvas>
        <h5>{{ doodle.name }}</h5>
    </router-link>
</template>

<script>
    export default {
        data() {
            return {
                gameElm: 'game-' + this.doodle.id,
                colourElm: 'selColour',
                sizeElm: 'selSize',
                selectedColour: null,

                container: null,

                canvas: null,
                ctx: null,
                width: null,
                height: null,

                isMouseDown: false,
                offset: { top: 0, left: 0 },
                last: { x: 0, y: 0 },
                points: [],
                total_points: []
            }
        },
        props: [
            'doodle'
        ],
        methods: {
            pointsToCanvas: function (colour, size, points) {
                this.ctx.beginPath();
                this.ctx.lineJoin = this.ctx.lineCap = 'round';
                this.ctx.moveTo(points[0].x, points[0].y);

                for (var i = 1; i < points.length; i++) {
                    this.ctx.strokeStyle = colour;
                    this.ctx.lineWidth = size;
                    this.ctx.lineTo(points[i].x, points[i].y);
                }

                this.ctx.stroke();
            },
            drawFromStream: function (points) {
                if (! points || points.length <= 0) {
                    return;
                }

                this.pointsToCanvas('black', '10', points);
            },
            resetCanvas: function () {
                this.ctx.setTransform(1, 0, 0, 1, 0, 0);
                this.ctx.fillStyle = '#fff';
                this.ctx.fillRect(0, 0, this.width, this.height);
            }
        },
        computed: {
            backgroundStyle: function () {
                return this.selectedColour == null ? '#fff' : this.selectedColour;
            }
        },
        mounted() {
            this.canvas = document.getElementById(this.gameElm);
            this.ctx = this.canvas.getContext('2d');

            this.container = document.getElementById(this.gameElm);

            this.width = this.container.clientWidth;
            this.height = this.container.clientHeight;

            this.canvas.node = this.canvas;
            this.canvas.node.width = this.width;
            this.canvas.node.height = this.height;

            this.resetCanvas();

            var rect = this.container.getBoundingClientRect();

            this.offset.top = rect.top + document.body.scrollTop;
            this.offset.left = rect.left + document.body.scrollLeft;

            this.doodle.image = JSON.parse(this.doodle.image);

            this.doodle.image.forEach(function (item, index) {
                item.x = item.x / 4;
                item.y = item.y / 4;
            });

            this.drawFromStream(this.doodle.image);
        }
    }
</script>

<style lang="sass">
    a {
        &.preview {
            display: inline-block;
            margin: 0 auto 0 15px;

            &:first-of-type {
                margin: 0 auto;
            }

            &:nth-child(4n+1) {
                margin: 0 auto;
            }

            .game {
                width: 200px;
                height: 150px;
                display: inline-block;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 3px;
            }

            h5 {
                margin: 0 0 15px;
            }
        }
    }
</style>
