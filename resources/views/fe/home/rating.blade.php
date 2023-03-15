<div class="co-item">
    <div class="avatar-pic">
        <img src="{{ isset($rating->user->image) ? asset('images/' . $rating->user->image) : '' }}"
            alt="">
    </div>
    <div class="avatar-text">
        <div class="at-rating">
            @for ($i = 0; $i < $rating->rate; $i++)
                <i class="fa fa-star"></i>
            @endfor
            @for ($i = 0; $i < 5 - $rating->rate; $i++)
                <i class="fa fa-star-o"></i>
            @endfor
        </div>
        <div
            @if ($rating->user->role == 'Admin') style="background-color: var(--red-dark-tu) !important" class="badge rounded-pill bg-info text-light"
                @elseif ($rating->user->role == 'Manager') 
                    style="background-color: var(--violet-2nd) !important" class="badge rounded-pill bg-info text-light"
                @else
                    style="background-color: var(--grey-dark-2nd) !important" class="badge rounded-pill bg-secondary text-light" @endif>
            {{ $rating->user->role }}
        </div>
        <h5>{{ $rating->user->name }}
            <span>{{ $rating->timeRating() }}</span>
        </h5>
        <div class="at-reply">{{ $rating->review }}</div>
        @if (auth()->user())
            @if (auth()->user()->role == 'Admin')
                <a href="#" id="deletecomment"
                    class="btn btn-outline-danger btn-sm"
                    data-index="{{ $rating->id }}">
                    <i class="fas fa-trash"></i>
                    Delete
                </a>
            @endif
        @endif
    </div>
</div>