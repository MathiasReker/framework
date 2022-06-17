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
        // Delete rows with non-existent groups so that we will be able to create
        // foreign keys without any issues.
        $schema->getConnection()
            ->table('group_permission')
            ->whereNotExists(function ($query): void {
                $query->selectRaw(1)->from('groups')->whereColumn('id', 'group_id');
            })
            ->delete();

        $schema->table('group_permission', function (Blueprint $table): void {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    },

    'down' => function (Builder $schema): void {
        $schema->table('group_permission', function (Blueprint $table): void {
            $table->dropForeign(['group_id']);
        });
    }
];
