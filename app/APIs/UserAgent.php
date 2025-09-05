<?php

namespace App\APIs;

class UserAgent
{
    const IG_VERSION = '146.0.0.27.125';
    const VERSION_CODE = '221134032';
    const USER_AGENT_LOCALE = 'en_US';
    const USER_AGENT_FORMAT = 'Instagram %s Android (%s/%s; %s; %s; %s; %s; %s; %s; %s; %s)';
    const DEVICES = [
        '28/9.0.0; 420dpi; 1080x2131; samsung; SM-S9210; star2gltechn; qcom',
        '28/9.0.0; 480dpi; 1440x2560; samsung; SM-A505FN; exynos9610; a50',
    ];
    const REQUIRED_ANDROID_VERSION = '2.2';
    private $_manufacturer;
    private $_deviceString;
    private $_userAgent;
    /**
     * @var mixed|string
     */
    private $_androidVersion;
    /**
     * @var mixed|string
     */
    private $_androidRelease;
    /**
     * @var mixed|string
     */
    private $_dpi;
    /**
     * @var mixed|string
     */
    private $_resolution;
    /**
     * @var mixed|string|null
     */
    private $_brand;
    /**
     * @var mixed|string
     */
    private $_model;
    /**
     * @var mixed|string
     */
    private $_device;
    /**
     * @var mixed|string
     */
    private $_cpu;

    protected function _initFromDeviceString()
    {
        $deviceString = self::getRandomGoodDevice();
        if (!is_string($deviceString) || empty($deviceString)) {
            throw new \RuntimeException('Device string is empty.');
        }

        // Split the device identifier into its components and verify it.
        $parts = explode('; ', $deviceString);
        if (count($parts) !== 7) {
            throw new \RuntimeException(sprintf('Device string "%s" does not conform to the required device format.', $deviceString));
        }

        // Check the android version.
        $androidOS = explode('/', $parts[0], 2);
        if (version_compare($androidOS[1], self::REQUIRED_ANDROID_VERSION, '<')) {
            throw new \RuntimeException(sprintf('Device string "%s" does not meet the minimum required Android version "%s" for Instagram.', $deviceString, self::REQUIRED_ANDROID_VERSION));
        }

        // Check the screen resolution.
        $resolution = explode('x', $parts[2], 2);
        $pixelCount = (int)$resolution[0] * (int)$resolution[1];
        if ($pixelCount < 2073600) { // 1920x1080.
            throw new \RuntimeException(sprintf('Device string "%s" does not meet the minimum resolution requirement of 1920x1080.', $deviceString));
        }

        // Extract "Manufacturer/Brand" string into separate fields.
        $manufacturerAndBrand = explode('/', $parts[3], 2);

        // Store all field values.
        $this->_deviceString = $deviceString;
        $this->_androidVersion = $androidOS[0]; // "23".
        $this->_androidRelease = $androidOS[1]; // "6.0.1".
        $this->_dpi = $parts[1];
        $this->_resolution = $parts[2];
        $this->_manufacturer = $manufacturerAndBrand[0];
        $this->_brand = (isset($manufacturerAndBrand[1])
            ? $manufacturerAndBrand[1] : null);
        $this->_model = $parts[4];
        $this->_device = $parts[5];
        $this->_cpu = $parts[6];
        $this->_userAgent = self::buildUserAgent($this);
    }

    public function getDeviceString()
    {
        return $this->_deviceString;
    }

    public function getUserAgent()
    {
        self::_initFromDeviceString();
        return $this->_userAgent;
    }


    public function getAndroidVersion()
    {
        return $this->_androidVersion;
    }

    public function getAndroidRelease()
    {
        return $this->_androidRelease;
    }

    public function getDPI()
    {
        return $this->_dpi;
    }

    public function getResolution()
    {
        return $this->_resolution;
    }

    public function getManufacturer()
    {
        return $this->_manufacturer;
    }

    public function getBrand()
    {
        return $this->_brand;
    }

    public function getModel()
    {
        return $this->_model;
    }


    public function getDevice()
    {
        return $this->_device;
    }

    public function getCPU()
    {
        return $this->_cpu;
    }

    public static function buildUserAgent($device)
    {
        // Build the appropriate "Manufacturer" or "Manufacturer/Brand" string.
        $manufacturerWithBrand = $device->getManufacturer();
        if ($device->getBrand() !== null) {
            $manufacturerWithBrand .= '/' . $device->getBrand();
        }

        // Generate the final User-Agent string.
        return sprintf(
            self::USER_AGENT_FORMAT,
            self::IG_VERSION, // App version ("27.0.0.7.97").
            $device->getAndroidVersion(),
            $device->getAndroidRelease(),
            $device->getDPI(),
            $device->getResolution(),
            $manufacturerWithBrand,
            $device->getModel(),
            $device->getDevice(),
            $device->getCPU(),
            self::USER_AGENT_LOCALE,
            self::VERSION_CODE
        );
    }

    public static function getRandomGoodDevice()
    {
        $randomIdx = array_rand(self::DEVICES, 1);

        return self::DEVICES[$randomIdx];
    }

}
