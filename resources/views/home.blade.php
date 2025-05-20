<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            {{-- for gueset users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>

            {{-- for authenticated users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded bg-green-100 px-2 py-1 text-green-800">Active</span>
                            <h3><a href="#" class="text-blue-500">Post title 1</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: 2024-10-01</div>
                                <div>Updated: 2024-10-10</div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500">Detail</a> /
                                <a href="#" class="text-blue-500">Edit</a> /
                                <form action="#" method="POST" class="inline">
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded bg-gray-100 px-2 py-1 text-gray-800">Draft</span>
                            <h3><a href="#" class="text-blue-500">Post title 2</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: -</div>
                                <div>Updated: 2024-10-10</div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500">Detail</a> /
                                <a href="#" class="text-blue-500">Edit</a> /
                                <form action="#" method="POST" class="inline">
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded bg-yellow-100 px-2 py-1 text-yellow-800">Scheduled</span>
                            <h3><a href="#" class="text-blue-500">Post title 3</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: 2030-10-01</div>
                                <div>Updated: 2024-10-10</div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500">Detail</a> /
                                <a href="#" class="text-blue-500">Edit</a> /
                                <form action="#" method="POST" class="inline">
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>Pagination Here</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
