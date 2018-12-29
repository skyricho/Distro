<?php 
include ("dbaccess.php");

echo '<a href="?filter=all">All</a> | <a href="?filter=received">Received</a> | <a href="/distro">Not Received</a><br>';

if ($_GET['filter'] == 'all') {
	$request = $fm->newFindAllCommand('web');
    $result = $request->execute();

} elseif ($_GET['filter'] == 'received') {
	$request = $fm->newFindCommand('web');
	$request->addFindCriterion('status', 'received'); 
	$request->addSortRule('firstName', 1);
	$result = $request->execute();

	if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}

} else {
    $request = $fm->newFindCommand('web');
    $request->addFindCriterion('status', '=='); 
	$request->addSortRule('firstName', 1);
	$result = $request->execute();

	if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}

}

$records = $result->getRecords();
foreach($records as $record) {
    echo $record->getField('firstName') . ' ' . $record->getField('status') . '<br>';
}

?>

