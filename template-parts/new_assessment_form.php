<form name="newAssessment" method="post" id="newAssessment">
	<div class="doiclass formHalfWidth">
	<p><label for="doi">DOI: </label><br>
		<input type="text" name="doi" id="doi" maxlength="100" placeholder="Digital Object Identifier" value="<?php echo($article_doi) ?>" ></p>
	</div>

	<div class="initiatorclass formHalfWidth">
	<p><label for="initiator">Initiator: </label><br>
		<input type="text" name="initiator" id="initiator" maxlength="100" placeholder="Name of initiator" value="<?php echo($userName); ?>" readonly></p>
	</div>

	<?php 
	// cget_user_role( $userID ) === "editor"
	// echo( get_user_role( $userID ) );
	// echo( get_user_role() );
	// echo( $userID );
	if ( current_user_can( 'publish_pages', $post->ID )  ) { ?>		  					
		<b>Editors</b>
		<div class="flex-container newAssessmentEditor" id="newAssessmentEditor">
			<div>
			<p><label for="editor1">Editor 1: </label><br>
			<select name="editor1" form="newAssessment">
				<option value="">Select editor</option>
				<?php
	                foreach ( $allEditors as $user ) {					
	    				echo '<option value="Editor_' . $user->ID . '">' . $user->display_name . '</option>' . PHP_EOL;
					}
	            ?>
			</select></p>
		</div>
			<div>
			<p><label for="editor2">Editor 2: </label><br>
			<select name="editor2" form="newAssessment" onChange="addEditor('newAssessmentEditor', 2);">
				<option value="">Select editor</option>
				<?php
	                foreach ( $allEditors as $user ) {					
	    				echo '<option value="Editor_' . $user->ID . '">' . $user->display_name . '</option>' . PHP_EOL;
					}
	            ?>
			</select></p>
		</div>							
	</div>
	<?php 
	} ?>

	<div id="titleBox">
	<p>
		<label for="title"><span id="title">Title: </span><span class="requiredfield">*</span><br>
				<textarea name="title" id="title" maxlength="10000" rows="2" cols="50"><?php echo($post_title); ?></textarea>
			</label>
		</p>
	</div>

	<div id="referenceBox">
	<p><label for="reference"><span id="reference">Reference: </span><span class="requiredfield">*</span><br>
	Please cite the study as completely as possible. Authors, title, journal/publisher, year, pages, ...	
		<textarea name="reference" id="reference" maxlength="10000" rows="6" cols="50"><?php echo($article_reference); ?></textarea></label></p>
	</div>						
	<!-- <p>Different fields of science have different formats for the reference. In climatology the most common format is: $LastName1, $Initials1, $Initials2 $LastName2, (if more than 50 authors, the rest is et al.) $Year: $Title. <i>$Journal</i>, <b>Volume</b>, pp. $firstPage-$lastPage. https://doi.org/$doi

	Later it would be good if the editors can specify a format in the backend. How would one pass this to the JavaScript on the front end? Write it in the JS code using PHP? Or have JS read a hidden form field?

	If we cannot find the DOI we could also guess the information below from the hand written reference in this box. Thus it would probably be good to store whether this reference was machine generated or manual (and may thus contain errors).
	</p> -->

	<div id="abstractBox">
	<p><label for="abstract"><span id="commenttext">Abstract: </span><br>
		<textarea name="article_abstract" id="abstract" maxlength="10000" rows="10" cols="60"><?php echo($article_abstract); ?></textarea></label></p></div>
	</div>

	<!-- <fieldset> -->
	<p class="newAssessementAuthorsLabel"><b>Authors:</b></p>
	<div class="newAssessementAuthorBox" id="newAssessementAuthorBox">	
		<div class="OneAuthor">
			<div class="newAssessementAuthorNo">
			</div>
			<div class="newAssessementAuthorGivenName">
				<label for="author1">Given name or initials: </label>			  						
				</div>
			<div class="newAssessementAuthorFamilyName">
				<label for="author1">Family name: </label>		
				</div>
			</div>

		<div class="OneAuthor">
			<div class="newAssessementAuthorNo">
				Author 1
			</div>
			<div class="newAssessementAuthorGivenName">									
					<input type="text" name="given_name_author1" id="givenNameauthor1" maxlength="100" placeholder="Given name of author" onfocus="addAuthor('newAssessementAuthorBox', 1)">
				</div>
			<div class="newAssessementAuthorFamilyName">
					<input type="text" name="family_name_author1" id="familyNameauthor1" maxlength="100" placeholder="Family name of author" onfocus="addAuthor('newAssessementAuthorBox', 1)">
				</div>
			</div>
		</div>
		<!-- <p>Each time a name is filled in a next row for the next name should appear. Best store ORCID ID and affiliation as well, if available. That can help later to make pages per author.</p> 

	Also add a radio button so that people have a second option to add authors: a bulk entry in a text field with a well defined format. lastName1, firstName1; lastName2, firstName2; ...
		-->

		<!--
	<p><label for="title">Title: </label><br>
		<input type="text" name="title_automatic" id="title" maxlength="1000" placeholder="Title of the study"></p>
		-->
	<!-- <p>Do this double to have all information complete here, or is that confusing. Can simply copy the above entry.</p> -->

	<div class="newAssessementJournalNameBox">
		<div class="newAssessementFullJournalName formFullWidth">
			<p><label for="fullJournalName">Full journal name: </label><br>
				<input type="text" name="full_journal_name" id="fullJournalName" maxlength="1000" placeholder="Name of the journal written out." value="<?php echo($full_journal_name); ?>"></p>
			<!-- <p>Called container-title in the CrossRef API.</p> -->
		</div>
		<div class="newAssessementShortJournalName formHalfWidth">
			<p><label for="shortJournalName">Short journal name: </label><br>
				<input type="text" name="short_journal_name" id="shortJournalName" maxlength="1000" placeholder="Typical abbreviation used to cite it." value="<?php echo($short_journal_name); ?>"></p>
			<!-- <p>Called short-container-title in the CrossRef API.</p> -->
		</div>
	</div>

	<div class="newAssessementYear formHalfWidth">
		<p><label for="publication_year">Year: </label><br>
			<input type="text" name="publication_year" id="publication_year" maxlength="1000" placeholder="Publication year" value="<?php echo($publication_year); ?>"></p>
			<!-- published-print date-parts	[0], date-parts	[1] is the month -->
		</div>

	<div class="newAssessementVolume formHalfWidth">
		<p><label for="volume">Journal volume: </label><br>
			<input type="text" name="volume" id="volume" maxlength="1000" placeholder="Volume of the journal." value="<?php echo($article_volume); ?>"></p>
	</div>

	<div class="newAssessementPages formHalfWidth">
		<p><label for="pages">Pages: </label><br>
			<input type="text" name="pages" id="pages" maxlength="1000" placeholder="FirstPage-LastPage" value="<?php echo($article_pages); ?>"></p>
		<!-- <p>Called page in the CrossRef API.</p> -->
	</div>
	
	<!--		  					
								Reference details
	In case that makes a difference for how the code is organized: There are more services than CrossRef. For example, DataCite is sometimes used for manuscripts (it is cheaper). And there are databases with OpenAccess journals that may (or may not) contain more information. Maybe also unpaywall could be added to see if there are any open copies of the article, if not we could ask the user if they know of an open copy.

	https://datacite.org/							
	https://search.datacite.org/api?q=10.1002%2Fjoc.5458&fl=doi,creator,title,publisher,publicationYear,datacentre&fq=is_active:true&fq=has_metadata:true&rows=10&wt=json&indent=true

	https://api.crossref.org/v1/works/{$doi}
	For example:
	https://api.crossref.org/v1/works/10.1002/joc.5458

	short-container-title	
	0	"Int. J. Climatol"

	container-title	
	0	"International Journal of Climatology"

	published-print	
	date-parts	
	0	
	0	2018
	1	5
	DOI	"10.1002/joc.5458"
	type	"journal-article"

	page	"2760-2774"

	title	
	0	"Towards a global land surface climate fiducial reference measurements network"

	volume	"38"

	author	
	0	
	ORCID	"http://orcid.org/0000-0003-0485-9798"
	authenticated-orcid	false
	given	"P. W."
	family	"Thorne"
	sequence	"first"
	affiliation	
	0	
	name	"Irish Climate Analysis and Research Unit, Department of Geography; Maynooth University; Maynooth Ireland"

	1	
	given	"H. J."
	family	"Diamond"
	sequence	"additional"
	affiliation	
	0	
	name	"National Oceanic and Atmospheric Administration's Air Resources Laboratory; Silver Spring Maryland"
	-->

	<!-- </fieldset> -->


		<p><label for="messageHuman">Human Verification: <span class="requiredfield">*</span><br>
			<input type="text"  maxlength="10" style="width: 60px;" name="messageHuman" value="<?php echo($messageHuman) ?>"  class="<?php echo($errorClassHuman) ?>"> + 3 = 5</label></p>
		<!-- <p>A better method to protect against bots is important. We do not want to annoy the editors with spam contributions. However, I would prefer not to use anything that acts as a third party tracker, such as Google's reCaptcha. Do you know of an alternative that could run on our own server?</p> -->
    <input type="hidden" name="submittedGrassroots" value="1">
    <?php wp_nonce_field( 'grassroots-new-assessment' ); ?>
		<p><input type="submit" value="Submit"></p>
	
</form> 