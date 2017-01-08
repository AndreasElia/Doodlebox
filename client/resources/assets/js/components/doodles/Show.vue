<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ (doodle != null) ? doodle.name : '' }}</div>

                    <div class="panel-body">
                        <div class="row" v-if="validUser" style="margin-bottom: 15px;">
                            <div class="col-sm-4">
                                <label>Creator Controls</label>
                            </div>

                            <div class="col-sm-8 text-right">
                                <button class="btn btn-info" @click="doodleEdit">Edit</button>
                                <button class="btn btn-danger" @click="doodleDelete">Delete</button>
                            </div>
                        </div>

                        <canvas id="game"></canvas>
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

                doodle: null
            }
        },
        methods: {
            doodleEdit: function () {
                this.$router.push({ name: 'edit-doodle', params: { id: this.$route.params.id } });
            },
            doodleDelete: function () {
                this.$http.delete(
                    window.api + '/doodles/' + this.$route.params.id
                ).then((response) => {
                    if (response.data.status == 'success') {
                        this.$router.push({ name: 'doodles' });
                    }
                });
            },
            validUser: function () {
                if (this.doodle != null && this.$root.user != null) {
                    return (this.doodle.user_id == this.$root.user.id);
                }

                return false;
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
                    this.doodle = response.data.doodle;
                    this.drawFromStream(JSON.parse(this.doodle.image));
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
