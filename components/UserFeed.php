<?php namespace BenjaminLienart\Instagram\Components;

use Cms\Classes\ComponentBase;
use Facebook\Facebook;
use BenjaminLienart\Instagram\Models\Settings;
use \Cache;
use \Carbon\Carbon;

class UserFeed extends ComponentBase
{
    use \BenjaminLienart\Instagram\Classes\MakeKeyTrait;

    public $media;

    public function componentDetails()
    {
        return [
            'name'        => 'User Feed',
            'description' => 'Instagram media from a specified user.'
        ];
    }

    public function defineProperties()
    {
        return [
            'user_name' => [
                'title'             => 'User Name',
                'description'       => 'Restrict returned media by the specified user.',
                'default'           => '',
                'type'              => 'string',
                'validationPattern' => '^(?=\s*\S).*$',
                'validationMessage' => 'The User Name property is required'
            ],
            'limit' => [
                'title'             => 'Limit',
                'description'       => 'The number of media to be displayed (20 maximum).',
                'default'           => 10,
                'type'              => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'The Limit property should be numeric'
            ],
            'cache' => [
                'title'             => 'Cache',
                'description'       => 'The number of minutes to cache the media.',
                'default'           => 10,
                'type'              => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'The Cache property should be numeric'
            ]
        ];
    }

    public function onRun()
    {
        $key = $this->makeKey();

        if (Cache::has($key))
        {
            $this->media = $this->page['media'] = Cache::get($key);
        }
        else
        {
            $settings = Settings::instance();
            $fb = new Facebook([
                'app_id' => $settings->app_id,
                'app_secret' => $settings->app_secret,
                'default_graph_version' => 'v3.2',
                'default_access_token' => $settings->access_token,
            ]);

            try {
                    // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                    // If you provided a 'default_access_token', the '{access-token}' is optional.
                    $response = $fb->get('/'.$settings->instagram_id.'/media');
            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
            }

            var_dump($response);
            $me = $response->getGraphUser();
            echo 'Logged in as ' . $me->getName();

            // $this->media = $this->page['media'] = $api->getUserByUsername($this->property('user_name'))->getMedia(array('count' => $this->property('limit', 10)));

            // $expires_at = Carbon::now()->addMinutes($this->property('cache'));
            // Cache::put($key, $this->media, $expires_at);
        }
    }
}