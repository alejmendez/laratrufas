<?php

namespace Modules\Tasks\Services\TaskComment;

use Modules\Tasks\Models\TaskComment;

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

        $taskComment->comment = preg_replace('/<p><br><\/p>(\s*<p><br><\/p>)*$/', '', $data['comment']);
        $taskComment->save();

        return $taskComment->fresh();
    }
}
