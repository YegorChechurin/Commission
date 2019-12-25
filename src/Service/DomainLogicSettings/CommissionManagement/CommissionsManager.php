<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\AbstractSettingsManager;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\Exception\RuntimeException\UnsupportedOperationException;

class CommissionsManager extends AbstractSettingsManager
{
	public function getCommissionParameters(string $operationName): array
	{
		$this->checkOperationIsSupported($operationName);

		return $this->settings[$operationName];
	}

	private function checkOperationIsSupported(string $operationName)
	{
		if (!array_key_exists($operationName, $this->settings)) {
			throw new UnsupportedOperationException($operationName);
		}
	}
}
