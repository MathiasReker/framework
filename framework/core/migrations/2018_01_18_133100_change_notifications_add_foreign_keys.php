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
        // Delete rows with non-existent users so that we will be able to create
        // foreign keys without any issues.
        $schema->getConnection()
            ->table('notifications')
            ->whereNotExists(function ($query): void {
                $query->selectRaw(1)->from('users')->whereColumn('id', 'user_id');
            })
            ->delete();

        $schema->getConnection()
            ->table('notifications')
            ->whereNotExists(function ($query): void {
                $query->selectRaw(1)->from('users')->whereColumn('id', 'from_user_id');
            })
            ->update(['from_user_id' => null]);

        $schema->table('notifications', function (Blueprint $table): void {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('set null');
        });
    },

    'down' => function (Builder $schema): void {
        $schema->table('notifications', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['from_user_id']);
        });
    }
];
