<?php

namespace Jmsfwk\Adf\Inline;

use Jmsfwk\Adf\Marks\Em;
use Jmsfwk\Adf\Marks\Link;
use Jmsfwk\Adf\Marks\Strong;

trait TextChildren
{
    abstract protected function append($node);

    public function text(string $text): self
    {
        $this->append(new Text($text));

        return $this;
    }

    public function em(string $text): self
    {
        $this->append(new Text($text, new Em()));

        return $this;
    }

    public function link(string $text, string $href, string $title = null): self
    {
        $this->append(new Text($text, new Link($href, $title)));

        return $this;
    }

    public function strong(string $text): self
    {
        $this->append(new Text($text, new Strong()));
        return $this;
    }
}
