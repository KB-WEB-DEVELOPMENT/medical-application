<?php

namespace Claim\Submission\Domain\Enums;

enum PaymentType: int
{
    case PAY_PER_PROCEDURE = 1;
    case PAY_PER_VISIT = 2;    

    // not very useful, shown only for completion
    public function payPerProcedureName(): string
    {
        return  (string)PaymentType::PAY_PER_PROCEDURE->name;       
    }

    public function payPerProcedureValue(): int
    {
        return  PaymentType::PAY_PER_PROCEDURE->value;
    }

    // not very useful, shown only for completion
    public function payPerVisitName(): string
    {
        return  (string)PaymentType::PAY_PER_VISIT->name;
    }

    public function payPerVisitValue(): int
    {
        return  PaymentType::PAY_PER_VISIT->value;
    }

    public function getOtherCaseName(string $caseName): string
    {
        $arr = [];
        $arr[] = (string)PaymentType::PAY_PER_PROCEDURE->name;
        $arr[] = (string)PaymentType::PAY_PER_VISIT->name;

        /*
        if (!in_array($caseName,$arr)) {
            // generate an exception

        }
        */   
        
        return strtoupper((string)PaymentType::PAY_PER_PROCEDURE->name) == strtoupper($caseName) ? (string)PaymentType::PAY_PER_VISIT->name : (string)PaymentType::PAY_PER_PROCEDURE->name;  
        
    }    

    public function getOtherCaseValue(int $caseValue): int
    {
        $arr = [];
        $arr[] = PaymentType::PAY_PER_PROCEDURE->value;
        $arr[] = PaymentType::PAY_PER_VISIT->value;

        /*
        if (!in_array($caseValue,$arr)) {
            // generate an exception

        }
        */

        return PaymentType::PAY_PER_PROCEDURE->value === $caseValue ? PaymentType::PAY_PER_VISIT->value : PaymentType::PAY_PER_PROCEDURE->value;

    }

    // not very useful, shown only for completion
    public function validCaseName(string $caseName): bool
    {
        $arr = [];
        $arr[] = (string)PaymentType::PAY_PER_PROCEDURE->name;
        $arr[] = (string)PaymentType::PAY_PER_VISIT->name;

        return in_array(strtoupper($caseName),$arr);
    }

    public function validCaseValue(int $caseValue): bool
    {
        $arr = [];
        $arr[] = PaymentType::PAY_PER_PROCEDURE->value;
        $arr[] = PaymentType::PAY_PER_VISIT->value;

        return in_array($caseValue,$arr);
    }

}