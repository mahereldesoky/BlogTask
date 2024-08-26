<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
            <p class="mt-2 text-gray-700">{{ $post->content }}</p>
            @if(Auth::check() && Auth::id() === $post->user_id)
                <form action="{{ route('posts.update', $post) }}" method="GET" class="mt-4">
                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline">Edit Post</a>
                </form>
            @endif
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <h2 class="text-xl font-semibold">Comments</h2>
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="content" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Add a comment..."></textarea>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Comment</button>
            </form>

            <div class="mt-4 space-y-4">
                @foreach($post->comments as $comment)
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p>{{ $comment->content }}</p>
                        @if(Auth::check() && Auth::id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete Comment</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
