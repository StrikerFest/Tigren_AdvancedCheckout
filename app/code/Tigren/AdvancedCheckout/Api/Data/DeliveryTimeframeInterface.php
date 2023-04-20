<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Api\Data;

/**
 *
 */
interface DeliveryTimeframeInterface
{
    /**
     * @return string
     */
    public function getStartTime(): string;

    /**
     * @param string $startTime
     * @return $this
     */
    public function setStartTime(string $startTime): static;

    /**
     * @return string
     */
    public function getEndTime(): string;

    /**
     * @param string $endTime
     * @return $this
     */
    public function setEndTime(string $endTime): static;

    /**
     * @return string
     */
    public function getDayOff(): string;

    /**
     * @param string $dayOff
     * @return $this
     */
    public function setDayOff(string $dayOff): static;

    /**
     * @return string
     */
    public function getDateOff(): string;

    /**
     * @param string $dateOff
     * @return $this
     */
    public function setDateOff(string $dateOff): static;
}
