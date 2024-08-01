<?php

namespace Mayank\Store;

abstract class CustomStore extends Store
{
    abstract public function data();

    public function get()
    {
        return $this->data();
    }

    public function cacheData()
    {
        return $this->data();
    }
}
