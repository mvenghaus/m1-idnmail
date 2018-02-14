<?php

class Inkl_IdnMail_Model_Observer
{

	public function sales_order_save_before(Varien_Event_Observer $observer)
	{
		/** @var Mage_Sales_Model_Order $order */
		$order = $observer->getEvent()->getOrder();
		if ($order instanceof Mage_Sales_Model_Order)
		{
			$order->setCustomerEmail($this->convertIdn($order->getCustomerEmail()));
		}
	}

	public function convertIdn($email)
	{
		try
		{
			$idn = new \Mso\IdnaConvert\IdnaConvert();

			list($name, $domain) = explode('@', $email);

			$domain = $idn->encode($domain);

			return implode('@', [$name, $domain]);
		} catch (Exception $e)
		{
		}

		return $email;
	}

}