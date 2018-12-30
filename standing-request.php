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
	  echo 'Standing request added.<hr>';

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

$layout =& $fm->getLayout('StandingRequest');


echo '<h3>New Request</h3>
  <form action="standing-request.php" method="POST">
  Publisher ID:<br>
  <input type="text" name="id_Publisher" value="">
  <br>
  itemCode:<br>
  <select name="itemCode">';
$itemCodes = $layout->getValueListTwoFields('itemCode', 1);
foreach($itemCodes as $itemCode ) {
echo '<option value="' . $itemCode . '">' . $itemCode . '</option>';
}   
echo '<select>
  <br>
  quantity:<br>
  <input type="number" name="quantity" value="1">
  <br>
  language:<br>
  <select name="languageCode">';
$languageCodes = $layout->getValueListTwoFields('languageCode', 1);
foreach($languageCodes as $languageCode ) {
echo '<option value="' . $languageCode . '">' . $languageCode . '</option>';
}   
echo '<select>
  <br>
  <input type="submit" name="add-request" value="Add Request">
</form>
<br>
<br>
<h3>Update Quantity</h3>
<form action="standing-request.php" method="POST">
  Request ID:<br>
  <input type="number" name="id" value="">
  <br>
  quantity:<br>
  <input type="number" name="quantity" value="1">
  <br>
  <input type="submit" name="update-request" value="Update Quantity">
</form>
<br>
<br>
<h3>Delete Request</h3>
<form action="standing-request.php" method="POST">
  Request ID:<br>
  <input type="number" name="id" value="">
  <br>
  <input type="submit" name="delete-request" value="Delete Request">
</form>'; 

?>

