<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'hero_image',
        'hero_title',
        'hero_description',
        'service_hours',
        'location_name',
        'location_url',
        'whatsapp_number',
        'whatsapp_url',
        'instagram',
        'email',
    ];
}
