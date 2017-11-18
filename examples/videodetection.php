<?php

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use Google\Cloud\VideoIntelligence\V1beta1\VideoIntelligenceServiceClient;
use Google\Cloud\Videointelligence\V1beta1\Feature;

$videoIntelligenceServiceClient;
try {
    $videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();
    $inputUri = dirname( dirname( __FILE__ ) ) . '/temp/video-4929_large.mp4';
    $featuresElement = Feature::LABEL_DETECTION;
    $features = [$featuresElement];
    $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
    $operationResponse->pollUntilComplete();
    if ($operationResponse->operationSucceeded()) {
      $result = $operationResponse->getResult();
      // doSomethingWith($result)
    } else {
      $error = $operationResponse->getError();
      // handleError($error)
    }

    // OR start the operation, keep the operation name, and resume later
    $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
    $operationName = $operationResponse->getName();
    // ... do other work
    $newOperationResponse = $videoIntelligenceServiceClient->resumeOperation($operationName, 'annotateVideo');
    while (!$newOperationResponse->isDone()) {
        // ... do other work
        $newOperationResponse->reload();
    }
    if ($newOperationResponse->operationSucceeded()) {
      $result = $newOperationResponse->getResult();
      // doSomethingWith($result)
    } else {
      $error = $newOperationResponse->getError();
      // handleError($error)
    }
} finally {
    $videoIntelligenceServiceClient->close();
}
