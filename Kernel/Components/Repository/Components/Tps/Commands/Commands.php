<?php

namespace Kernel\Components\Repository\Components\Tps\Commands;

enum Commands: int
{
    /**
     * аутентификация
     */
    case AUTHENTICATION = 2;

    /**
     * выход из системы
     */
    case LOGOUT = 3;

    /**
     * простой поиск субъекта
     */
    case SEARCH_SUBJECT = 8;

    /**
     * запрос баланса субъекта
     */
    case GET_SUBJECT_BALANCE = 17;

    /**
     * завершение смены пароля пользователем
     */
    case USER_PASSWORD_RESET_EMAIL = 19;

    /**
     * инициация смены пароля пользователем
     */
    case USER_PASSWORD_RESET_SECRET_ANSWER = 18;

    /**
     * закрытие субъекта
     */
    case CLOSE_SUBJECT = 43;

    /**
     * изменение профиля пользователя
     */
    case UPDATE_SUBJECT_PROFILE = 56;

    /**
     * смена пароля
     */
    case CHANGE_PASSWORD_BY_PREVIOUS_PASSWORD = 80;

    /**
     * рассылка писем
     */
    case EMAIL_NOTIFICATION = 92;

    /**
     * получить список rbac-объектов
     */
    case GET_RBAC_OBJECT_LIST = 112;

    /**
     * получить связки RBAC-объектов между собой
     */
    case GET_RBAC_LINKS = 117;

    /**
     * смена адреса почты
     */
    case UPDATE_EMAIL = 124;

    /**
     * получить данные чека по идентификатору операции
     */
    case GET_RECEIPT_FOR_OPER = 127;

    /**
     * разблокировка ip-адреса
     */
    case UNBLOCK_IP = 130;

    /**
     * получить список сервисов, которыми пользовался пользователь
     */
    case GET_SERVICE_LIST_USERS = 153;

    /**
     * установить метку Approved для МТ100
     */
    case SET_MT100_APPROVED = 157;

    /**
     * смена пароля у юридического субъекта
     */
    case JURIDICAL_SUBJECT_PASSWORD_CHANGE = 165;

    /**
     * смена пароля по временному авторизационному ключу
     */
    case CHANGE_PASSWORD_BY_AUTHCODE = 171;

    /**
     * сброс попыток восстановления пароля
     */
    case RESET_PASSWORD_RECOVERY_ATTEMPTS = 203;

    /**
     * получить карточные данные по идентификаторам операций
     */
    case GET_CARD_OPERATIONS_INFO = 204;

    /**
     * получение данных текущего пользователя
     */
    case GET_CURRENT_SUBJECT_DATA = 216;

    /**
     * аутентификация
     */
    case REGISTER_TOKEN = 215;

    /**
     * получить список привязанных аккаунтов соц. сетей для субьекта
     */
    case GET_SUBJECT_SOCIAL_LINKS_LIST = 228;

    /**
     * определение оператора, которому принадлежит номер
     */
    case GET_MOBILE_OPERATOR = 234;

    /**
     * получить дополнительную информацию по субъекту
     */
    case GET_SUBJECT_ADD_INFO = 246;

    /**
     * получение статуса вывода через банкоматы
     */
    case GET_ATM_STATUS = 276;

    /**
     * именование субъекта
     */
    case NOMINATE_SUBJECT = 292;

    /**
     * получить данные операции по идентификаторам
     */
    case GET_SIMPLE_OPERATIONS_DATA = 293;

    /**
     * рассылка push уведомлений
     */
    case PUSH_NOTIFICATION = 307;

    /**
     * удалить метку BILLING_STATUS_QUEUE
     */
    case DELETE_OPERATION_FROM_STATUS_QUEUE = 313;

    /**
     * Получение доступных балансов субъекта во всех валютах
     */
    case GET_SUBJECT_ACTIVE_BALANCES = 364;

    /**
     * Создание сотрудников для мерчанта
     */
    case CREATE_MERCHANT_EMPLOYEE = 368;

    /**
     * Удаление работника мерчанта
     */
    case DELETE_MERCHANT_EMPLOYEE = 384;
}
