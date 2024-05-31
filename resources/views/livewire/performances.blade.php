<div>
    <div class="mt-6 mb-6 max-w-lg mx-auto">
        <h2 class="mt-6 mb-6 max-w-lg mx-auto font-bold text-xl">Search filters</h2>
        <div class="w-full mb-4">
            <label for="titleSearch" class="block text-sm font-medium text-gray-700 mb-2">Search by Title:</label>
            <input id="titleSearch" type="text" wire:model.live="titleSearch" class="block w-full p-1.5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400/70 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>
        <div class="w-full mb-4">
            <label for="chosenVenue" class="block text-sm font-medium text-gray-700 mb-2">Venue:</label>
            <select id="chosenVenue" wire:model.live="chosenVenue" class="w-full p-1.5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400/70 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                <option value="">All venues</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue }}">{{ $venue }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full mb-4">
            <label for="chosenStrand" class="block text-sm font-medium text-gray-700 mb-2">Strand:</label>
            <select id="chosenStrand" wire:model.live="chosenStrand" class="w-full p-1.5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400/70 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                <option value="">All strands</option>
                @foreach($strands as $strand)
                    <option value="{{ $strand }}">{{ $strand->title() }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full mb-4">
            <label for="chosenOrder" class="block text-sm font-medium text-gray-700 mb-2">Order by:</label>
            <select id="chosenOrder" wire:model.live="chosenOrder" class="w-full p-1.5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400/70 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                <option value="az">A-Z</option>
                <option value="za">Z-A</option>
                <option value="soonest">Next showing</option>
            </select>
        </div>
        <div class="w-full">
            <div class="inline-flex items-center">
                <label class="relative flex items-center pr-3 rounded-full cursor-pointer" htmlFor="filterPricing">
                  <input type="checkbox"
                    class=" peer relative h-5 w-5 cursor-pointer rounded-md border border-blue-gray-200 "
                    id="filterPricing" wire:model.live="filterPricing" />
                </label>
                <label class="mt-px font-light text-gray-700 cursor-pointer select-none" htmlFor="filterPricing">
                  Free 
                </label>
              </div> 
        </div>
    </div>
        <div x-data="{ openItem: null }" class="max-w-lg mx-auto">
            @foreach($programme as $show)
                <div class="border-b border-gray-200 py-4 border-l-4 border-l-[{{$show->performances[0]->strand->color()}}]">
                    <div @click="openItem === {{ $loop->index }} ? openItem = null : openItem = {{ $loop->index }}" class="flex justify-between items-center cursor-pointer pl-4">
                        <p class="text-lg font-semibold">{{$show->title}} <span class="text-red-500 text-xs">{{$show->isSoldOut() ? 'SOLD OUT' : ''}}</span></p>
                        <svg x-show="openItem === {{ $loop->index }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.293 7.293a1 1 0 0 1 1.414 1.414L10 10.414l2.293-2.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="openItem !== {{ $loop->index }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 6.293a1 1 0 0 1 1.414 0L10 7.586l1.293-1.293a1 1 0 1 1 1.414 1.414l-2 2a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div x-show="openItem === {{ $loop->index }}" class="mt-2 pl-4">
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
                        <a href="/show/{{ $show->id }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Film info</a>
                    </div>
                </div>
            @endforeach
        </div>
</div>