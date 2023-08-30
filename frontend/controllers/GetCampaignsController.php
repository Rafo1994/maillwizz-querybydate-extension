<?php

defined('MW_PATH') || exit('No direct script access allowed');

Yii::import('frontend.controllers.SiteController');

class GetCampaignsController extends SiteController
{
    // the extension instance
    public $extension;

    protected $secretKey = "";

    protected $requiredArgs = [
        'secret',
        'campaign_uid',
    ];

    /**
     * Common settings
     */
    public function actionIndex()
    {
        foreach ($this->requiredArgs as $args) {
            if ( ! isset($_GET[$args])) {
                die("Missing $args");
            }
        }

        if ($_GET['secret'] !== $this->secretKey) {
            die("Wrong secret");
        }

        $per_page     = isset($_GET['per_page']) ?? 10;
        $current_page = isset($_GET['current_page']) ?? 1;

        $max_per_page = 50;
        $min_per_page = 10;

        if ($per_page < $min_per_page) {
            $perPage = $min_per_page;
        }

        if ($per_page > $max_per_page) {
            $per_page = $max_per_page;
        }

        if ($current_page < 1) {
            $current_page = 1;
        }


        $campaigns_uid = json_decode($_GET['campaign_uid']);
        $data          = [];

        foreach ($campaigns_uid as $campaign_uid) {
            $campaign = $this->loadCampaignByUid($campaign_uid);
            if (empty($campaign)) {
                $data[$campaign_uid] = false;
                continue;
            }

            $stats               = $campaign->getStats();
            $data[$campaign_uid] = [
                'campaign_status'        => (string)$campaign->status,
                'subscribers_count'      => $stats->getSubscribersCount(),
                'processed_count'        => $stats->getProcessedCount(),
                'delivery_success_count' => $stats->getDeliverySuccessCount(),
                'delivery_success_rate'  => $stats->getDeliverySuccessRate(),
                'delivery_error_count'   => $stats->getDeliveryErrorCount(),
                'delivery_error_rate'    => $stats->getDeliveryErrorRate(),
                'opens_count'            => $stats->getOpensCount(),
                'opens_rate'             => $stats->getOpensRate(),
                'unique_opens_count'     => $stats->getUniqueOpensCount(),
                'unique_opens_rate'      => $stats->getUniqueOpensRate(),
                'clicks_count'           => $stats->getClicksCount(),
                'clicks_rate'            => $stats->getClicksRate(),
                'unique_clicks_count'    => $stats->getUniqueClicksCount(),
                'unique_clicks_rate'     => $stats->getUniqueClicksRate(),
                'unsubscribes_count'     => $stats->getUnsubscribesCount(),
                'unsubscribes_rate'      => $stats->getUnsubscribesRate(),
                'complaints_count'       => $stats->getComplaintsCount(),
                'complaints_rate'        => $stats->getComplaintsRate(),
                'bounces_count'          => $stats->getBouncesCount(),
                'bounces_rate'           => $stats->getBouncesRate(),
                'hard_bounces_count'     => $stats->getHardBouncesCount(),
                'hard_bounces_rate'      => $stats->getHardBouncesRate(),
                'soft_bounces_count'     => $stats->getSoftBouncesCount(),
                'soft_bounces_rate'      => $stats->getSoftBouncesRate(),
                'internal_bounces_count' => $stats->getInternalBouncesCount(),
                'internal_bounces_rate'  => $stats->getInternalBouncesRate(),
            ];
        }

        $this->renderJson([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    public function loadCampaignByUid(string $campaign_uid): ?Campaign
    {
        $criteria = new CDbCriteria();
        $criteria->compare('campaign_uid', $campaign_uid);
        $criteria->compare('customer_id', (int)user()->getId());
        $criteria->addNotInCondition('status', [Campaign::STATUS_PENDING_DELETE]);

        /** @var Campaign|null $model */
        $model = Campaign::model()->find($criteria);

        return $model;
    }
}
