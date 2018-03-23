<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default']
            }
        },

        methods: {
            subscribe() {
                let $this = this,
                    requestType = $this.active ? 'delete' : 'post';

                axios[requestType](location.pathname + '/subscriptions')
                    .then(response => {
                        flash(response.data.message);
                        $this.active = ! $this.active;
                    })
                    .catch(error => {
                        flash(error.data.message);
                    });
            }
        }
    }
</script>