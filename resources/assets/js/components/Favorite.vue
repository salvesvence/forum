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
            }
        },

        methods: {
            toggle() {
                if(this.isFavorite) {
                    axios.delete('/replies/' + this.reply.id + '/favorites');

                    this.isFavorite = false;
                    this.favoritesCount--;
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites');

                    this.isFavorite = true;
                    this.favoritesCount++;
                }
            }
        }
    }
</script>