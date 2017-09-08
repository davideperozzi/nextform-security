<?php

namespace Nextform\Security\Csrf\Models;

class TokenModel implements \Serializable
{
    /**
     * @var string
     */
    public $id = '';

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var integer
     */
    public $created = -1;

    /**
     * @param string $id
     * @param string $value
     */
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
        $this->created = time();
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return serialize([
            'id' => $this->id,
            'created' => $this->created,
            'value' => $this->value
        ]);
    }

    /**
     * @param array $data
     */
    public function unserialize($data)
    {
        $data = unserialize($data);

        $this->id = $data['id'];
        $this->created = $data['created'];
        $this->value = $data['value'];
    }
}
