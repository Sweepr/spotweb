<?php
class Services_NzbHandler_Display extends Services_NzbHandler_abs
{
	function __construct(Services_Settings_Base $settings, array $nzbHandling)
	{
		parent::__construct($settings, 'Display', 'Show', $nzbHandling);
	} # __construct

	public function processNzb($fullspot, $nzblist)
	{
		$nzb = $this->prepareNzb($fullspot, $nzblist);
		
		Header("Content-Type: " . $nzb['mimetype']);
		
		/* Een NZB file hoeft niet per se als attachment binnen te komen */
		switch($this->_nzbHandling['prepare_action']) {
			case 'zip'	: Header("Content-Disposition: attachment; filename=\"" . $nzb['filename'] . "\""); break;
			default		: Header("Content-Disposition: inline; filename=\"" . $nzb['filename'] . "\"");
		} # switch
		echo $nzb['nzb'];

	} # processNzb

} # class Services_NzbHandler_Display