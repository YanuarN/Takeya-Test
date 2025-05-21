<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">
            
            @guest
            {{-- Tampilan untuk guest --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest

            @auth
            {{-- Tampilan untuk authenticated users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    
                    @forelse($posts as $post)
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            {{-- Status Badge --}}
                            @if($post->status === 'published')
                            <span class="flex-none rounded bg-green-100 px-2 py-1 text-green-800">Published</span>
                            @elseif($post->status === 'scheduled')
                            <span class="flex-none rounded bg-yellow-100 px-2 py-1 text-yellow-800">Scheduled</span>
                            @else
                            <span class="flex-none rounded bg-gray-100 px-2 py-1 text-gray-800">Draft</span>
                            @endif
                            
                            <h3><a href="{{ route('posts.show', $post) }}" class="text-blue-500">{{ $post->title }}</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Created: {{ $post->created_at->format('Y-m-d H:i') }}</div>
                                <div>Last Updated: {{ $post->updated_at->format('Y-m-d H:i') }}</div>
                                @if($post->published_at)
                                <div>Scheduled: {{ $post->published_at->format('Y-m-d H:i') }}</div>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-500">Detail</a>
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-gray-500">
                        No posts found. <a href="{{ route('posts.create') }}" class="text-blue-500">Create your first post</a>
                    </div>
                    @endforelse

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            @endauth
            
        </div>
    </div>
</x-app-layout>