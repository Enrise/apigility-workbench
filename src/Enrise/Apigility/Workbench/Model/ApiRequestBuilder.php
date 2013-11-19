<?php


namespace Enrise\Apigility\Workbench\Model;


use Zend\Http\Request;

class ApiRequestBuilder
{
    public function fromProxyRequest(Request $proxyRequest)
    {
        $apiRequest = new Request();

        $proxyData = $proxyRequest->getPost();

        $apiRequest->setUri($proxyData['baseuri'] . $proxyData['endpoint']);

        return $apiRequest;
    }
}
