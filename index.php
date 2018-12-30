<?php 
include ("dbaccess.php");

echo '<a href="?filter=all">All</a> | <a href="?filter=received">Received</a> | <a href="/distro">Not Received</a><br>';

if ($_GET['script'] == 'reset') {
    $request = $fm->newPerformScriptCommand('web', 'Reset All Received');
    $result = $request->execute();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}

	echo 'All names marked as received have been reset.';


} elseif ($_GET['filter'] == 'all') {
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
    echo $record->getField('firstName') . ' ' . $record->getField('status') . '
  <form action="publisher.php" method="POST">
    <input type="hidden" name="id" value="' . $record->getField('id') . '">
    <input type="hidden" name="firstName" value="' . $record->getField('firstName') . '">
    <input type="submit" name="received" value="Received">
  </form>
  <br>
  <form action="publisher.php" method="POST">
    <input type="hidden" name="id" value="' . $record->getField('id') . '">
    <input type="hidden" name="firstName" value="' . $record->getField('firstName') . '">
    <input type="submit" name="delete_publisher" value="Delete Name">
  </form>
  <br>';

}

echo '<hr>
  <form action="publisher.php" method="POST">
    <input type="text" name="firstName" value="">
    <input type="submit" name="add_publisher" value="Add Name">
  </form>
  <br>
  <br>
  <a href="?script=reset">Reset all received</a>';

?>

