<?php 	$setpath = $tplHelper->makeBaseUrl('path');

     $sortType = $currentSession['user']['prefs']['defaultsortfield'];
 ?>
<div data-role="page" id="search"> 
	<div data-role="header" data-backbtn="false">
	    <h1>Zoek<?php require __DIR__.'/logincontrol.inc.php'; ?></h1>
	
	    <div data-role="navbar">
		    <ul>
			    <li><a href="#spots" data-icon="grid" >Spots</a></li>
			    <li><a href="#search" class="ui-btn-active" data-icon="search">Search</a></li>
			    <li><a href="#filters" data-icon="star">Filters</a></li>
                <li><a href="#" id="anchorLoginControl" data-icon="power">Logout</a></li>
		    </ul>
	    </div><!-- /navbar -->

    </div>
    <div data-role="content">
	    <div data-role="fieldcontain" >
		    <form id="filterform" action="<?php echo $setpath; ?>index.php?page=search#spots" method="get" data-ajax="false">
			    <fieldset data-role="controlgroup" data-type="horizontal" data-role="fieldcontain">
	         		
	         		    <input type="radio" id="radio-choice-1" name="sortby" value="" <?php echo $sortType == '' ? 'checked="checked"' : '' ?>>
	         		    <label for="radio-choice-1"><?php echo _('Relevance'); ?></label> 
	         	
                        <input type="radio" id="radio-choice-2"  name="sortby" value="stamp" <?php echo $sortType == 'stamp' ? 'checked="checked"' : '' ?>>
                        <label for="radio-choice-2"><?php echo _('Date'); ?></label> 
                    
                   </fieldset>
               
                   <fieldset data-role="controlgroup" data-type="horizontal" data-role="fieldcontain">
	         		    <input type="radio" name="search[type]" value="Titel" id="radio-choice-1b" checked="checked" />
	         		    <label for="radio-choice-1b">Title</label>
	
		         	    <input type="radio"  name="search[type]" value="Poster" id="radio-choice-2b" />
	    	     	    <label for="radio-choice-2b">Poster</label>
	
	        	 	    <input type="radio" name="search[type]" value="Tag" id="radio-choice-3b"  />
	         		    <label for="radio-choice-3b">Tag</label>
			    </fieldset>
		        <input type="search" type="text" name="search[text]" value="" />
    	    </form>
	    </div>
    </div>
</div>

<div data-role="page" id="filters"> 
	<div data-role="header" data-backbtn="false">
	    <h1>Filters<?php require __DIR__.'/logincontrol.inc.php'; ?></h1>

	    <div data-role="navbar">
		    <ul>
			    <li><a href="#spots" data-icon="grid" >Spots</a></li>
			    <li><a href="#search" data-icon="search">Search</a></li>
			    <li><a href="#filters" data-icon="star" class="ui-btn-active" >Filters</a></li>
			    <?php if (($currentSession['user']['userid'] == $settings->get('nonauthenticated_userid')) && (empty($loginresult))) { ?>
                	    <li><a href="index.php?page=login" data-icon="power">Login</a></li>
			    <?php } else { ?>
			    		<li><a href="#" id="anchorLoginControl" data-icon="power">Logout</a></li>
			    <?php } ?>

		    </ul>
	    </div><!-- /navbar -->

    </div>
	
    <div data-role="content">
    <ul data-role="listview" data-theme="d" data-dividertheme="b">
	<br>
    <?php
        function processFilters($tplHelper, $count_newspots, $filterList, $defaultSortField)
        {
            $selfUrl = $tplHelper->makeSelfUrl('path');

            foreach ($filterList as $filter) {
                $strFilter = $tplHelper->getPageUrl('index').'&amp;search[tree]='.$filter['tree'];
                if (!empty($filter['valuelist'])) {
                    foreach ($filter['valuelist'] as $value) {
                        $strFilter .= '&amp;search[value][]='.$value;
                    } // foreach
                } // if
                if (!empty($filter['sorton'])) {
                    $strFilter .= '&amp;sortby='.$filter['sorton'].'&amp;sortdir='.$filter['sortorder'];
                } else {
                    $sortType = $defaultSortField;
                } // if

                // escape the filter values
                $filter['title'] = htmlentities($filter['title'], ENT_NOQUOTES, 'UTF-8');
                $filter['icon'] = htmlentities($filter['icon'], ENT_NOQUOTES, 'UTF-8');

                // Output HTML
				
                echo '<li>';
				echo '<a href="'.$strFilter.'#spots" rel="external"><img src="templates/mobile/icons/'.$filter['icon'].'.png" class="ui-li-icon"/>'.$filter['title'].'</a>';     										
				echo '</li>';
				
				//echo '<li>';
				//processFilters($tplHelper, $count_newspots, $filter['children'], $defaultSortField);
				//echo '</li>';

            } // foreach
        } // processFilters

        processFilters($tplHelper, false, $filters, $currentSession['user']['prefs']['defaultsortfield']);
    ?>
    </ul>
    </div>
</div>