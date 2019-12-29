<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\AbstractSettingsManager;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\Exception\RuntimeException\UnsupportedOperationException;

class CommissionsManager extends AbstractSettingsManager
{
	public function getCommissionParameters(string $operationName, string $userType): array
	{
		$this->checkOperationIsSupported($operationName, $userType);

		return $this->settings[$operationName];
	}

	private function checkOperationIsSupported(string $operationName, string $userType)
	{
		if (!array_key_exists($operationName, $this->settings) || !array_key_exists($userType, $this->settings[$operationName])) {
			throw new UnsupportedOperationException($operationName, $userType);
		}
	}
}
