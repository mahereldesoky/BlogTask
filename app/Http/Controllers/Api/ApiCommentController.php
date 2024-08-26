<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Notifications\CommentAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Comments", description: "Operations related to comments")]

#[OA\Schema(
    schema: "Comment",
    type: "object",
    required: ["id", "content", "post_id", "user_id"],
    properties: [
        new OA\Property(property: "id", type: "integer", description: "The unique identifier of the comment"),
        new OA\Property(property: "content", type: "string", description: "The content of the comment"),
        new OA\Property(property: "post_id", type: "integer", description: "The ID of the post to which the comment belongs"),
        new OA\Property(property: "user_id", type: "integer", description: "The ID of the user who made the comment"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", description: "The creation date of the comment"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", description: "The last update date of the comment"),
    ]
)]

class ApiCommentController extends Controller
{
    #[OA\Post(
        path: "/comments",
        tags: ["Comments"],
        summary: "Add a new comment",
        security: [["sanctum" => []]],
        description: "Create a new comment on a post.",
        requestBody: new OA\RequestBody(
            description: "Comment data to be added",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["content", "post_id"],
                    properties: [
                        new OA\Property(property: "content", type: "string", description: "The content of the comment"),
                        new OA\Property(property: "post_id", type: "integer", description: "ID of the post to comment on")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Comment created",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(ref: "#/components/schemas/Comment")
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
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->save();

        $post = $comment->post;
        Notification::send($post->user->email, new CommentAdded($comment));

        return response()->json($comment, 201);
    }

    #[OA\Delete(
        path: "/comments/{id}",
        tags: ["Comments"],
        summary: "Delete a comment",
        security: [["sanctum" => []]],
        description: "Remove a comment by its ID.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the comment to delete",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Comment deleted"
            ),
            new OA\Response(
                response: 404,
                description: "Comment not found"
            )
        ]
    )]
    public function destroy($id)
    {
        $comment = Comment::where('user_id', Auth::id())->findOrFail($id);
        $comment->delete();

        return response()->json(null, 204);
    }
}
