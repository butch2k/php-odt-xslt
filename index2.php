<?php
echo "<pre>";

// Ladda content.xml
$xml = simplexml_load_file('content.xml');

// Hitta namespaces i content.xml
$namespaces = $xml->getNamespaces(TRUE);
$keys = array_keys($namespaces);
print_r($keys);

// Office namespace key
$key_office = $keys[0];


// Office-noder
$office_nodes = $xml->children($key_office, TRUE);

// Lista office-noder
/*
foreach ($office_nodes as $office_node) {
	print_r(htmlentities($office_node->asXML()));
	echo "<hr>";
}
*/


// <office:body>
$office_body = $office_nodes->body;

// <office:body><office:text> 
$office_body_text = $office_nodes->body->text;
//print_r(htmlentities();



//----------------------------------------------------------------------------------------------
// Replace namespace tags - a bit ugly, but what the heck...	
//----------------------------------------------------------------------------------------------

$xml_string = ns_replace($office_body_text->asXML(), array('office', 'text', 'table', 'draw', 'xml', 'xlink', 'svg'));
print_r(htmlentities($xml_string));
$office_text = simplexml_load_string($xml_string);


foreach ($office_text->children() as $node) {
	echo "<hr>" .htmlentities($node->asXML());
	//echo "<br>". $node->getName();
}

//-----------------------------------------------------------------------------------
// namespacing replacement
function ns_replace($xml_string, array $ns_tags) 
{
	foreach ($ns_tags as $tag) {
		
		//start tag
		$tag_search 	= "<$tag:";
		$tag_replace 	= "<"; //<$tag-";
		$xml_string = str_replace($tag_search, $tag_replace, $xml_string);
		
		// end tag
		$tag_search 	= "</$tag:";
		$tag_replace 	= "</"; //"</$tag-";
		$xml_string = str_replace($tag_search, $tag_replace, $xml_string);
		
		// attribute tag
		$xml_string = preg_replace("/($tag:)([a-z]+)/", '$2', $xml_string);
		
	}
	return $xml_string;
}

