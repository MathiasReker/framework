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
        if (! $schema->hasColumn('migrations', 'id')) {
            $schema->table('migrations', function (Blueprint $table): void {
                $table->increments('id')->first();
            });
        }
    },

    'down' => function (Builder $schema): void {
        $schema->table('migrations', function (Blueprint $table): void {
            $table->dropColumn('id');
        });
    }
];
