<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Posts", description: "Operations related to posts")]


#[OA\Schema(
    schema: "Post",
    type: "object",
    required: ["id", "title", "content", "user_id"],
    properties: [
        new OA\Property(property: "id", type: "integer", description: "The unique identifier of the post"),
        new OA\Property(property: "title", type: "string", description: "The title of the post"),
        new OA\Property(property: "content", type: "string", description: "The content of the post"),
        new OA\Property(property: "user_id", type: "integer", description: "The ID of the user who created the post"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", description: "The creation date of the post"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", description: "The last update date of the post"),
    ]
)]

class ApiPostController extends Controller
{
    #[OA\Get(
        path: "/posts",
        tags: ["Posts"],
        summary: "Get all posts",
        security: [["sanctum" => []]],
        description: "Retrieve a list of all blog posts.",
        responses: [
            new OA\Response(
                response: 200,
                description: "List of all posts",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "array",
                        items: new OA\Items(ref: "#/components/schemas/Post")
                    )
                )
            )
        ]
    )]
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }

    #[OA\Get(
        path: "/posts/{id}",
        tags: ["Posts"],
        summary: "Get a specific post",
        security: [["sanctum" => []]],
        description: "Retrieve details of a single blog post by its ID.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the post to retrieve",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Post details",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/Post")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Post not found"
            )
        ]
    )]
    public function show($id)
    {
        try {
            $post = Post::with('user', 'comments')->findOrFail($id);
            return response()->json($post);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    #[OA\Post(
        path: "/posts",
        tags: ["Posts"],
        summary: "Create a new post",
        security: [["sanctum" => []]],
        description: "Create a new blog post.",
        requestBody: new OA\RequestBody(
            description: "Post data to create a new blog post",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["title", "content"],
                    properties: [
                        new OA\Property(property: "title", type: "string"),
                        new OA\Property(property: "content", type: "string")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Post created",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/Post")
                )
            ),
            new OA\Response(
                response: 400,
                description: "Invalid input"
            )
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return response()->json($post, 201);
    }

    #[OA\Put(
        path: "/posts/{id}",
        tags: ["Posts"],
        summary: "Update a post",
        security: [["sanctum" => []]],
        description: "Update an existing blog post by its ID.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the post to update",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            description: "Updated post data",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["title", "content"],
                    properties: [
                        new OA\Property(property: "title", type: "string"),
                        new OA\Property(property: "content", type: "string")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Post updated",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/Post")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Post not found"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        try {
            $post = Post::where('user_id', Auth::id())->findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return response()->json($post);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    #[OA\Delete(
        path: "/posts/{id}",
        tags: ["Posts"],
        summary: "Delete a post",
        security: [["sanctum" => []]],
        description: "Remove a blog post by its ID.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the post to delete",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Post deleted"
            ),
            new OA\Response(
                response: 404,
                description: "Post not found"
            )
        ]
    )]
    public function destroy($id)
    {
        try {
            $post = Post::where('user_id', Auth::id())->findOrFail($id);
            $post->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
}
