<?php 
include ("dbaccess.php");

if (isset($_POST['submit'])) {
	$request = $fm->createRecord('StandingRequest');
	$request->setField('id_Publisher', $_POST['id_Publisher']);
	$request->setField('itemCode', $_POST['itemCode']);
	$request->setField('quantity', $_POST['quantity']);
	$request->setField('language', $_POST['language']);
	$result=$request->commit();

	$request = $request->getRecordID();
	$record = $fm->getRecordByID('StandingRequest', $request);
	//echo $request;

	echo 'Standing request added.<hr>';
}

echo '<form action="standing-request.php" method="POST">
  Publisher ID:<br>
  <input type="text" name="id_Publisher" value="">
  <br>
  itemCode:<br>
  <input type="text" name="itemCode" value="">
  <br>
  quantity:<br>
  <input type="number" name="quantity" value="1">
  <br>
  language:<br>
  <input type="text" name="language" value="">
  <br>
  <br>
  <input type="submit" name="submit" value="Submit">
</form>'; 

?>

