<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <a href="#">
                {{ $reply->owner->name }}
            </a> said {{ $reply->created_at->diffForHumans() }}...
            <div class="">
                <form action="">
                    <button type="submit" class="btn btn-default">Favorite</button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">{{ $reply->body }}</div>
</div>