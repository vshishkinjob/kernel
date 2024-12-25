<?php

namespace Kernel\Components\Repository\Components\Tps\Commands;

enum ReportCommands: int
{
    /**
     * отчёт о регистрации пользователей
     */
    case GENERAL_SUBJECT_REPORT = 0;

    /**
     * отчёт по юридическим субъектам
     */
    case JURIDICAL_SUBJECT_REPORT = 22;

    /**
     * отчёт по переводам и платежам (полный)
     */
    case TRANSFER_PAYMENT_EXTENDED_REPORT = 23;

    /**
     * отчёт по периоду для аккаунт-менеджера
     */
    case ACCOUNT_MANAGER_PERIOD_REPORT = 25;

    /**
     * отчёт по мерчантам для аккаунт-менеджера
     */
    case ACCOUNT_MANAGER_MERCHANTS_REPORT = 26;

    /**
     * отчёт по операциям (расширенный)
     */
    case OPERATIONS_EXTENDED_REPORT = 61;
}
