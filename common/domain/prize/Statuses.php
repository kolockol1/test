<?php

namespace common\domain\prize;

class Statuses
{
    public const UNDEFINED = 0;
    public const APPLIED = 1;
    public const DECLINED = 2;
    public const SENT_BY_POST = 3;
    public const PAID = 4;
    public const CONVERTED_TO_POINTS = 5;
    public const UNPAID = 6;

}