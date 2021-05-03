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

namespace Cyrosy\PhpEndOfLife;

use Webmozart\Assert\Assert;

final class PhpEndOfLife
{
    private static $endOfSupportDates = array(
    //version => end of security updates
        '3.0' => '2000-10-20',
        '4.0' => '2001-06-23',
        '4.1' => '2002-03-12',
        '4.2' => '2002-09-06',
        '4.3' => '2005-05-31',
        '4.4' => '2008-08-07',
        '5.0' => '2005-11-05',
        '5.1' => '2006-08-24',
        '5.2' => '2011-01-06',
        '5.3' => '2014-08-14',
        '5.4' => '2015-09-03',
        '5.5' => '2016-07-21',
        '5.6' => '2018-12-31',
        '7.0' => '2019-01-10',
        '7.1' => '2019-12-01',
        '7.2' => '2020-11-30',
        '7.3' => '2021-12-06',
        '7.4' => '2022-11-28',
        '8.0' => '2023-11-26',
    );

    /**
     * @param string $version
     *
     * @return \DateTime
     *
     * @throws UnknownPhpVersionException
     */
    public static function getEndOfLifeDate($version)
    {
        Assert::string($version);

        $knownVersions = \array_keys(static::$endOfSupportDates);
        $normalizedVersion = static::normalizeVersion($version);

        if (!\in_array($normalizedVersion, $knownVersions)) {
            throw new UnknownPhpVersionException($version, $knownVersions);
        }

        return new \DateTime(static::$endOfSupportDates[$normalizedVersion]);
    }

    /**
     * @param string $version
     *
     * @return string|null
     */
    public static function normalizeVersion($version)
    {
        Assert::string($version);

        return \preg_filter('/^(\d+\.\d+)(\.\d+)?$/', '$1', $version);
    }

    /**
     * Check is specified PHP version is currently supported
     *
     * @param string $version
     * @param \DateTimeInterface|null $atDate
     *
     * @return bool
     */
    public static function isSupported($version, $atDate = null)
    {
        Assert::string($version);

        if (null === $atDate) {
            $atDate = new \DateTime();
        }

        if (\PHP_VERSION_ID > 50500) {
            Assert::implementsInterface($atDate, 'DateTimeInterface');
        } else {
            Assert::isInstanceOf($atDate, 'DateTime');
        }

        return static::getEndOfLifeDate($version) > $atDate;
    }
}
