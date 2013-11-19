<?php


namespace Enrise\Apigility\Workbench\Model;


use Zend\Http\Request;

class ApiRequestBuilder
{
    public function fromProxyRequest(Request $proxyRequest)
    {
        $apiRequest = new Request();

        $proxyData = $proxyRequest->getPost();

        $headers = new \Zend\Http\Headers();


        $apiRequest->setHeaders($headers->fromString('Accept: application/json'));

        $apiRequest->setUri($proxyData['baseuri'] . $proxyData['endpoint']);

        return $apiRequest;
    }
}
