<?php

namespace App\Services\TaskComment;

use App\Models\TaskComment;

class DeleteTaskComment
{
    public static function call(string $id): void
    {
        $taskComment = TaskComment::findOrFail($id);

        // Verificar si el usuario actual es el propietario del comentario
        if ($taskComment->user_id !== auth()->id()) {
            throw new \Illuminate\Auth\Access\AuthorizationException(
                'No estás autorizado para eliminar este comentario.'
            );
        }

        $taskComment->delete();
    }
}
