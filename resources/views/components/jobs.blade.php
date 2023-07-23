<div class="p-4 space-y-3">

    @foreach($jobs as $job)
        <div class="bg-white border-2 border-gray-200 p-4 rounded">
            <h1 class="text-2xl font-bold tracking-tighter">
                <a class="text-blue-500" href="{{ $job['link'] }}" target="_blank">{{ $job['title'] }}</a>
            </h1>
            <p class="text-lg">
                {{ \Carbon\Carbon::parse($job['published_at'])->diffForHumans() }}
            </p>
        </div>
    @endforeach

</div>