@props(['paginator'])

@if ($paginator->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="flex space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-[#74A740] bg-white border border-[#74A740] rounded-lg hover:bg-[#74A740] hover:text-white transition-colors">
                    Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2 text-white bg-[#74A740] rounded-lg">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-[#74A740] bg-white border border-[#74A740] rounded-lg hover:bg-[#74A740] hover:text-white transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-[#74A740] bg-white border border-[#74A740] rounded-lg hover:bg-[#74A740] hover:text-white transition-colors">
                    Next
                </a>
            @else
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </div>
@endif
