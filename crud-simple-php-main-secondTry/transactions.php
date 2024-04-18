<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://us-east-1.aws.data.mongodb-api.com/app/data-ulolq/endpoint/data/v1/insertOne',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "collection":"logs",
    "database":"transactions",
    "dataSource":"Cluster0",
    "document": {'.$jsonInsert.'   
    }
}',
  CURLOPT_HTTPHEADER => array(
    'api-key: bbfV4QlsdNEVsYj1gZmYh3CBelPrbQ1EMKx0LoeoalqV3ufYHq56YEW27kuiYV13',
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;
