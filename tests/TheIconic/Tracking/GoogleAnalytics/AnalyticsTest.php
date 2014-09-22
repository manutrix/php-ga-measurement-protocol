<?php

namespace TheIconic\Tracking\GoogleAnalytics;

class AnalyticsTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplePageview()
    {
        $analytics = new Analytics();

        $result = $analytics->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->sendPageview();

        $this->assertEquals('200', $result);
    }

    public function testPurchaseTracking()
    {
        $analytics = new Analytics();

        $analytics->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setUserId('666')
            ->setDocumentHostName('alice.core.au')
            ->setDocumentPath('/');

        $analytics->setTransactionId('12345')
            ->setAffiliation('THE ICONIC')
            ->setRevenue(150.50)
            ->setTax(10.0)
            ->setShipping(15.5)
            ->setCouponCode('TEST');

        $productData = [
            'sku' => 'AAAA-5555',
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'category' => 'Test Category 1/Test Category 2',
            'variant' => 'blue',
            'price' => 85.00,
            'quantity' => 2,
            'coupon_code' => 'TEST',
            'position' => 4
        ];

        $analytics->addProduct($productData);

        $productData = [
            'sku' => 'AAAA-6666',
            'name' => 'Test Product 2',
            'brand' => 'Test Brand 2',
            'category' => 'Test Category 3/Test Category 4',
            'variant' => 'yellow',
            'price' => 50.00,
            'quantity' => 1,
            'coupon_code' => 'TEST 2',
            'position' => 2
        ];

        $analytics->addProduct($productData);

        $analytics->setProductActionToPurchase();

        $result = $analytics->setEventCategory('Checkout')
            ->setEventAction('Purchase')
            ->sendEvent();

        $this->assertEquals('200', $result);
    }
}
