<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
require_once 'sms_class.php';
$msg = $_POST['message'];
$file_name = $_POST['file'];
if($file_name!="")
	$data = new Spreadsheet_Excel_Reader("doc/".$file_name);
else echo "Enter a file name..<br/>";
?>
<html>
<head>
<style>
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
</style>
</head>

<body>
<?php //echo $data->dump(true,true); 
if($msg != "" && $file_name != ""){
	for($sheet_count=0;$data->rowcount($sheet_count)!=0;$sheet_count++);
	echo "Sheet count is:".$sheet_count;
	for($i=0;$i<$sheet_count;$i++){
		echo "<br>sheet".$i." rows :".$data->rowcount($i)." cols :".$data->colcount($i)."==>";//.$data->val(1,3,$i);
		$rowcount = $data->rowcount($i);
		$colcount = $data->colcount($i);
		$mob_num_col="";
		for($row=1;$row<=$rowcount;$row++){
			for($col=1;$col<=$colcount;$col++){
				if($data->val($row,$col,$i)=="mobile_number" || $data->val($row,$col,$i)=="mob_number"){
					$mob_num_col = $col;
					echo "<br>mobile_number @ col ".$col." & row ".$row;
					$row++;
					break;
				}

			}
			if($mob_num_col != ""){				
				if($data->val($row,$mob_num_col,$i) !=""){// && str_len($data->val($row,$mob_num_col,$i))==10)
					//echo "<br>Msg send to ".$data->val($row,$mob_num_col,$i);
					$sms_handle = new SMS_Fullon();
					$sms_handle->SMS($data->val($row,$mob_num_col,$i),$msg);
					echo "<br/> Msg send to ".$data->val($row,$mob_num_col,$i);
					sleep(8);

				}
			}

		}
	}
}
else {
	echo "Enter the file name and message...";
}
?>
</body>
</html>
