<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('footer_description')->nullable()->after('site_favicon');
            $table->string('copyright_text')->nullable()->after('footer_description');

            $table->string('privacy_policy_url')->nullable()->after('copyright_text');
            $table->string('terms_url')->nullable()->after('privacy_policy_url');
            $table->string('return_policy_url')->nullable()->after('terms_url');

            $table->string('facebook_url')->nullable()->after('return_policy_url');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('twitter_url')->nullable()->after('instagram_url');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
            $table->string('youtube_url')->nullable()->after('linkedin_url');

            // Fix for the existing products/layout.blade.php reference.
            $table->text('site_meta_description')->nullable()->after('youtube_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_description',
                'copyright_text',
                'privacy_policy_url',
                'terms_url',
                'return_policy_url',
                'facebook_url',
                'instagram_url',
                'twitter_url',
                'linkedin_url',
                'youtube_url',
                'site_meta_description',
            ]);
        });
    }
};