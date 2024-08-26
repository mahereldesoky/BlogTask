<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-2xl font-bold">MyBlog</a>
            
            <div>
                @if (Auth::check())
                    <a href="{{ route('dashboard') }}" class="text-white px-4 py-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white px-4 py-2">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white px-4 py-2">Login</a>
                    <a href="{{ route('register') }}" class="text-white px-4 py-2">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Blog Posts</h1>

        <!-- Display Blog Posts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                    <p class="mt-2">{{ Str::limit($post->content, 100) }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500 mt-2 inline-block">Read more</a>
                </div>
            @endforeach
        </div>
    </div>

</body></html>
