<?php
    require __DIR__.'/includes/form-messages.inc.php';
    $pagetitle = _('Change user preferences');

    /* If we run embedded in a dialog, dont run the HTML header as that messes up things */
    if (!$dialogembedded) {

        /* Redirect to the calling page */
        if ($result->isSuccess()) {
            $tplHelper->redirect($http_referer);

            return;
        } // if

        echo '</div>';
    } else {
        if ($result->isSubmitted()) {
            /* Show the results in JSON */
            showResults($result);

            return;
        } // if
    } // else

if (!$dialogembedded) { ?>
<?php
$setpath = $tplHelper->makeBaseUrl('path');
?>

<div data-role="page" id="settings"> 
	<div data-role="header" data-position="fixed">
	<a href='<?php echo $setpath; ?>index.php' data-transition='fade' rel="external" data-icon="back" class="ui-btn-left ">Back</a>
		<h1>Settings<?php require __DIR__.'/getusername.inc.php'; ?></h1>
	
<?php } ?>
</div>

<div data-role="collapsible">
<h3>General settings</h3>
				<dl>
			<form class="edituserprefsform" name="edituserprefsform" action="<?php echo $tplHelper->makeEditUserPrefsAction(); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="edituserprefsform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('edituserprefsform'); ?>">
	<input type="hidden" name="edituserprefsform[http_referer]" value="<?php echo $http_referer; ?>">
	<input type="hidden" name="userid" value="<?php echo htmlspecialchars($spotuser['userid']); ?>">
<?php if ($dialogembedded) { ?>
	<input type="hidden" name="dialogembedded" value="1">
<?php } ?>
					<center><label for="edituserprefsform[user_language]"><?php echo _('Language to use in Spotweb:'); ?></label></center>
						<center><select name="edituserprefsform[user_language]">
							<?php foreach ($tplHelper->getConfiguredLanguages() as $langkey => $langvalue) { ?>
								<option <?php if ($edituserprefsform['user_language'] == $langkey) {echo 'selected="selected"';} ?> value="<?php echo $langkey; ?>"><?php echo $langvalue; ?></option>
							<?php } ?> 
						</select></center>
			
					<center><label for="edituserprefsform[perpage]"><?php echo _('Amount of spots per page?'); ?></label></center>				
						<center><select name="edituserprefsform[perpage]">
							<option <?php if ($edituserprefsform['perpage'] == 25) {echo 'selected="selected"';} ?> value="25">25</option>
							<option <?php if ($edituserprefsform['perpage'] == 50) {echo 'selected="selected"';} ?> value="50">50</option>
							<option <?php if ($edituserprefsform['perpage'] == 100) {echo 'selected="selected"';} ?> value="100">100</option>
							<option <?php if ($edituserprefsform['perpage'] == 250) {echo 'selected="selected"';} ?> value="250">250</option>
						</select></center>
					
					<center><label for="edituserprefsform[defaultsortfield]"><?php echo _('Standard searchorder?'); ?></label></center>
					<center>
						<select name="edituserprefsform[defaultsortfield]">
							<option <?php if ($edituserprefsform['defaultsortfield'] == '') {echo 'selected="selected"';} ?> value=""><?php echo _('Relevance'); ?></option>
							<option <?php if ($edituserprefsform['defaultsortfield'] == 'stamp') {echo 'selected="selected"';} ?> value="stamp"><?php echo _('Latest first'); ?></option>
						</select>
					</center>

					<center><label for="edituserprefsform[date_formatting]"><?php echo _('Formatting of dates'); ?></label></center>
					<center>
						<select name="edituserprefsform[date_formatting]">
							<option <?php if ($edituserprefsform['date_formatting'] == 'human') {echo 'selected="selected"';} ?> value="human" selected><?php echo _('Human'); ?></option>
							<option <?php if ($edituserprefsform['date_formatting'] == '%a, %d-%b-%Y (%H:%M)') {echo 'selected="selected"';} ?> value="%a, %d-%b-%Y (%H:%M)"><?php echo strftime('%a, %d-%b-%Y (%H:%M)', time()); ?></option>
							<option <?php if ($edituserprefsform['date_formatting'] == '%d-%m-%Y (%H:%M)') {echo 'selected="selected"';} ?> value="%d-%m-%Y (%H:%M)"><?php echo strftime('%d-%m-%Y (%H:%M)', time()); ?></option>
						</select>
					</center>
					
	<?php if ($tplHelper->allowed(SpotSecurity::spotsec_select_template, '')) { ?>					
					<center><label for="edituserprefsform[normal_template]"><?php echo _('Template for non-mobile devices'); ?></label></center>
					<center>
						<select name="edituserprefsform[normal_template]">
							<?php foreach ($tplHelper->getConfiguredTemplates() as $tplkey => $tplvalue) { ?>
								<?php if ($tplHelper->allowed(SpotSecurity::spotsec_select_template, $tplkey)) { ?>					
									<option <?php if ($edituserprefsform['normal_template'] == $tplkey) {echo 'selected="selected"';} ?> value="<?php echo $tplkey; ?>"><?php echo $tplvalue; ?></option>
								<?php } ?> 
							<?php } ?> 
						</select>
					</center>

					<center><label for="edituserprefsform[mobile_template]"><?php echo _('Template for mobiles'); ?></label></center>
					<center>
						<select name="edituserprefsform[mobile_template]">
							<?php foreach ($tplHelper->getConfiguredTemplates() as $tplkey => $tplvalue) { ?>
								<?php if ($tplHelper->allowed(SpotSecurity::spotsec_select_template, $tplkey)) { ?>					
									<option <?php if ($edituserprefsform['mobile_template'] == $tplkey) {echo 'selected="selected"';} ?> value="<?php echo $tplkey; ?>"><?php echo $tplvalue; ?></option>
								<?php } ?> 
							<?php } ?> 
						</select>
					</center>

					<center><label for="edituserprefsform[tablet_template]"><?php echo _('Template for tablets'); ?></label></center>
					<center>
						<select name="edituserprefsform[tablet_template]">
							<?php foreach ($tplHelper->getConfiguredTemplates() as $tplkey => $tplvalue) { ?>
								<?php if ($tplHelper->allowed(SpotSecurity::spotsec_select_template, $tplkey)) { ?>					
									<option <?php if ($edituserprefsform['tablet_template'] == $tplkey) {echo 'selected="selected"';} ?> value="<?php echo $tplkey; ?>"><?php echo $tplvalue; ?></option>
								<?php } ?> 
							<?php } ?> 
						</select>
					</center>
<?php } ?>
	
					<center><label for="edituserprefsform[nzb_search_engine]"><?php echo _('What NZB searchengine shall we use?'); ?></label></center>
					<center>
						<select name="edituserprefsform[nzb_search_engine]">
							<option <?php if ($edituserprefsform['nzb_search_engine'] == 'binsearch') {echo 'selected="selected"';} ?> value="binsearch">Binsearch</option>
							<option <?php if ($edituserprefsform['nzb_search_engine'] == 'nzbindex') {echo 'selected="selected"';} ?> value="nzbindex">NZBIndex</option>
						</select>
					</center>
<br>
		<center><div class="editprefsButtons">
			<input class="greyButton" type="submit" name="edituserprefsform[submitedit]" value="<?php echo _('Save'); ?>">
		<?php if (!$dialogembedded) { ?>
			<input class="greyButton" type="submit" name="edituserprefsform[submitcancel]" value="<?php echo _('Cancel'); ?>">
		<?php } ?>
			<div class="clear"></div>
		</div></center>
	</form>
	</dl>
</div>
	
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, '')) { ?>

<div data-role="collapsible">
<h3>NZB handeling</h3>				
			<fieldset>
				<dl>
				<form class="edituserprefsform" name="edituserprefsform" action="<?php echo $tplHelper->makeEditUserPrefsAction(); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="edituserprefsform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('edituserprefsform'); ?>">
	<input type="hidden" name="edituserprefsform[http_referer]" value="<?php echo $http_referer; ?>">
	<input type="hidden" name="userid" value="<?php echo htmlspecialchars($spotuser['userid']); ?>">
<?php if ($dialogembedded) { ?>
	<input type="hidden" name="dialogembedded" value="1">
<?php } ?>
					<center><label for="edituserprefsform[nzbhandling][action]"><?php echo _('What shall we do with NZB files?'); ?></label></center>
					<center>
						<select id="nzbhandlingselect" name="edituserprefsform[nzbhandling][action]">
							<option data-fields="" <?php if ($edituserprefsform['nzbhandling']['action'] == 'disable') {echo 'selected="selected"';} ?> value="disable"><?php echo _('No intergration with download client'); ?></option>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'push-sabnzbd')) { ?>
							<option data-fields="sabnzbd" <?php if ($edituserprefsform['nzbhandling']['action'] == 'push-sabnzbd') {echo 'selected="selected"';} ?> value="push-sabnzbd"><?php echo _('Call SABnzbd throught HTTP by SpotWeb'); ?></option>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'client-sabnzbd')) { ?>
							<option data-fields="sabnzbd" <?php if ($edituserprefsform['nzbhandling']['action'] == 'client-sabnzbd') {echo 'selected="selected"';} ?> value="client-sabnzbd"><?php echo _("Run SABnzbd through users' browser"); ?></option>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'save')) { ?>
							<option data-fields="localdir" <?php if ($edituserprefsform['nzbhandling']['action'] == 'save') {echo 'selected="selected"';} ?> value="save"><?php echo _('Save to file op disk'); ?></option>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'runcommand')) { ?>
							<option data-fields="localdir runcommand" <?php if ($edituserprefsform['nzbhandling']['action'] == 'runcommand') {echo 'selected="selected"';} ?> value="runcommand"><?php echo _('Save file to disk and run a command'); ?></option>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'nzbget')) { ?>
							<option data-fields="nzbget" <?php if ($edituserprefsform['nzbhandling']['action'] == 'nzbget') {echo 'selected="selected"';} ?> value="nzbget"><?php echo _('Call NZBGet through HTTP by SpotWeb'); ?></option>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'nzbvortex')) { ?>
							<option data-fields="nzbvortex" <?php if ($edituserprefsform['nzbhandling']['action'] == 'nzbvortex') {echo 'selected="selected"';} ?> value="nzbvortex"><?php echo _('Call NZBVortex through HTTP by SpotWeb'); ?></option>
<?php } ?>
						</select>
					</center>

					<center><label for="edituserprefsform[nzbhandling][prepare_action]"><?php echo _('What shall we do with multiple NZB files?'); ?></label></center>
					<center>
						<select name="edituserprefsform[nzbhandling][prepare_action]">
							<option <?php if ($edituserprefsform['nzbhandling']['prepare_action'] == 'merge') { echo 'selected="selected"';} ?> value="merge"><?php echo _('Merge NZB files'); ?></option>
							<option <?php if ($edituserprefsform['nzbhandling']['prepare_action'] == 'zip') { echo 'selected="selected"'; } ?> value="zip"><?php echo _('Compress NZB files to 1 zip-file'); ?></option>
						</select>
					</center>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'save') || $tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'runcommand')) { ?>
					<fieldset id="nzbhandling-fieldset-localdir">
						<center><label for="edituserprefsform[nzbhandling][local_dir]"><?php echo _('Where shall we store the file?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][local_dir]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['local_dir']); ?>"></center>
					</fieldset>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'runcommand')) { ?>
					<fieldset id="nzbhandling-fieldset-runcommand">
						<center><label for="edituserprefsform[nzbhandling][command]"><?php echo _('What programm should be executed?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][command]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['command']); ?>"></center>
					</fieldset>
<?php } ?>

					<!-- Sabnzbd -->
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'push-sabnzbd') || $tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'client-sabnzbd')) { ?>
					<fieldset id="nzbhandling-fieldset-sabnzbd">
						<center><label for="edituserprefsform[nzbhandling][sabnzbd][url]"><?php echo _('URL to SABnzbd (HTTP, path and portnumber where SABnzbd is installed)?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][sabnzbd][url]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['sabnzbd']['url']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][sabnzbd][apikey]"><?php echo _('API key for SABnzbd?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][sabnzbd][apikey]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['sabnzbd']['apikey']); ?>"></center>

                        <center><label for="edituserprefsform[nzbhandling][sabnzbd][username]"><?php echo _('Username for sabnzbd? (used for HTTP authentication, usually best be left empty)'); ?></label></center>
                        <center><input type="input" name="edituserprefsform[nzbhandling][sabnzbd][username]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['sabnzbd']['username']); ?>" /></center>

                        <center><label for="edituserprefsform[nzbhandling][sabnzbd][password]"><?php echo _('Password for sabnzbd?'); ?></label></center>
                        <center><input type="input" name="edituserprefsform[nzbhandling][sabnzbd][password]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['sabnzbd']['password']); ?>"></center>
					</fieldset>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'nzbget')) { ?>
					<fieldset id="nzbhandling-fieldset-nzbget">
						<!-- NZBget -->
						<input type="hidden" name="edituserprefsform[nzbhandling][nzbget][timeout]" value="30">
						
						<center><label for="edituserprefsform[nzbhandling][nzbget][host]"><?php echo _('Hostname of nzbget?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbget][host]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbget']['host']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][nzbget][ssl]"><?php echo _('Use SSL?'); ?></label></center>
						<center><input type="checkbox" class="enabler" name="edituserprefsform[nzbhandling][nzbget][ssl]" id="use_ssl" <?php if ($edituserprefsform['nzbhandling']['nzbget']['ssl']) {echo 'checked="checked"';} ?>></center>
						
						<center><label for="edituserprefsform[nzbhandling][nzbget][port]"><?php echo _('Portnumber of nzbget?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbget][port]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbget']['port']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][nzbget][username]"><?php echo _('Username for nzbget?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbget][username]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbget']['username']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][nzbget][password]"><?php echo _('Password for nzbget?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbget][password]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbget']['password']); ?>"></center>
					</fieldset>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_download_integration, 'nzbvortex')) { ?>
					<fieldset id="nzbhandling-fieldset-nzbvortex">
						<!-- NZBVortex -->
						<center><label for="edituserprefsform[nzbhandling][nzbvortex][host]"><?php echo _('Hostname of NZBVortex?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbvortex][host]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbvortex']['host']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][nzbvortex][port]"><?php echo _('Portnumber of NZBVortex?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbvortex][port]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbvortex']['port']); ?>"></center>

						<center><label for="edituserprefsform[nzbhandling][nzbvortex][apikey]"><?php echo _('API-Key for NZBVortex?'); ?></label></center>
						<center><input type="input" name="edituserprefsform[nzbhandling][nzbvortex][apikey]" value="<?php echo htmlspecialchars($edituserprefsform['nzbhandling']['nzbvortex']['apikey']); ?>"></center>
					</fieldset>
<?php } ?>
		<center><div class="editprefsButtons">
			<input class="greyButton" type="submit" name="edituserprefsform[submitedit]" value="<?php echo _('Save'); ?>">
<?php if (!$dialogembedded) { ?>
			<input class="greyButton" type="submit" name="edituserprefsform[submitcancel]" value="<?php echo _('Cancel'); ?>">
<?php } ?>
			<div class="clear"></div>
		</div></center>
</form>
				</dl>
					</fieldset>
<?php } ?>
</div>

<div data-role="collapsible">
<h3>Notifications</h3>
<form class="edituserprefsform" name="edituserprefsform" action="<?php echo $tplHelper->makeEditUserPrefsAction(); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="edituserprefsform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('edituserprefsform'); ?>">
	<input type="hidden" name="edituserprefsform[http_referer]" value="<?php echo $http_referer; ?>">
	<input type="hidden" name="userid" value="<?php echo htmlspecialchars($spotuser['userid']); ?>">
<?php if ($dialogembedded) { ?>
	<input type="hidden" name="dialogembedded" value="1">
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, '') && $tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, '')) { ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'boxcar')) { ?>
<script type="text/javascript">
    $(function () {
        $("#use_boxcar").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_boxcar").show();
            } else {
                $("#content_use_boxcar").hide();
            }
        });
    });
</script>
			<fieldset data-role="controlgroup">
				<center><label for="use_boxcar"><?php echo _('Use Boxcar?'); ?></label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][boxcar][enabled]" id="use_boxcar" <?php if ($edituserprefsform['notifications']['boxcar']['enabled']) { echo 'checked="checked"';} ?>></center>
				<div id="content_use_boxcar" style="display: none">
				<fieldset id="content_use_boxcar" class="notificationSettings">
				<br>
					<center><label for="edituserprefsform[notifications][boxcar][email]"><?php echo _('Boxcar e-mail address?'); ?></label></center>
					<center><input type="input" name="edituserprefsform[notifications][boxcar][email]" value="<?php echo htmlspecialchars($edituserprefsform['notifications']['boxcar']['email']); ?>"></center>

					<?php showNotificationOptions('boxcar', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
<?php } ?>
<script type="text/javascript">
    $(function () {
        $("#use_email").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_email").show();
            } else {
                $("#content_use_email").hide();
            }
        });
    });
</script>	
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'email')) { ?>

			<fieldset data-role="controlgroup">
				<center><label for="use_email"><?php echo _('Send e-mail to').' '.$spotuser['mail']; ?>?</label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][email][enabled]" id="use_email" <?php if ($edituserprefsform['notifications']['email']['enabled']) { echo 'checked="checked"';} ?>></center>
				<div id="content_use_email" style="display: none">
				<fieldset id="content_use_email" class="notificationSettings">
					<?php showNotificationOptions('email', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'growl')) { ?>
<script type="text/javascript">
    $(function () {
        $("#use_growl").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_growl").show();
            } else {
                $("#content_use_growl").hide();
            }
        });
    });
</script>
			<fieldset data-role="controlgroup">
				<center><label for="use_growl"><?php echo _('Use Growl?'); ?></label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][growl][enabled]" id="use_growl" <?php if ($edituserprefsform['notifications']['growl']['enabled']) {echo 'checked="checked"';} ?>></center>
				<div id="content_use_growl" style="display: none">
				<fieldset id="content_use_growl" class="notificationSettings">
					<center><label for="edituserprefsform[notifications][growl][host]"><?php echo _('Growl IP-address?'); ?></label></center>
					<center><input type="input" name="edituserprefsform[notifications][growl][host]" value="<?php echo htmlspecialchars($edituserprefsform['notifications']['growl']['host']); ?>"></center>

					<center><label for="edituserprefsform[notifications][growl][password]"><?php echo _('Growl password?'); ?></label></center>
					<center><input type="password" name="edituserprefsform[notifications][growl][password]" value="<?php echo htmlspecialchars($edituserprefsform['notifications']['growl']['password']); ?>"></center>

					<?php showNotificationOptions('growl', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'nma')) { ?>
<script type="text/javascript">
    $(function () {
        $("#use_nma").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_nma").show();
            } else {
                $("#content_use_nma").hide();
            }
        });
    });
</script>
			<fieldset data-role="controlgroup">
				<center><label for="use_nma"><?php echo _('Use Notiy My Android?'); ?></label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][nma][enabled]" id="use_nma" <?php if ($edituserprefsform['notifications']['nma']['enabled']) {echo 'checked="checked"';} ?>></center>
				<div id="content_use_nma" style="display: none">
				<fieldset id="content_use_nma" class="notificationSettings">
					<center><label for="edituserprefsform[notifications][nma][api]">Notify My Android <a href="https://www.notifymyandroid.com/account.php"><?php echo _('API key'); ?></a>?</label></center>
					<center><input type="text" name="edituserprefsform[notifications][nma][api]" value="<?php echo htmlspecialchars($edituserprefsform['notifications']['nma']['api']); ?>"></center>

					<?php showNotificationOptions('nma', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
<?php } ?>

<?php if (version_compare(PHP_VERSION, '5.3.0') >= 0) { ?>
	<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'prowl')) { ?>
<script type="text/javascript">
    $(function () {
        $("#use_prowl").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_prowl").show();
            } else {
                $("#content_use_prowl").hide();
            }
        });
    });
</script>
			<fieldset data-role="controlgroup">
				<center><label for="use_prowl"><?php echo _('Use Prowl?'); ?></label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][prowl][enabled]" id="use_prowl" <?php if ($edituserprefsform['notifications']['prowl']['enabled']) {echo 'checked="checked"';} ?>></center>
				<div id="content_use_prowl" style="display: none">
				<fieldset id="content_use_prowl" class="notificationSettings">
					<center><label for="edituserprefsform[notifications][prowl][apikey]"><?php echo _('Prowl <a href="https://www.prowlapp.com/api_settings.php">API key'); ?></a>?</label></center>
					<center><input type="text" name="edituserprefsform[notifications][prowl][apikey]" value="<?php echo htmlspecialchars($edituserprefsform['notifications']['prowl']['apikey']); ?>"></center>

					<?php showNotificationOptions('prowl', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
	<?php } ?>
<?php } ?>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'twitter')) { ?>
<script type="text/javascript">
    $(function () {
        $("#use_twitter").click(function () {
            if ($(this).is(":checked")) {
                $("#content_use_twitter").show();
            } else {
                $("#content_use_twitter").hide();
            }
        });
    });
</script>
			<fieldset data-role="controlgroup">
				<center><label for="use_twitter"><?php echo _('Use Twitter?'); ?></label></center>
				<center><input type="checkbox" class="enabler" name="edituserprefsform[notifications][twitter][enabled]" id="use_twitter" <?php if ($edituserprefsform['notifications']['twitter']['enabled']) {echo 'checked="checked"';} ?>></center>
				<div id="content_use_twitter" style="display: none">
				<fieldset id="content_use_twitter" class="notificationSettings">
					<div class="testNotification" id="twitter_result"><b><?php echo _('Click on "Ask permission". This opens a new page with a PIN number.').'<br />'._('Attention: If nothing happens please check your pop-up blocker'); ?></b></div>
					<input type="button" value="Toestemming Vragen" id="twitter_request_auth" />
	<?php if (!empty($edituserprefsform['notifications']['twitter']['screen_name'])) { ?>
					<input type="button" id="twitter_remove" value="Account <?php echo htmlspecialchars($edituserprefsform['notifications']['twitter']['screen_name']); ?> verwijderen" />
	<?php } ?>
					<?php showNotificationOptions('twitter', $edituserprefsform, $tplHelper); ?>
				</fieldset>
				</div>
			</fieldset>
<?php } ?>
<?php } ?>
		<center><div class="editprefsButtons">
			<input class="greyButton" type="submit" name="edituserprefsform[submitedit]" value="<?php echo _('Save'); ?>">
<?php if (!$dialogembedded) { ?>
			<input class="greyButton" type="submit" name="edituserprefsform[submitcancel]" value="<?php echo _('Cancel'); ?>">
<?php } ?>
			<div class="clear"></div>
		</div></center>
</form>
</div>

<?php
    function showNotificationOptions($provider, $edituserprefsform, $tplHelper)
    {
        echo '<fieldset>'.PHP_EOL;

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'watchlist_handled') && $tplHelper->allowed(SpotSecurity::spotsec_keep_own_watchlist, '')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][watchlist_handled]">'._('Send message when a spot is added or deleted from the watchlist?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][watchlist_handled]"';
            if ($edituserprefsform['notifications'][$provider]['events']['watchlist_handled']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'nzb_handled')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][nzb_handled]">'._("Send message when a NZB file is send? Doesn't work for client-SABnzbd.").'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][nzb_handled]"';
            if ($edituserprefsform['notifications'][$provider]['events']['nzb_handled']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'retriever_finished')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][retriever_finished]">'._('Send message when updating spots is finish?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][retriever_finished]"';
            if ($edituserprefsform['notifications'][$provider]['events']['retriever_finished']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'report_posted') && $tplHelper->allowed(SpotSecurity::spotsec_report_spam, '')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][report_posted]">'._('Send message when Spam Reports has been send?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][report_posted]"';
            if ($edituserprefsform['notifications'][$provider]['events']['report_posted']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'spot_posted') && $tplHelper->allowed(SpotSecurity::spotsec_post_spot, '')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][spot_posted]">'._('Send message when posting a spot has finished?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][spot_posted]"';
            if ($edituserprefsform['notifications'][$provider]['events']['spot_posted']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'user_added')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][user_added]">'._('Send message when a user has been added?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][user_added]"';
            if ($edituserprefsform['notifications'][$provider]['events']['user_added']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_types, 'newspots_for_filter')) {
            echo '<center><label for="edituserprefsform[notifications]['.$provider.'][events][newspots_for_filter]">'._('Send message when an enabled filter has new spots available?').'</label></center>'.PHP_EOL;
            echo '<center><input type="checkbox" name="edituserprefsform[notifications]['.$provider.'][events][newspots_for_filter]"';
            if ($edituserprefsform['notifications'][$provider]['events']['newspots_for_filter']) {
                echo 'checked="checked"';
            } // if
            echo '></center>'.PHP_EOL.PHP_EOL;
        } // if

        echo '</fieldset>'.PHP_EOL;
    } // notificationOptions

// Initialzie the user preferences screen
if (!$dialogembedded) {
    $toRunJsCode = 'initializeUserPreferencesScreen();';
    require_once __DIR__.'/footer.inc.php';
} // if