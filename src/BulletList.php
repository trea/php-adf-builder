<?php

namespace Jmsfwk\Adf;

class BulletList extends GroupNode
{
    protected $type = 'bulletList';

    public function listItem(): ListItem
    {
        $item = new ListItem();
        $this->append($item);
        return $item;
    }
}