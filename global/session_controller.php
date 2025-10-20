<?php
if ($_SESSION['pdau_id'] == null || $_SESSION['pdau_id'] == "") {
	header('Location:../../index.php?username='.$_SESSION['pdau_id'].'');
}
?>