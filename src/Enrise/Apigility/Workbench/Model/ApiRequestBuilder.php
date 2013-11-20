<?php
namespace Enrise\Apigility\Workbench\Model;

use Zend\Http\Headers;
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

        $headers = new Headers();
        $headers->addHeaderLine('Accept', $proxyData['core']['accept']);
        $apiRequest->setMethod($proxyData['core']['http_method']);
        if (in_array($apiRequest->getMethod(), array('PUT', 'POST', 'PATCH'))) {
            $headers->addHeaderLine('Content-Type', $proxyData['core']['content_type']);
            $apiRequest->setContent($proxyData['rawparams']['body']);
        }
        $apiRequest->setHeaders($headers);
        $apiRequest->setUri($proxyData['core']['host'] . $uri);

        return $apiRequest;
    }
}
