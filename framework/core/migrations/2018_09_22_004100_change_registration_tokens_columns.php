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
        $schema->table('registration_tokens', function (Blueprint $table): void {
            $table->string('provider');
            $table->string('identifier');
            $table->text('user_attributes')->nullable();

            $table->text('payload')->nullable()->change();
        });
    },

    'down' => function (Builder $schema): void {
        $schema->table('registration_tokens', function (Blueprint $table): void {
            $table->dropColumn('provider', 'identifier', 'user_attributes');

            $table->string('payload', 150)->change();
        });
    }
];
