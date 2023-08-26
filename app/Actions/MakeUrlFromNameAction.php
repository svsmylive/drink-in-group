<?php

namespace App\Actions;

use Illuminate\Support\Str;

class MakeUrlFromNameAction
{
    public function execute(string $name): string
    {
        $lowerName = Str::lower($name);

        return Str::slug($lowerName);
    }
}