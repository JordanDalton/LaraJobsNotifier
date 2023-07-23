<div class="p-4 space-y-3">

    @foreach($jobs as $job)
        <div class="border-2 border-black p-4 rounded">
            <h1 class="text-2xl font-bold">
                <a class="text-blue-500" href="{{ $job['link'] }}" target="_blank">{{ $job['title'] }}</a>
            </h1>
            <p class="text-lg">
                {{ \Carbon\Carbon::parse($job['published_at'])->diffForHumans() }}
            </p>
        </div>
    @endforeach

</div>