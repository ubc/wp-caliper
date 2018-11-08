<?php
namespace IMSGlobal\Caliper\entities;

/**
 * Interface Type
 *
 * The type interface is implemented by a class that provides an entity with it's JSON-LD "@type"
 * identifier.
 */
interface Type {
    /**
     * @return string
     */
    public function getValue();
}