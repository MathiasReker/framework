<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema): void {
        $schema->table('settings', function (Blueprint $table): void {
            $table->text('value')->change();
        });
    },

    'down' => function (Builder $schema): void {
        $schema->table('settings', function (Blueprint $table): void {
            $table->binary('value')->change();
        });
    }
];
