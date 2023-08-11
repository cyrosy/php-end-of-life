<?php
/**
 * This file is part of the PHP End-Of-Life project.
 *
 * @copyright cyrosy <github@cyrosy.fr>
 * @license https://joinup.ec.europa.eu/page/eupl-text-11-12 EUPL v1.2 or higher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cyrosy\PhpEndOfLife\Test;

use Cyrosy\PhpEndOfLife\PhpEndOfLife;
use PHPUnit\Framework\TestCase;

final class PhpEndOfLifeTest extends TestCase
{
    public function testNormalizeVersion(): void
    {
        $this->assertEquals(null, PhpEndOfLife::normalizeVersion('1'));
        $this->assertEquals(1, PhpEndOfLife::normalizeVersion('1.0'));
        $this->assertEquals(1.1, PhpEndOfLife::normalizeVersion('1.1'));
        $this->assertEquals('1.0', PhpEndOfLife::normalizeVersion('1.0'));
        $this->assertEquals('1.0', PhpEndOfLife::normalizeVersion('1.0.0'));
    }

    public function testGetEndOfLifeDateValidVersion(): void
    {
        $this->expectException('Cyrosy\PhpEndOfLife\UnknownPhpVersionException');
        PhpEndOfLife::getEndOfLifeDate('1.0');
    }

    public function testGetEndOfLifeDateValidDate(): void
    {
        $this->assertEquals(new \DateTime('2019-01-10'), PhpEndOfLife::getEndOfLifeDate('7.0'));
    }

    public function testIsSupported(): void
    {
        $this->assertTrue(PhpEndOfLife::isSupported('7.0', new \DateTime('2019-01-01')));
        $this->assertFalse(PhpEndOfLife::isSupported('7.0', new \DateTime('2019-02-01')));
        $this->assertTrue(PhpEndOfLife::isSupported('8.2'));
        $this->assertFalse(PhpEndOfLife::isSupported('5.6'));
    }
}
