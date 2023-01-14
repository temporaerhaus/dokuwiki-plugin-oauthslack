<?php

namespace dokuwiki\plugin\oauthslack;

use dokuwiki\plugin\oauth\Service\AbstractOAuth2Base;
use OAuth\Common\Http\Uri\Uri;

/**
 * Custom Service for Slack
 */
class Slack extends AbstractOAuth2Base
{

    /** @inheritdoc */
    public function getAuthorizationEndpoint()
    {
        $plugin = plugin_load('action', 'oauthslack');
        return new Uri('https://slack.com/openid/connect/authorize?team=' . $plugin->getConf('team'));
    }

    /** @inheritdoc */
    public function getAccessTokenEndpoint()
    {
        return new Uri('https://slack.com/api/openid.connect.token');
    }

    /**
     * @inheritdoc
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }

    public function needsStateParameterInAuthUrl()
    {
        return true;
    }
}
