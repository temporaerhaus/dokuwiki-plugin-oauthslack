<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthslack\Slack;

/**
 * Service Implementation for oAuth Slack authentication
 */
class action_plugin_oauthslack extends Adapter
{

    /** @inheritdoc */
    public function registerServiceClass()
    {
        return Slack::class;
    }

    /** * @inheritDoc */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        $url = 'https://slack.com/api/openid.connect.userInfo';

        $raw = $oauth->request($url);
        $result = json_decode($raw, true);

        $username = str_replace(' ', '_', strtolower($result['name']));

        $data['user'] = $username;
        $data['name'] = $result['given_name'] . ' ' . $result['family_name'];
        $data['mail'] = $result['email'];

        return $data;
    }

    public function getScopes()
    {
        return ['openid', 'email', 'profile'];
    }

    /** @inheritDoc */
    public function getLabel()
    {
        return 'Slack';
    }

    /** @inheritDoc */
    public function getColor()
    {
        return '#4A154B';
    }

}
