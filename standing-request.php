<?php 
include ("dbaccess.php");

if (isset($_POST['add-request'])) {
    $request = $fm->createRecord('StandingRequest');
    $request->setField('id_Publisher', $_POST['id_Publisher']);
    $request->setField('itemCode', $_POST['itemCode']);
    $request->setField('quantity', $_POST['quantity']);
    $request->setField('languageCode', $_POST['languageCode']);
    $result=$request->commit();

    if (FileMaker::isError($result)) {
      echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    } 
	  echo '<div class="alert alert-light alert-dismissible fade show" role="alert">Request has been added.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';

} elseif (isset($_POST['update-request'])) {
    $request = $fm->newEditCommand('StandingRequest', $_POST['id']);
    $request->setField('quantity', $_POST['quantity']);
    $request->execute();

    if (FileMaker::isError($result)) {
      echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    } 
    echo 'Request has been updated.';

} elseif (isset($_POST['delete-request'])) {
    $request = $fm->getRecordById('StandingRequest', $_POST['id']);
    $request->delete();

    if (FileMaker::isError($result)) {
      echo "<p>Error: " . $result->getMessage() . "</p>"; exit;
    } 
    echo 'Request has been deleted.';
}

?>

