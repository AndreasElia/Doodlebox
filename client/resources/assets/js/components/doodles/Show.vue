<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">View a Doodle</div>

                    <div class="panel-body">
                        <canvas id="game" @mousedown="mouseDown" @mousemove="mouseMove" @mouseup="mouseUp"></canvas>
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
                gameElm: 'game',
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
                total_points: [],

                form: {
                    name: null,
                    image: null
                },
                errors: null
            }
        },
        methods: {
            draw: function (x, y, isActive) {
                if (isActive) {
                    this.points.push({ x: x, y: y });

                    this.pointsToCanvas(this.getColour(), this.getSize(), this.points);
                }

                this.last.x = x;
                this.last.y = y;

                this.points.push({ x: x, y: y });

                this.pointsToCanvas(this.getColour(), this.getSize(), this.points);
            },
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
            },
            clearCanvas: function () {
                this.resetCanvas();
            },
            mouseDown: function (e) {
                this.isMouseDown = true;

                this.last.x = e.pageX - this.offset.left;
                this.last.y = e.pageY - this.offset.top;
            },
            mouseMove: function (e) {
                if (this.isMouseDown) {
                    this.draw(e.pageX - this.offset.left, e.pageY - this.offset.top, true);
                }
            },
            mouseUp: function (e) {
                this.isMouseDown = false;

                this.total_points = this.total_points.concat(this.points);

                this.points = [];
            },
            getColour: function () {
                var e = document.getElementById(this.colourElm);

                if (e == undefined) {
                    return;
                }

                return e.options[e.selectedIndex].value;
            },
            getSize: function () {
                var e = document.getElementById(this.sizeElm);

                if (e == undefined) {
                    return;
                }

                return e.options[e.selectedIndex].value;
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

            this.$http.get(
                window.api + '/doodles/' + this.$route.params.id
            ).then((response) => {
                if (response.data.status == 'success') {
                    this.form.name = response.data.doodle.name;
                    this.form.total_points = JSON.parse(response.data.doodle.image);
                    this.drawFromStream(JSON.parse(response.data.doodle.image));
                }

                if (response.data.status == 'error') {
                    this.errors = response.data.errors;
                }
            });
        }
    }
</script>

<style lang="sass" scoped>
    #game {
        width: 800px;
        height: 600px;
        margin: 0 auto;
        display: block;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 3px;
    }
</style>
