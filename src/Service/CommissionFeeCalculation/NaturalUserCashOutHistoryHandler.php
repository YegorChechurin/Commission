<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\DateTimeOperations\DateChecker;

class NaturalUserCashOutHistoryHandler
{
    private $userHistory;

    /**
     * @var DateChecker
     */
    private $dateChecker;

    public function __construct(DateChecker $dateChecker)
    {
        $this->userHistory = [];

        $this->dateChecker = $dateChecker;
    }

    public function getUserOperationsHistory(string $userId, string $operationDate, string $operationAmountEUR): array
    {
        if (array_key_exists($userId, $this->userHistory)) {
            $this->updateUserHistoryRecord($userId, $operationDate, $operationAmountEUR);
        } else {
            $this->createUserHistoryRecord($userId, $operationDate, $operationAmountEUR);
        }

        return $this->userHistory[$userId];
    }

    private function updateUserHistoryRecord(string $userId, string $operationDate, string $operationAmountEUR)
    {
        if (!$this->dateChecker->checkDatesAreOnSameWeek($operationDate, $this->userHistory[$userId]['date'])) {
            $this->createUserHistoryRecord($userId, $operationDate, $operationAmountEUR);
        } else {
            $this->userHistory[$userId]['operation_count']++;
            $this->userHistory[$userId]['total_amount_in_euro'] += $operationAmountEUR;
            $this->userHistory[$userId]['date'] = $operationDate;
        }
    }

    private function createUserHistoryRecord(string $userId, string $operationDate, string $operationAmountEUR)
    {
        $this->userHistory[$userId] = [
            'operation_count' => 1,
            'date' => $operationDate,
            'total_amount_in_euro' => $operationAmountEUR,
        ];
    }
}
