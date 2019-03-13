<?php namespace BenjaminLienart\Instagram\Models;

use October\Rain\Database\Model;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'benjaminlienart_instagram_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * Validation rules
     */
    public $rules = [
        'instagram_id'             => 'required',
        'access_token'             => 'required',
    ];
}