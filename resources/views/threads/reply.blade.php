<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">

        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h5>
                <div>
                    <form method="post" action="{{ route('favorites.store', ['reply' => $reply->id]) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                        </button>
                    </form>
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
            <div v-else>
                {{ $reply->body }}
            </div>
        </div>

        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-default btn-xs mr-1" @click="editing = true">Edit</button>
                <form method="post" action="/replies/{{ $reply->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                </form>
            </div>
        @endcan

    </div>
</reply>