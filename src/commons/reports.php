<?php
/**
 * Created by PhpStorm.
 * User: kayemilton
 * Date: 05/12/2017
 * Time: 18:25
 */

require_once ("db.php");

$o = $_POST['o'];
$wn= $_POST['wn'];
$cat = $_POST['cat'];
$yr = $_POST['yr'];

if ($cat == "akpi") {//KPIs for Adults
    $tbl = 'staging.weekly_data_smry_a';
    //$tbl1 = 'staging.rass_no_reports_a';
}
if ($cat == "pkpi") {//KPIs for Paediatrics
    $tbl = 'staging.weekly_data_smry_c';
    //$tbl1 = 'staging.rass_no_reports_c';
}
if ($cat == "rkpi") {//KPIs for RTKS
    $tbl = 'staging.weekly_data_smry_rtks';
    //$tbl1 = 'staging.rass_no_reports_rtks';
}
if ($cat == "rdkpi") {//KPIs for RDTS
    $tbl = 'staging.stk';
    //$tbl1 = 'staging.rass_no_reports_rtks';
}

//echo $cat;

$sql = "SELECT * FROM $tbl smry JOIN staging.rass_reporting_orgs_m org ON smry.uid = org.uid 
WHERE smry.weekno = $wn AND smry.yr = $yr AND smry.uid = '$o'";

$res = pg_query($db, $sql);

if(!$res) {
    echo pg_last_error($db);
    exit;
}
//$numrows = pg_numrows($res);

//$orgunits =array();

while($row = pg_fetch_array($res)) {
    //$orgunits[] = array('entity' => $row['entity'], 'uid' => $row['uid']);
    $tr = "<h6>RDTS</h6><table>";
    $tr .=  "<thead><tr><th>Commodity</th><th>Stock on Hand</th><th>Received Stock</th></tr></thead><tbody>";
    $tr .= "<tr><td>Nasopharyngeal Swab</td><td>".$row['a']."</td><td>NULL</td></tr>";
    $tr .= "<tr><td>Oropharyngeal Swab</td><td>".$row['b']."</td><td>NULL</td></tr>";
    $tr .= "<tr><td>Standard Q</td><td>".$row['c']."</td><td>NULL</td></tr>";
    $tr .= "<tr><td>Abbot Panbio</td><td>".$row['d']."</td><td>NULL</td></tr>";
    $tr .= "<tr><td>PPEs</td><td>".$row['e']."</td><td>NULL</td></tr>";
    $tr .= "<tr><td>Quality Usage kits</td><td>".$row['q']."</td><td>NULL</td></tr>";
    
    $tr .=  "</tbody></table><br/><h6>Results</h6>";

    $tr .=  "<table><thead><tr><th>Type</th><th>Number</th></tr></thead><tbody>";
    $tr .= "<tr><td>Positives (Antigens)</td><td>".$row['p']."</tr>";
    $tr .= "<tr><td>Negatives (Antigens)</td><td>".$row['n']."</tr>";
    $tr .= "<tr><td>Invalids (Antigens)</td><td>".$row['v']."</tr>";
    $tr .=  "</tbody></table>";

}

//echo "Operation done successfully\n";
pg_close($db);
//$query = "";
//$result = pg_query($query);
//echo json_encode($orgunits);

echo $tr;

?>