<?php

namespace App\Services\TaskComment;

use App\Models\TaskComment;

class UpdateTaskComment
{
    public static function call(string $id, array $data): TaskComment
    {
        $taskComment = TaskComment::findOrFail($id);

        // Verificar si el usuario actual es el propietario del comentario
        if ($taskComment->user_id !== auth()->id()) {
            throw new \Illuminate\Auth\Access\AuthorizationException(
                'No estás autorizado para actualizar este comentario.'
            );
        }

        $taskComment->comment = $data['comment'];
        $taskComment->save();

        return $taskComment->fresh();
    }
}
