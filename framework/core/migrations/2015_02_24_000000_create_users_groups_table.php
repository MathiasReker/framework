<?php declare(strict_types=1);

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Flarum\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return Migration::createTable(
    'users_groups',
    function (Blueprint $table) {
        $table->integer('user_id')->unsigned();
        $table->integer('group_id')->unsigned();
        $table->primary(['user_id', 'group_id']);
    }
);
