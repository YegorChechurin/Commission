<?php

namespace YegorChechurin\CommissionTask\Service\DateTimeOperations;

class DateChecker
{
	public function checkDatesAreOnSameWeek(string $firstDate, string $secondDate): bool
	{
		$onSameWeek = true;

		$year1 = date('o', strtotime($firstDate));
		$year2 = date('o', strtotime($secondDate));

		if ($year1 !== $year2) {
			$onSameWeek = false;
		} else {
			$week1 = date('W', strtotime($firstDate));
			$week2 = date('W', strtotime($secondDate));

			if ($week1 !== $week2) {
				$onSameWeek = false;
			}
		}

		return $onSameWeek;
	}
}
