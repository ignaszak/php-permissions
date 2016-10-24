<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 24.10.16
 * Time: 22:02
 */

declare(strict_types=1);

namespace Ignaszak\Permissions\Test;

use Ignaszak\Permissions\Permissions;
use Ignaszak\TestingTools\Test;

/**
 * Class PermissionsTest
 * @package Ignaszak\Permissions\Test
 */
class PermissionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Permissions
     */
    private $permissions = null;

    public function setUp()
    {
        $this->permissions = new Permissions(json_encode([
            'p1.p2.p3'
        ]));
        Test::$object = $this->permissions;
    }

    public function testConstructor()
    {
        $this->assertEquals([
            'p1.p2.p3'
        ], Test::get('permissions'));
    }

    public function testCanString()
    {
        $this->assertTrue($this->permissions->can('p1.p2.p3'));
        $this->assertFalse($this->permissions->can('p1.p2.p4'));
    }

    public function testAdd()
    {
        $this->permissions->add('p1.p2.p4');
        $this->assertEquals([
            'p1.p2.p3', 'p1.p2.p4'
        ], Test::get('permissions'));
    }

    public function testAddArray()
    {
        $this->permissions->add(['p1.p2.p4', 'p1.p6']);
        $this->assertEquals([
            'p1.p2.p3', 'p1.p2.p4', 'p1.p6'
        ], Test::get('permissions'));
    }

    public function testRemove()
    {
        $this->permissions = new Permissions(json_encode([
            'p1.p2.p3', 'p1.p2.p4'
        ]));
        Test::$object = $this->permissions;
        $this->permissions->remove(['p1.p2.p3', 'p1.p2.p4']);
        $this->assertEmpty(Test::get('permissions'));
    }
}
