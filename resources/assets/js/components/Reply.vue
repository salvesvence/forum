<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.data.body
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(function (response) {
                    flash(response.data.message);
                })
                .catch(function (error) {
                    flash(error.data.message);
                });

                this.editing = false;
            },

            destroy() {

                var message = '';

                axios.delete('/replies/' + this.data.id)
                .then(function (response) {
                    message = response.data.message;
                })
                .catch(function (error) {
                    message = error.data.message;
                });

                $(this.$el).fadeOut(300, () => {
                    flash(message);
                });
            }
        }
    }
</script>