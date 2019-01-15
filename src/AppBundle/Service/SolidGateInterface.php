<?php

namespace AppBundle\Service;

/**
 * Interface SolidGateInterface
 * @package AppBundle\Service
 */
interface SolidGateInterface
{
    const PLATFORM_WEB = 'WEB';
    const PLATFORM_MOBILE = 'MOB';
    const PLATFORM_DESKTOP = 'APP';

    /**
     * @param array $attributes
     * @return mixed
     */
    public function initPayment(array $attributes);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function refund(array $attributes);
}