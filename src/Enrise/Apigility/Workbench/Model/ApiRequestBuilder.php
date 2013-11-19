<?php


namespace Enrise\Apigility\Workbench\Model;


use Zend\Http\Request;

class ApiRequestBuilder
{
    public function fromProxyRequest(Request $proxyRequest)
    {
        $apiRequest = new Request();

        $proxyData = $proxyRequest->getPost();

        $uri = $proxyData['core']['path'];
        foreach ($proxyData['params'] as $key => $value) {
            $uri = str_replace(':'.$key, $value, $uri);
        }
        $uri = str_replace(array('[',']'), array('',''), $uri);

        $headers = new \Zend\Http\Headers();
        $apiRequest->setMethod($proxyData['core']['http_method']);
        $apiRequest->setHeaders($headers->fromString('Accept: '.$proxyData['core']['accept']));
        $apiRequest->setHeaders($headers->fromString('Content-Type: '.$proxyData['core']['content_type']));

        $apiRequest->setUri($proxyData['core']['host'] . $uri);

        return $apiRequest;
    }
}
