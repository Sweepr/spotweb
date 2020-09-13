<?php
error_reporting(2147483647);

try {
    require_once __DIR__ . '/vendor/autoload.php';

	/*
	 * Initialize the Spotweb base classes
	 */
	$bootstrap = new Bootstrap();
	list($settings, $daoFactory, $req) = $bootstrap->boot();

    # Initialize translation to english
	SpotTranslation::initialize('en_US');

	/*
	 * When PHP is running in safe mode, max execution time cannot be set,
	 * which is necessary on slow systems for retrieval and statistics generation
	 */
	if (ini_get('safe_mode')) {
		echo "WARNING: PHP safemode is enabled, maximum execution cannot be reset! Turn off safemode if this causes problems" . PHP_EOL . PHP_EOL;
	} # if

	/*
	 * When retrieval is run from the webinterface, we want to make
	 * sure this user is actually allowed to run retrieval.
	 */
	$svcUserRecord = new Services_User_Record($daoFactory, $settings);
	$svcUserAuth = new Services_User_Authentication($daoFactory, $settings);
	if (!SpotCommandline::isCommandline()) {
		/*
		 * An API key is required, so request it and try to
		 * create a session with it which we can use to validate
		 * the user with
		 */
		$apiKey = $req->getDef('apikey', '');
		$userSession = $svcUserAuth->verifyApi($apiKey);

		/*
		 * If the session failed or the user doesn't have access
		 * to retrieve spots, let the user know
		 */
		if (($userSession == false) || (!$userSession['security']->allowed(SpotSecurity::spotsec_retrieve_spots, ''))) { 
			throw new PermissionDeniedException(SpotSecurity::spotsec_retrieve_spots, '');
		} # if
		
		# Add the user's ip addres, we need it for sending notifications
		$userSession['session'] = array('ipaddr' => '');
	} else {
		$userSession['user'] = $svcUserRecord->getUser(SPOTWEB_ADMIN_USERID);
		$userSession['security'] = new SpotSecurity($daoFactory->getUserDao(),
													$daoFactory->getAuditDao(),
													$settings, 
													$userSession['user'], 
													'');
		$userSession['session'] = array('ipaddr' => '');
	} # if

	if (($settings->get('retention') > 0)) {
        echo "Removing Spot information which is beyond retention period." . PHP_EOL;

	$spotDao = $daoFactory->getSpotDao();
        $cacheDao = $daoFactory->getCacheDao();
        $commentDao = $daoFactory->getCommentDao();

		switch ($settings->get('retentiontype')) {
			case 'everything'		: {
				$spotDao->deleteSpotsRetention($settings->get('retention'));
                $cacheDao->expireCache($settings->get('retention'));
			} # case everything

			case 'fullonly'			: {
				$cacheDao->expireCache($settings->get('retention'));
				$commentDao->expireCommentsFull($settings->get('retention'));
				$spotDao->expireSpotsFull($settings->get('retention'));
			} # case fullonly
		} # switch

        echo "Removed Spot information which was beyond retention." . PHP_EOL;
	} # if

    ## Remove expired debuglogs
    #echo "Expiring debuglog entries, if any, ";
    #$daoFactory->getDebugLogDao()->expire();
    #echo "done. " . PHP_EOL;

}

catch(RetrieverRunningException $x) {
       echo PHP_EOL . PHP_EOL;
       echo "retriever.php is already running, pass '--force' to ignore this warning." . PHP_EOL;
}

catch(NntpException $x) {
	echo "Fatal error occured while connecting to the newsserver:" . PHP_EOL;
	echo "  (" . $x->getCode() . ") " . $x->getMessage() . PHP_EOL;
	echo PHP_EOL . PHP_EOL;
	echo $x->getTraceAsString();
	echo PHP_EOL . PHP_EOL;
	$retriever->quit();
}

catch(DatabaseConnectionException $x) {
	echo "Unable to connect to database: " . $x->getMessage() . PHP_EOL;
} # catch
