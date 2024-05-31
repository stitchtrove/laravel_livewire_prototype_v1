<div class="mt-6 mb-6 max-w-lg mx-auto">
    <div class="back-button mb-6 border-b border-gray-200 py-4">
        <a href="/performances">< back</a>
    </div>
    <h1 class="text-xl font-semibold">{{$show->title}} <span class="text-red-500 text-xs">{{$show->isSoldOut() ? 'SOLD OUT' : ''}}</span></h1>
    <p class="mb-6 mt-2">Part of <span class="text-[{{$show->performances[0]->strand->color()}}]">{{$show->performances[0]->strand->title()}}</span>.</p>
    <ul>
        @if($show->performances)
        <p class="mb-4">{{$show->performances[0]->pricing}}</p>
        <ul>
            @foreach($show->performances as $performance)
                @if($performance->isSoldOut())
                <li class="mb-1 line-through">
                    {{$performance->start_datetime->format('d/m/y H:i')}} {{$performance->screen}}
                </li>
                @else
                <li class="mb-1 hover:text-sky-700">
                    <a href="https://domain.org.uk/flare/Online/{{$performance->additional_info_url}}" target="_blank">
                        {{$performance->start_datetime->format('d/m/y H:i')}} {{$performance->screen}}
                    </a>
                    {{-- https://domain.org.uk/flare/Online/default.asp?BOparam::WScontent::loadArticle::permalink=tickets --}}
                </li>
                @endif
            @endforeach
        </ul>
        @endif
    </ul>
</div>