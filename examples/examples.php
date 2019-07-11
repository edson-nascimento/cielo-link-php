<?php
use CieloLink\API\Environment;
use CieloLink\API\CieloLink;
use CieloLink\API\Payment;
use CieloLink\API\Shipping;
use CieloLink\API\Recurrent;

require_once '../vendor/autoload.php';

$clientId      = "dc9d6efa-b582-4ac8-ac59-12c57245df2a";
$clientSecret  = "d4bAh9FeILpJvntoVceFhJ8ETdqVJetYpu4kZlZXeuA8r9dS1PPdZXmS5egN6a9n";
$environment    = Environment::production();

$cieloLink = new CieloLink($clientId, $clientSecret, $environment);

$payment = new Payment();
$payment->setType(Payment::TYPE_RECURRENT);
$payment->setName("Product Test");
$payment->setExpirationDate("2037-06-19");
$payment->setDescription("Product Test");
$payment->setPrice(127.75);
$payment->setShowDescription(true);
$payment->setSoftDescriptor("Order1234");

$payment->shipping()
        ->setName("Test")
        ->setOriginZipCode("00000000")
        ->setPrice(0)
        ->setType(Shipping::TYPE_WITHOUT_SHIPPING);

$payment->recurrent()
        ->setEndDate("2030-01-27")
        ->setInterval(Recurrent::TYPE_MONTHLY);

// Create
$responsePayment = $cieloLink->create($payment);

// Find
$responsePayment = $cieloLink->get($responsePayment->getId());

// Update
$responsePayment->setName("Product Alter 2");
$responsePayment->setExpirationDate("2020-01-01");
$responsePayment->setType(Payment::TYPE_PAYMENT);

$responsePayment = $cieloLink->update($responsePayment);

//Delete
$responsePayment = $cieloLink->delete($responsePayment->getId());