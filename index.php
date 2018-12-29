<?php 
include ("../dbaccess.php");


$request = $fm->newFindCommand('web');
$request->addFindCriterion('status', '=='; 
$request->addSortRule('firstNme');
$result = $request->execute();

if (FileMaker::isError($result)) {
    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
}
//$request = $fm->newFindAllCommand('LayoutName');
//$result = $request->execute();


$records = $result->getRecords();
foreach($records as $record) {
    echo $record->getField('id') . ' ' . $record->getField('firstName') . '<br>';
}

?>

