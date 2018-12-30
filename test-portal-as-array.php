<?php 
include ("dbaccess.php");

$request = $fm->newFindAllCommand('web');
$result = $request->execute();


$records = $result->getRecords();
$var = array();
foreach($records as $record) {
    $related_records = $record->getRelatedSet('StandingRequest');
    $var1 = array();
    foreach($related_records as $related_record) {
        $var1[] = array(
        'itemCode' => $related_record->getField('StandingRequest::itemCode'),
        'quantity' => $related_record->getField('StandingRequest::quantity'),
        'languageCode' => $related_record->getField('StandingRequest::languageCode')
        );
    }

    $var[] = array(
        'firstName' => $record->getField('firstName'),
        'status' => $record->getField('status'),
        'StandingRequests' => $var1
    );

}

print_r($var);
?>
