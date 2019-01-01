<?php 
include ("dbaccess.php");

$request = $fm->createRecord('web');
$request->setField('firstName', 'foo');
$result=$request->commit();

// see https://stackoverflow.com/questions/34757462/filemaker-php-api-get-id-of-newly-created-record
$request = $request->getRecordID();
//echo $request . '<br>';
$record = $fm->getRecordByID('web', $request);


echo 'Record ' . $record->getField('id') . ' has been inserted. First Name: ' . $record->getField('firstName');

?>