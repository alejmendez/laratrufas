<?php

namespace Modules\Field\Services\Owners;

use Modules\Field\Models\Owner;

class DeleteOwner
{
    public static function call($id): void
    {
        Owner::destroy($id);
    }
}
