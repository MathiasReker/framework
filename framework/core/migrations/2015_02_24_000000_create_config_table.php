<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Flarum\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return Migration::createTable(
    'config',
    function (Blueprint $table): void {
        $table->string('key', 100)->primary();
        $table->binary('value')->nullable();
    }
);
