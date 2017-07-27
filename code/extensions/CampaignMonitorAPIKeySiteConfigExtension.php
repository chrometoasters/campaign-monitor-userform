<?php

namespace Chrometoaster\SiteConfigExtensions;

use Config;
use DataExtension;
use FieldList;
use TextField;

/**
 * Class CampaignMonitorAPIKeySiteConfigExtension
 *
 * Provide fields for Campaign Monitor's Client ID and API key configuration.
 *
 *
 * @package Chrometoaster\SiteConfigExtension
 */
class CampaignMonitorAPIKeySiteConfigExtension extends DataExtension
{
    private static $db = [
        'CampaignMonitorClientID' => 'Varchar(255)',
        'CampaignMonitorAPIKey'   => 'Varchar(255)',
    ];


    /**
     * Check if Campaign Monitor API key and Client ID are defined via a config
     *
     * @return bool
     */
    private function campaignMonitorDetailsConfigured()
    {
        return (Config::inst()->get('EditableCampaignMonitorField', 'api_key') && Config::inst()->get('EditableCampaignMonitorField', 'client_id'));
    }


    /**
     * Configure CMS fields
     *
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if (!$this->campaignMonitorDetailsConfigured()) {
            // Create CM tab
            $fields->findOrMakeTab('Root.CMConfig', 'Campaign Monitor');

            // Add CM config fields
            $fields->addFieldsToTab("Root.CMConfig", [
                TextField::create('CampaignMonitorClientID', 'Client ID'),
                TextField::create('CampaignMonitorAPIKey', 'API Key'),
            ]);
        }
    }
}
