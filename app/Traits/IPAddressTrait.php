<?php
namespace App\Traits;

trait IPAddressTrait
{
    /**
     * Converts an IP address from readable format to binary format.
     *
     * @param string $ipAddress The IP address in readable format.
     * @return string | bool The IP address in binary format.
     */
    protected function convertToBinary(string $ipAddress): string | bool
    {
        return inet_pton($ipAddress);
    }

    /**
     * Converts an IP address from binary format to readable format.
     *
     * @param string $ipAddress The IP address in binary format.
     * @return string | bool The IP address in readable format.
     */
    protected function convertToReadable(string $ipAddress): string | bool
    {
        return inet_ntop($ipAddress);
    }

}
