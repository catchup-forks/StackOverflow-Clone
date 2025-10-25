<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_type_id');
            $table->integer('accepted_answer_id');
            $table->integer('parent_id');
            $table->dateTime('creation_date');
            $table->integer('score');
            $table->integer('view_count');
            $table->text('body');
            $table->integer('user_id');
            $table->string('owner_display_name', 40);
            $table->integer('last_editor_user_id');
            $table->string('last_editor_display_name', 40);
            $table->dateTime('last_edit_date');
            $table->dateTime('last_activity_date');
            $table->string('title', 250);
            $table->string('tags', 150);
            $table->integer('answer_count');
            $table->integer('comment_count');
            $table->integer('favorite_count');
            $table->dateTime('closed_date');
            $table->dateTime('community_owned_date');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reputation');
            $table->dateTime('creation_date');
            $table->string('display_name', 40);
            $table->dateTime('last_access_date');
            $table->string('website_url', 200);
            $table->string('location', 100);
            $table->text('about_me');
            $table->integer('views');
            $table->integer('up_votes');
            $table->integer('down_votes');
            $table->string('email', 160);
            $table->integer('age');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('score');
            $table->text('body');
            $table->dateTime('creation_date');
            $table->string('user_display_name', 30);
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name', 50);
            $table->dateTime('date');
            $table->timestamps();
        });

        Schema::create('post_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->boolean('is_anonymous');
            $table->integer('vote_type_id');
            $table->dateTime('creation_date');
            $table->timestamps();
        });

        Schema::create('post_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_history_type_id');
            $table->integer('post_id');
            $table->integer('revision_GUID');
            $table->dateTime('on_date');
            $table->integer('user_id');
            $table->string('user_display_name', 40);
            $table->text('comment');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('post_history_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->timestamps();
        });

        Schema::create('post_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('suggested_edits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->dateTime('creation_date');
            $table->dateTime('approval_date');
            $table->dateTime('rejection_date');
            $table->integer('owner_user_id');
            $table->text('comment');
            $table->text('body');
            $table->string('title', 250);
            $table->string('tags', 150);
            $table->integer('revision_GUID');
            $table->timestamps();
        });

        Schema::create('suggested_edit_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suggested_edit_id');
            $table->integer('user_id');
            $table->integer('vote_type_id');
            $table->dateTime('creation_date');
            $table->integer('target_user_id');
            $table->integer('target_rep_change');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 25);
            $table->integer('count');
            $table->integer('excerpt_post_id');
            $table->integer('wiki_post_id');
            $table->timestamps();
        });

        Schema::create('tag_synonyms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_tag_name', 25);
            $table->string('target_tag_name', 25);
            $table->dateTime('creation_date');
            $table->integer('user_id');
            $table->integer('auto_rename_count');
            $table->dateTime('last_auto_rename');
            $table->integer('score');
            $table->integer('approved_by_user_id');
            $table->dateTime('approval_date');
            $table->timestamps();
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('vote_type_id');
            $table->integer('user_id');
            $table->dateTime('creation_date');
            $table->integer('bounty_amount');
            $table->timestamps();
        });

        Schema::create('vote_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('provider_name');
            $table->integer('provider_uid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
        Schema::dropIfExists('vote_types');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('tag_synonyms');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('suggested_edit_votes');
        Schema::dropIfExists('suggested_edits');
        Schema::dropIfExists('post_types');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_history_types');
        Schema::dropIfExists('post_history');
        Schema::dropIfExists('post_feedback');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('users');
        Schema::dropIfExists('posts');
    }
};
