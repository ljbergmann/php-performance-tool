<?php
$data = '{"text":"[this](this-test)"}';
// erzeuge einen neuen cURL-Handle
$ch = curl_init();
 
// setze die URL und andere Optionen
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/markdown");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// führe die Aktion aus und gebe die Daten an den Browser weiter
curl_exec($ch);
 
// schließe den cURL-Handle und gebe die Systemresourcen frei
curl_close($ch);
?>