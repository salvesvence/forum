<script>
    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                }).then(function (response) {
                    flash(response.data.message);
                })
                .catch(function (error) {
                    flash(error.data.message);
                });

                this.editing = false;
            }
        }
    }
</script>