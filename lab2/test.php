<?php 
	if( isset($_GET['program'])) $program=trim($_GET['program']); 
	if( isset($_GET['country'])) $country=trim($_GET['country']); 
	if( isset($_GET['term'])) $term=$_GET['term']; 
	if( isset($_GET['language'])) $language=$_GET['language']; 
    if( isset($_GET['level'])) $level=$_GET['level']; 

	if (!empty($program) && !empty($country) && 
		!empty($term) && !empty($language) && !empty($level)) {
		$document_root = $_SERVER['DOCUMENT_ROOT'];
		$fp = @fopen("$document_root/lab/data/exchange.txt",'a');
		if(!$fp) {
			echo "<strong>Your registration was not processed due to system problem. Please try again later.</strong>";
			exit;
		}
		$out = $program.",".$country.",".$term.",".$language.",".$level."\n";
		fwrite($fp,$out);
		fclose($fp);
		
		exit;
	}


	$incomplete = !empty($program) || !empty($country) || 
		!empty($term) || !empty($language) || !empty($level);

	echo $incomplete ? "<p>Please fill in the <font style=\"background-color:Yellow;\">missing</font> information below</p>" 
			: "<p>Please fill in the form below</p>";
	
	require('form_functions.php');

	echo "<form action=\"page13.php\">";
	
	p11_form_start();
	p11_textfield('Type of Program:','program',$incomplete);
	p11_textfield('Country:','country',$incomplete);
	p11_textfield('Term:','term',$incomplete);
	p11_textfield('Language of Instruction:','language',$incomplete);
	p11_course('Course:', 'course', ['','Undergraduate','Graduate','PHD or Post-Doctoral','PDP'],
		['Select a course',
		'Undergraduate',
		'Graduate',
		'PHD or Post-Doctoral',
	    'PDP'],$incomplete);


	// p11_gender('Term:', 'gender', ['male','female','other'],
	// 	['Male','Female','Other'],$incomplete);
	// p11_course('Course:', 'course', ['','iat100','iat102','iat103'],
	// 	['Select a course',
	// 	'IAT100 - Digital Image Design',
	// 	'IAT102 - Graphic design',
	// 	'IAT103 - Design Communication and Collaboration'],$incomplete);
	p11_form_end();
	echo "</form>";



?>
