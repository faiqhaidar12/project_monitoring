<ul class="flex justify-center space-x-2">
    @if ($paginator->onFirstPage())
        <li
            class="relative inline-flex items-center px-2 py-2 text-gray-300 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            <span aria-hidden="true">&laquo;</span>
        </li>
    @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="relative inline-flex items-center px-2 py-2 text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-400 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li
                class="relative inline-flex items-center px-4 py-2 -ml-px text-gray-700 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                <span>{{ $element }}</span>
            </li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-blue-600 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                        {{ $page }}</li>
                @else
                    <li>
                        <a href="{{ $url }}"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-400 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="relative inline-flex items-center px-2 py-2 text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-400 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    @else
        <li
            class="relative inline-flex items-center px-2 py-2 text-gray-300 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            <span aria-hidden="true">&raquo;</span>
        </li>
    @endif
</ul>
