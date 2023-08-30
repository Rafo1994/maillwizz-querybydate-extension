<?php

defined('MW_PATH') || exit('No direct script access allowed');

Yii::import('frontend.controllers.SiteController');

class GetCampaignsController extends SiteController
{
    // the extension instance
    public $extension;

    protected $secretKey = "SBomhvdhDnDb1pjTZMeG1k4hJhAOxuKQ";

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

       /* $getList = Yii::app()->db->createCommand()->select('*')->from(Yii::app()->db->tablePrefix . 'list')->where(
            'list_uid=:list_uid', [':list_uid' => $_GET['list_uid']]
        )->queryRow();

        if ( ! $getList) {
            die("No list with this list_uid");
        }

        $table_name = Yii::app()->db->tablePrefix . 'list_subscriber';
        $list_id    = $getList['list_id'];
        $from_date  = $_GET['from_date'];
        $to_date    = $_GET['to_date'];

        $allSubscribers = Yii::app()->db->createCommand(
            "SELECT * FROM $table_name WHERE list_id=:list_id AND date_added BETWEEN (:from_date) and (:to_date)"
        )->bindValues([
            ':list_id'   => $list_id,
            ':from_date' => $from_date,
            ':to_date'   => $to_date,
        ])->queryAll();*/

        $this->renderJson([
            'status' => 'success',
            'data'   => $_GET,
        ]);
    }
}
