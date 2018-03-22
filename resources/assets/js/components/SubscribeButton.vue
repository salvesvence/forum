<template>
    <button class="btn btn-default" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        methods: {
            subscribe() {
                axios.post(location.pathname + '/subscriptions')
                    .then(response => {
                        flash(response.data.message);
                    })
                    .catch(error => {
                        flash(error.data.message);
                    });
            }
        }
    }
</script>