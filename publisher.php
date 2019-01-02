<?php 
include ("dbaccess.php");

if (isset($_POST['delete_publisher'])) {
    $firstName = $_POST['firstName'];
	$request = $fm->getRecordById('web', $_POST['id']);
	$request->delete();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
	$msg = $_POST['firstName'] . ' has been deleted.';
	header('Location: https://qc.r2labs.com/distro/?msg=' . $msg); 

} elseif (isset($_POST['add_publisher'])) {
	$request = $fm->createRecord('web');
	$request->setField('firstName', $_POST['firstName']);	
	$result=$request->commit();

    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
    
	$msg = $_POST['firstName'] . ' has been added.';
	header('Location: https://qc.r2labs.com/distro/?msg=' . $msg); 

} elseif (isset($_POST['received'])) {
	$firstName = $_POST['firstName'];
	$request = $fm->newEditCommand('web', $_POST['id']);
	$request->setField('status', 'received');
	$request->execute();
    
    if (FileMaker::isError($result)) {
	    echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
	}
	echo '<i>Received</i>';

}

?>

