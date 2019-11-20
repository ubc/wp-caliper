<?php
namespace IMSGlobal\Caliper\entities;

interface Collectable {
    /** @return Entity[]|null */
    public function getItems();

    /**
     * @param Entity|Entity[]|null $items
     * @return Collection
     */
    public function setItems($items);
}