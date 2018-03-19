<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea id="body"
                          name="body"
                          class="form-control"
                          placeholder="Have something to say?"
                          rows="5"
                          required
                          v-model="body">
                </textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="addReply">Post</button>
        </div>
        <!--@if(auth()->check())-->
        <!--<form action="{{ route('thread.replies.store', ['channel' => $thread->channel->slug, 'thread' => $thread->id]) }}" method="post">-->

        <!--</form>-->
        <!--@else-->
        <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate in this discussion.</p>
        <!--@endif-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .then(response => {
                        this.body = '';

                        flash(response.data.message);

                        this.$emit('created', response.data.reply);
                    })
                    .catch(error => {
                        flash(error.data.message);
                    });
            }
        }
    }
</script>