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

use Throwable;

final class UnknownPhpVersionException extends \RuntimeException
{
    /**
     * @param string $passedVersion
     * @param string[] $knownVersions
     * @param Throwable|null $previous
     */
    public function __construct($passedVersion, $knownVersions, $previous = null)
    {
        parent::__construct(\sprintf(
            'Unknown PHP version "%s", must be one of "%s"',
            $passedVersion,
            \implode(', ', $knownVersions)
        ), 0, $previous);
    }
}
