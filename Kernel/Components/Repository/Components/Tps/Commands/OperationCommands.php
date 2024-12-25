<?php

namespace Kernel\Components\Repository\Components\Tps\Commands;

enum OperationCommands: int
{
    /**
     * платёж
     */
    case PAYMENT = 1;

    /**
     * перевод денег
     */
    case TRANSFER = 3;

    /**
     * Закрыть операцию
     */
    case CLOSE_OPERATION = 7;

    /**
     * возврат денег торговцем
     */
    case REVERSE_OPERATION = 26;

    /**
     * частичный возврат средств с операции
     */
    case RETURN_PART_OF_OPERATION = 50;

    /**
     * проверка статуса платежа через биллинг и подтверждение или отмена его в системе
     */
    case BILLING_CHECK_STATUS = 51;

    /**
     * проверка оставшейся суммы по идентификатору операции
     */
    case GET_REMAIN_SUM_BY_OPERATION_ID = 52;

    /**
     * Проведение платежа на биллинг из очереди
     */
    case PROVIDE_BILLING_PAY_FROM_QUEUE = 63;

    /**
     * получение всех потомков операции
     */
    case GET_OPERATION_CHILDREN = 75;

    /**
     * уведомление мерчанта об оплаченном инвойсе
     */
    case NOTIFY_INVOICE_MERCHANT = 117;

    /**
     * возврат средств на Beeline (Oberthur) / KCell
     */
    case MOBILE_REFUND = 127;

    /**
     * возврат средств на Olimp/1XBet
     */
    case BOOKMAKER_REFUND = 141;

    /**
     * Восстановление удаленной операции(смена статуса с 17 на 11)
     */
    case RESTORE_DELETED_OPERATION = 195;

    /**
     * Отмена незавершенной дочерней операции
     */
    case CANCEL_INCOMPLETE_DAUGHTER_OPERATION = 199;

    /**
     * Проверка статуса операции
     */
    case CHECK_OPERATION_STATUS = 200;

    /**
     * Проведение платежа для заблокированного пользователя
     */
    case BLOCKED_USER_PAYMENT_COMPLETE = 202;
}
