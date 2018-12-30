<?php 
include ("dbaccess.php");

if (isset($_POST['delete_publisher'])) {
    $firstName = $_POST['firstName'];
	$request = $fm->getRecordById('web', $_POST['id']);
	$request->delete();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
	echo $firstName . ' has been deleted';

} elseif (isset($_POST['add_publisher'])) {
	$request = $fm->createRecord('web');
	$request->setField('firstName', $_POST['firstName']);
	$result=$request->commit();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
	echo $_POST['firstName'] . ' has been added.';

} elseif (isset($_POST['received'])) {
	$firstName = $_POST['firstName'];
	$request = $fm->newEditCommand('web', $_POST['id']);
	$request->setField('status', 'received');
	$request->execute();
    
    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
	echo $firstName . ' marked as received.';

}

?>

