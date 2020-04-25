<?php


namespace dinglib\dingphp\api\signature;

use dinglib\dingphp\api\signature\impl\SignatureImpl;
use dinglib\dingphp\object\DingObject;

class Signature extends DingObject implements SignatureImpl
{

    public function initialize(array $params = null)
    {
        $signature = isset($params[0]) ? $params[0] : null;
        $signatureCreator = SignatureCreator::getInstance();
        if(!empty($signature)) {
            $data = $signatureCreator->unpackage($signature);
            foreach ($data as $key => $value){
                $this->setProperty($key,$value);
            }
        }
    }


}

