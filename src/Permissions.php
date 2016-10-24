<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 24.10.16
 * Time: 22:01
 */

declare(strict_types=1);

namespace Ignaszak\Permissions;

/**
 * Class Permissions
 * @package Ignaszak\Permissions
 */
class Permissions
{

    /**
     * @var array
     */
    private $permissions = [];

    /**
     * Permissions constructor.
     * @param string $permissions
     */
    public function __construct(string $permissions)
    {
        $this->permissions = json_decode($permissions, true);
    }

    /**
     * @param string $p
     * @return bool
     */
    public function can(string $p): bool
    {
        return in_array($p, $this->permissions);
    }

    /**
     * @param string|string[] $p
     * @return Permissions
     */
    public function add($p): Permissions
    {
        if (is_array($p)) {
            foreach ($p as $v) $this->permissions[] = $v;
        } else {
            $this->permissions[] = $p;
        }
        return $this;
    }

    /**
     * @param string|string[] $p
     * @return Permissions
     */
    public function remove($p): Permissions
    {
        if (is_array($p)) {
            foreach ($p as $v) {
                $key = $this->getKeyByValue($v);
                if ($key !== false) unset($this->permissions[$key]);
            }
        } else {
            $key = $this->getKeyByValue($p);
            if ($key !== false) unset($this->permissions[$key]);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function json(): string
    {
        return json_encode($this->permissions);
    }

    /**
     * @return \stdClass
     */
    public function object(): \stdClass
    {
        return (object)$this->permissions;
    }

    /**
     * @param string $key
     * @return int|false
     */
    private function getKeyByValue(string $key)
    {
        return array_search($key, $this->permissions);
    }

}