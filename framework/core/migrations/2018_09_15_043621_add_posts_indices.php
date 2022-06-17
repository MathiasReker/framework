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
        $schema->table('posts', function (Blueprint $table): void {
            $table->index(['discussion_id', 'number']);
            $table->index(['discussion_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    },

    'down' => function (Builder $schema): void {
        $schema->table('posts', function (Blueprint $table): void {
            $table->dropIndex(['discussion_id', 'number']);
            $table->dropIndex(['discussion_id', 'created_at']);
            $table->dropIndex(['user_id', 'created_at']);
        });
    }
];
