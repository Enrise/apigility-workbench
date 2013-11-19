<?php


namespace Enrise\Apigility\Workbench\Model;


use Zend\Http\Response;

class HttpResponseSerializer implements \Serializable
{
    /**
     * @var Response
     */
    protected $response;

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function serialize()
    {
        $response = $this->response;
        $serialized = array(
            'statusCode' => $response->getStatusCode(),
            'headers'    => $response->getHeaders(),
            'body'       => $response->getBody()
        );


        return $serialized;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @throws \LogicException
     */
    public function unserialize($serialized)
    {
        throw new \LogicException('Cannot unserialize a Zend\Http\Response. This method is not implemented.');
    }


}
