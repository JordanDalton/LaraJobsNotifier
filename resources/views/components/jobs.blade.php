<div class="p-4 space-y-3">

    @foreach($jobs as $job)
        <div class="bg-white border-2 border-gray-200 p-4 rounded">
            <h3 class="text-sm">{{ $job['company'] }}</h3>
            <h1 class="text-2xl font-bold tracking-tighter">
                <a class="text-blue-500" href="{{ $job['link'] }}" target="_blank">{{ $job['title'] }}</a>
            </h1>
            <div class="flex space-x-3">
                @if($job['salary'])
                    <div>
                        {{ $job['salary'] }}
                    </div>
                @endif
                @if($job['location'])
                <div>
                    {{ $job['location'] }}
                </div>
                @endif
                <div>
                    {{ \Carbon\Carbon::parse($job['published_at'])->diffForHumans() }}
                </div>
            </div>
            @php
                $tags = str($job['tags'])->explode(',');
            @endphp
            @if($tags->count())
            <div class="flex mt-2 space-x-3 text-sm">
                @foreach($tags as $tag)
                    <div class="bg-gray-100 px-2 border-r border-white">{{ $tag  }}</div>
                @endforeach
            </div>
            @endif
        </div>
    @endforeach

</div>