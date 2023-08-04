<?php

defined( 'MW_PATH' ) || exit( 'No direct script access allowed' );

Yii::import( 'frontend.controllers.SiteController' );

class QuerybydateController extends SiteController {
	// the extension instance
	public $extension;

	protected $secretKey = "SBomhvdhDnDb1pjTZMeG1k4hJhAOxuKQ";

	protected $requiredArgs = [
		"secret",
		"list_uid",
		"from_date",
		"to_date",
	];

	/**
	 * Common settings
	 */
	public function actionIndex() {
		// example url
		// https://m.cashify.team/index.php/listaddsub?secret=[SECRET]&list_uid=[LIST_UID]&from_date=2023-22-22&to_date=2323-22-11

		foreach ( $this->requiredArgs as $args ) {
			if ( ! isset( $_GET[ $args ] ) ) {
				die( "Missing $args" );
			}
		}

		if ( $_GET['secret'] !== $this->secretKey ) {
			die( "Wrong secret" );
		}

		$getList = Yii::app()->db->createCommand()->select( '*' )->from( Yii::app()->db->tablePrefix . 'list' )->where( 'list_uid=:list_uid',
			[ ':list_uid' => $_GET['list_uid'] ] )->queryRow();

		if ( ! $getList ) {
			die( "No list with this list_uid" );
		}

		$table_name = Yii::app()->db->tablePrefix . 'list_subscriber';
		$list_id = $getList['list_id'];
		$from_date  = $_GET['from_date'];
		$to_date    = $_GET['to_date'];

		$allSubscribers = Yii::app()->db->createCommand( "SELECT * FROM $table_name WHERE list_id=:list_id AND date_added BETWEEN (:from_date) and (:to_date)" )->bindValues( [
			':list_id' => $list_id,
			':from_date' => $from_date,
			':to_date' => $to_date,
		] )->queryAll();

		var_dump( count($allSubscribers) );

	}
}
