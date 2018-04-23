<template>
    <div :id="'reply-' + id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + data.owner.name"
                       v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>...
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-default btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-default btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="panel-footer level" v-if="canUpdate">
            <button class="btn btn-default btn-xs mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
        </div>

    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },

            signedIn() {
                return window.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(response => {
                    flash(response.data.message);
                })
                .catch(error => {
                    flash(error.response.data.message, 'danger');
                });

                this.editing = false;
            },

            destroy() {

                var message = '',
                    $this = this;

                axios.delete('/replies/' + this.data.id)
                .then(response => {
                    $($this.$el).fadeOut(300, () => {
                        flash(response.data.message);
                    });
                })
                .catch(error => {
                    $($this.$el).fadeOut(300, () => {
                        flash(error.response.data.message, 'danger');
                    });
                });

                this.$emit('deleted', this.data.id);
            }
        }
    }
</script>