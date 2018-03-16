<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorite: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.isFavorite ? 'btn-primary' : 'btn-default'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                return this.isFavorite ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);

                this.isFavorite = true;
                this.favoritesCount++;
            },

            destroy() {
                axios.delete(this.endpoint);

                this.isFavorite = false;
                this.favoritesCount--;
            }
        }
    }
</script>