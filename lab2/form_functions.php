<?php 

function p11_form_start() {
	echo "<table>";
}


function p11_textfield($label, $varname, $incomplete) {
	global $$varname;
	echo "<tr><td>$label</td>";
	echo "<td><input type=\"text\" size=\"20\" name=\"$varname\" ";
	if ($incomplete)
		empty($$varname) ? print("style=\"background-color:Yellow;\"") 
						: print("value=\"".htmlspecialchars($$varname)."\"");
	echo"></td></tr>";
}
	
function p11_gender($label,$varname,$options,$texts,$incomplete) {
	global $$varname;
	echo"<tr valign=\"top\"><td>$label</td><td ";
	if ($incomplete && empty($$varname)) print("style=\"background-color:Yellow;\"");
	echo ">";
	
	$i = 0;
	foreach($options as $opt) 
		p11_gender_option($texts[$i++],$varname, $opt, $incomplete);
		
	echo"</td></tr>";
}
function p11_gender_option($text,$varname, $opt, $incomplete) {
	global $$varname;
	echo "<input type=\"radio\" name=\"$varname\" value=\"$opt\" ";
	if (!empty($$varname) && $$varname==$opt ) echo "checked"; 
	echo ">$text<br>\n";
}

function p11_course($label,$varname,$options,$texts,$incomplete) {
	global $$varname;
	echo "<tr><td>Course:</td>";
	echo "<td><select name=\"$varname\"";
	if ($incomplete && empty($$varname)) print(" style=\"background-color:Yellow;\"");
	echo ">\n";

	$i = 0;
	foreach($options as $opt) 
		p11_course_option($texts[$i++],$varname, $opt, $incomplete);
	echo "</select>\n</td></tr>";
}

function p11_course_option($text,$varname, $opt, $incomplete) {
	global $$varname;
	

	echo "<option value=\"$opt\" ";
	if (!empty($$varname) && $$varname==$opt ) echo "selected"; 
	echo ">$text</option>\n";
}

function p11_form_end() {	
	echo "<tr><td><input type=\"submit\" name=\"submit\" border=0 value=\"Submit\"></td></tr>";
	echo "</table></form>";
}
