<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'is_blog')) {
                $table->boolean('is_blog')->default(false);
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            if (! Schema::hasColumn('comments', 'requires_admin_review')) {
                $table->boolean('requires_admin_review')->default(false);
            }

            if (! Schema::hasColumn('comments', 'admin_editor_id')) {
                $table->unsignedBigInteger('admin_editor_id')->nullable();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable();
            }

            if (! Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'is_blog')) {
                $table->dropColumn('is_blog');
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'requires_admin_review')) {
                $table->dropColumn('requires_admin_review');
            }

            if (Schema::hasColumn('comments', 'admin_editor_id')) {
                $table->dropColumn('admin_editor_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }

            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
