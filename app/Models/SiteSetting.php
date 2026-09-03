<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_email',
        'site_phone',
        'site_address',
        'site_logo',
        'site_favicon',

        // Footer
        'footer_description',
        'copyright_text',

        // Legal Links
        'privacy_policy_url',
        'terms_url',
        'return_policy_url',

        // Social Media
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',

        // SEO
        'site_meta_description',
    ];
}