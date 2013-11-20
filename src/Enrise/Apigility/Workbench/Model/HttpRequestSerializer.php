<?php


namespace Enrise\Apigility\Workbench\Model;


use Zend\Http\Request;

class HttpRequestSerializer implements \Serializable
{
    /**
     * @var Request
     */
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function serialize()
    {
        $request = $this->request;
        $serialized = array(
            'requesturi'    => $request->getUriString(),
            'headers'       => $request->getHeaders(),
            'method'        => $request->getMethod(),
            'metadata'      => $request->getMetadata(),
            'requeststring' => $request->toString(),

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
        throw new \LogicException('Cannot unserialize a Zend\Http\Request. This method is not implemented.');
    }


}
