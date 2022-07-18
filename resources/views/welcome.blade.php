<x-guest-layout>
{{-- @dump($storageMin, $storageMax, $rams, $locations, $storageTypes) --}}
    <form action="{{ route('search') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <img src="{{ asset("images/leaseweb-big.png") }}">
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-4">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="text-lg font-semibold">Storage</div>
                            </div>

                            <div class="">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <select>
                                        <option>sdfsd</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="text-lg font-semibold">Storage Type</div>
                            </div>

                            <div class="">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <select name="storage_type_id" id="storage_type_id">
                                        <option value="0">-- ALL --</option>
                                    @foreach($storageTypes as $storageType)
                                        <option value="{{ $storageType->id }}" @if (old('storage_type_id') == $storageType->id) selected="true" @endif>{{ $storageType->type }}</option>
                                    @endforeach                                
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <div class="text-lg font-semibold">RAM</div>
                            </div>

                            <div class="">
                            @foreach($rams as $ram)
                                <div class="form-check form-check-inline mr-3">
                                    <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="inlineCheckbox{{ $loop->index }}" name="ram[]" value="{{ $ram->ram_size }}">
                                    <label class="form-check-label inline-block text-gray-800" for="inlineCheckbox1">{{ $ram->ram_size }}GB</label>
                                </div>
                            @endforeach
                            </div>                        
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                            <div class="flex items-center">
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">Location</div>
                            </div>

                            <div class="">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <select name="location_id" id="location_id">
                                        <option value="0">-- ALL --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" @if (old('location_id') == $location->id) selected="true" @endif>{{ $location->location }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                    <div class="text-right text-sm text-gray-500 sm:text-right sm:ml-0">
                        <button type="submit" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Search</button>
                    </div>                    
                </div>

            <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full border-separate" style="border-spacing: 0">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Model</th>
                            <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">RAM</th>
                            <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell">Storage</th>
                            <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter">Location</th>
                            <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter">Price</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                    @foreach($serverList as $server)                          
                        <tr>
                            <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $server->model }}</td>
                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $server->ram_size}}{{ $server->ram_unit}} {{ $server->ram_type}}</td>
                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $server->storage_number}}x{{ $server->storage_size}}{{ $server->storage_unit}}&nbsp;{{ $server->type}}</td>
                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500">{{ $server->location}}</td>
                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 text-right">@if ($server->currency == 'usd')${{ $server->price}}@else{{ $server->price}}&euro;@endif</td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
            </div>

            </div>
        </div>
        
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- This example requires Tailwind CSS v2.0+ -->

        </div>    

    </form>
</x-guest-layout>