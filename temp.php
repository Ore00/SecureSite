<?php
$siteName = "Site Secure";
$siteUrl = "https://myrims.net";
$message = "Hi, there...";
$msg = "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8' /><meta name='viewport' content='width=device-width, initial-scale=1'>";
// $msg .="<link rel='stylesheet' href='";
// $msg .= $Domain;
// $msg .= $sDir;
// $msg .= "css/email.css'/>";
$msg .= "<title>User Notification</title><style></style></head>";
$msg .= "<body style='background: rgba(138, 58, 100, 0.025) !important; font-family: Roboto, Helvetica, sans-serif; font-weight: 100; font-size: 12pt; line-height: 1.5em; color: #4d4d4d; -webkit-text-stroke: 0.1px; height: 90% !important;' >";
$msg .= "<table style='margin: 25px auto; border-collapse: collapse; border-spacing: 5; width: 90% !important;'>";
$msg .= "<tr style='background:#6e3a8a; color:#ffffff; text-align: center; border-bottom-style: solid; border-bottom-color: #6e3a8a line-height: 2em;'>";
$msg .= "<td style='padding: 25px 15px !important;'><h1>". $siteName ."</h1></td></tr>";
$msg .= "<tr><td></td></tr>";
$msg .="<tr><td style='padding: 60px 25px !important; text-align: left;
background: #fff; border-left-style: solid;  border-right-style: solid;
border-left-width: 1px; border-right-width: 1px; border-left-color: #f2f2f2;
border-right-color: #f2f2f2;
height: 300px !important; vertical-align: top !important;'>";

$msg .= $message;
$msg .="</td></tr>";

$msg .="<tr><td id='myAppID'></td></tr>";
$msg .="<tr><td id='emailFooter' style='background: #6e3a8a; text-align: center; padding: 15px !important;'>";
$msg .="</td></tr>";
$msg .="<tr><td style='text-align: center;  padding: 25px; font-size: 10px;'><span>";
$msg .="Powered By <a href='" . $siteUrl ."' target='_blank' rel='noopener noreferrer'>RIMS</a>. </span></td></tr>";
$msg .="</table></body></html>";

echo $msg;
 ?>
