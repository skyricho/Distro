<?php
//ini_set('display_errors', 1); // To debug errors
include ("dbaccess.php"); 
require 'vendor/autoload.php';


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');

if ($_GET['script'] == 'reset') {
    $request = $fm->newPerformScriptCommand('web', 'Reset All Received');
    $result = $request->execute();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}

	$msg = 'All names marked as received have been reset.';


} elseif ($_GET['filter'] == 'all') {
	$request = $fm->newFindAllCommand('web');
    $result = $request->execute();

} elseif ($_GET['filter'] == 'received') {
	$request = $fm->newFindCommand('web');
	$request->addFindCriterion('status', 'received'); 
	//$request->addSortRule('firstName', 1);
	$result = $request->execute();

	if (FileMaker::isError($result)) {
	    $msg = 'Error: ' . $result->getMessage();
	}

} else {
    $request = $fm->newFindCommand('web');
    $request->addFindCriterion('status', '=='); 
	$request->addSortRule('firstName', 1);
	$result = $request->execute();

	if (FileMaker::isError($result)) {
	    $msg = 'Error: ' . $result->getMessage();
	}

}

if (empty($msg)) {
	$records = $result->getRecords();
	if (FileMaker::isError($records)) {
	    $msg = 'Error: ' . $records->getMessage();
	}
	$var = array();
	foreach($records as $record) {
	    $related_records = $record->getRelatedSet('StandingRequest');
	    $var1 = array();
	    // Absence of related record triggers an error: Call to undefined method FileMaker_Implementation::getField()
	    if ($record->getField('cRelatedRecords') > 0) {
	    	foreach($related_records as $related_record) {
		        $var1[] = array(
		        'id' => $related_record->getField('StandingRequest::id'),
		        'itemCode' => $related_record->getField('StandingRequest::itemCode'),
		        'color' => $related_record->getField('StandingRequest::cColor'),
		        'quantity' => $related_record->getField('StandingRequest::quantity'),
		        'languageCode' => $related_record->getField('StandingRequest::languageCode')
		        );
		    }
	    }

		$var[] = array(
	        'id' => $record->getField('id'),
	        'firstName' => $record->getField('firstName'),
	        'status' => $record->getField('status'),
	        'note' => $record->getField('note'),
	        'standingRequests' => $var1
	    );
	}
}

$layout =& $fm->getLayout('StandingRequest');
// Value list returned an array
$itemCodes = $layout->getValueListTwoFields('itemCode', 1);
$languageCodes = $layout->getValueListTwoFields('languageCode', 1);

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
}

echo $template->render(array(
        'statusFilter' => $_GET['filter'],
        'msg' => $msg,
        'publishers' => $var,
        'itemCodes' => $itemCodes,
        'languageCodes' => $languageCodes
        )
    );
?>
