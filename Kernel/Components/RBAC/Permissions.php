<?php

namespace Kernel\Components\RBAC;

enum Permissions: string
{
	//Доступ в кабинет букмекера
	case ACCESS_BOOKMAKER_CABINET = 'oAccessBookmakerCabinet';

	// Доступ в кабинет партнёра
	case ACCESS_PARTNER_CABINET = 'oAccessPartnerCabinet';

	// Выставление счета
	case CREATE_INVOICE = 'oCreateInvoice';

	// Получить родителя субъекта
	case GET_SUBJECT_PARENT = 'oGetSubjectParent';

	// Отмена операции
	case CANCEL_OPERATION = 'oCancelOperation';

	// Частичный возврат платежа
	case RETURN_PART_OF_OPERATION = 'oReturnPartOfOperation';

	// Возврат операции
	case MERCHANT_RETURN = 'oMerchantReturn';

	// Создание пользователя - субмерчанта
	case CREATE_SUB_MERCHANT = 'oCreateSubMerchant';

	// Получение платежа
	case PAYMENT_RECEIVE = 'oPaymentReceive';

	// Отмена входящей операции
	case CANCEL_INCOMING_OPERATION = 'oCancelIncomingOperation';

	// Создание отчета по платежам
	case CREATE_PAYMENTS_REPORT = 'oCreatePaymentsReport';

	// Кастомизация инвойса
	case CUSTOMIZE_INVOICE = 'oCustomizeInvoice';

	// Редактирование кастомного сервиса
	case CUSTOM_MODIFY_SERVICE = 'oCustomModifyService';

	// Определение оператора сотовой связи по номеру телефона
	case GET_MOBILE_OPERATOR = 'oGetMobileOperator';

	// Сторнирование своего перевода (платежа)
	case REVERSE_OWN_TRANSFER = 'oReverseOwnTransfer';

	// Редактирование услуги мерчантом
	case SERVICE_EDIT_WAITING = 'oServiceEditWaiting';

	// Получение перевода
	case TRANSFER_RECEIVE = 'oTransferReceive';

	// Создание инвойсов для родителя
	case USE_PARENT_INVOICE = 'oUseParentInvoice';

	// Отправка смс через шлюз Beeline
	case OBEELINE_SMSNOTIFICATION = 'OBeelineSMSNotification';

	// Пользователь при создании операции может указать специалиста кого угодно
	case CREATE_OPERATION_WITH_SPECIALIST = 'oCreateOperationWithSpecialist';

	// Получить данные чека по идентификатору Oberthur MFS
	case GET_RECEIPT_BY_TRANSACTION_ID = 'oGetReceiptByTransactionId';

	// Создание операций с оплатой через Kcell
	case KCELL_OPERATION = 'oKCellOperation';

	// Отправка СМС через шлюз Kcell
	case KCELL_SMSNOTIFICATION = 'oKcellSMSNotification';

	// Возврат средств на Beeline(Oberthur)/KCell
	case MOBILE_REFUND = 'oMobileRefund';

	// Создание операций с оплатой Билайн
	case OBERTHUR_OPERATION = 'oOberthurOperation';

	// Создание платежа с оплатой СМС
	case SMPP_PAYMENT = 'oSmppPayment';

	// Доступ в кабинет партнера - платформы для мерчантов (маркетплейса)
	case ACCESS_MERCHANT_ADMIN_CABINET = 'oAccessMerchantAdminCabinet';

	// Просмотр статистики в кабинете агрегатора мерчантов
	case VIEW_PARTNER_STATISTIC = 'oViewPartnerStatistic';

	// Просмотр, изменение и создание сотрудника для партнера
	case EMPLOYEES_MANAGEMENT = 'oEmployeesManagement';

	// Просмотр и изменение адреса сайта мерчанта
	case MERCHANT_SITE_MANAGEMENT = 'oMerchantSiteManagement';

	// Удаление дочерних субъектов
	case DELETE_CHILD_SUBJECT = 'oDeleteChildSubject';

	// Доступ в кабинет специалиста СПП Олимп/1xBet
	case ACCESS_BOOKMAKER_SPP_CABINET = 'oAccessBookmakerSppCabinet';

	// Получение от эквайринга данных по операции
	case GET_CARD_OPERATION_INFO = 'oGetCardOperationInfo';

	// Просмотр операций родительского субъекта
	case VIEW_PARENT_OPERATIONS = 'oViewParentOperations';

	// Беспредельный перевод
	case UNLIMITED_TRANSFER = 'oUnlimitedTransfer';

	// Просмотр агентских комиссий
	case VIEW_AGENT_COMMISSIONS = 'oViewAgentCommissions';

	// Просмотр счета комиссий
	case VIEW_COMMISSION_ACCOUNT = 'oViewCommissionAccount';

	// Получение данных по операции по extid
	case GET_OPERATION_DATA_BY_EXT_ID = 'oGetOperationDataByExtId';

	// Получить идентификаторы своих сторнирующих операций
	case GET_OWN_STORNING_OPERATIONS = 'oGetOwnStorningOperations';

	// Операция платежа на родительский счет
	case PAYMENT_ON_PARENT_ACCOUNT = 'oPaymentOnParentAccount';

	// проведение операции Beeline без кода подтверждения
	case SEND_SMSPAYMENT_WITHOUT_CODE = 'oSendSMSPaymentWithoutCode';

	// Отчет по переводам
	case REPORT_TRANSFERS = 'oReportTransfers';

	// Право просматривать список юридических субъектов
	case REPORT_JURIDICAL_SUBJECTS = 'oReportJuridicalSubjects';

	// Список юридических субъектов
	case LIST_JURIDICAL_SUBJECT = 'oListJuridicalSubject';

	// Право создавать/редактировать юридических субъектов
	case JURIDICAL_SUBJECT_PROFILE_EDIT = 'oJuridicalSubjectProfileEdit';

	// Редактирование мерчанта
	case EDIT_MERCHANT = 'oEditMerchant';

	// Создание пользователя - мерчанта
	case CREATE_MERCHANT = 'oCreateMerchant';

	// Доступность сервисов по родительскому субъекту
	case USE_PARENT_SERVICES = 'oUseParentServices';

	// Просмотр операций потомков своего родительского субъекта
	case VIEW_PARENTS_CHILDREN_OPERATIONS = 'oViewParentsChildrenOperations';

	// получение сводной информации по операциям, сгруппированной по сервисам
	case GET_SERVICE_OPERATIONS_COUNT = 'oGetServiceOperationsCount';

	// Отчёт по операциям с фильтрацией по периоду и сервису
	case REPORT_DETAILED_OPERATIONS = 'oReportDetailedOperations';

	// получить количество операций возвратов для текущего субъекта
	case GET_RETURNS_COUNT = 'oGetReturnsCount';

	// Получить остаток на счетах по указанному юзеру на указанную дату
	case GET_REMAINS_TO_DATE = 'oGetRemainsToDate';

	// Редактирование профиля
	case EDIT_PROFILE = 'oEditProfile';

	// Просмотр профиля
	case VIEW_PROFILE = 'oViewProfile';

	// Смена статуса мерчанта
	case CHANGE_STATUS = 'oChangeStatus';

	// Смена статуса мерчанта на созданный
	case CHANGE_SUBJECT_STATUS_TO_CREATED = 'oChangeSubjectStatusToCreated';

	// Смена статуса мерчанта на редактирование
	case CHANGE_SUBJECT_STATUS_TO_MODERATING = 'oChangeSubjectStatusToModerating';

	// Смена статуса мерчанта на актинвый
	case CHANGE_SUBJECT_STATUS_TO_ACTIVE = 'oChangeSubjectStatusToActive';

	// Право на подтверждение операций, оплачиваемых посредством СМС
	case CONFIRM_INVOICE_SMS = 'oConfirmInvoiceSMS';

	// Право на создание операций, оплачиваемых посредством СМС
	case CREATE_INVOICE_SMS = 'oCreateInvoiceSMS';

	// Создание/удаление точек на карте
	case MAP_MARKER_EDIT = 'oMapMarkerEdit';

	// Доступ к онлайн-консультанту
	case ONLINE_CONSULTANT = 'oOnlineConsultant';

	// Сброс попыток восстановления пароля
	case RESET_PASSWORD_RECOVERY_ATTEMPTS = 'oResetPasswordRecoveryAttempts';

	// Разблокировка IP
	case UNBLOCK_IP = 'oUnblockIP';

	// Отчет по всем платежам
	case VIEW_ALL_OPERATIONS = 'oViewAllOperations';

	// Получить историю запросов в биллинг по операции
	case VIEW_BILLING_HISTORY = 'oViewBillingHistory';

	// Просмотр данных (о платежах, переводах и тд) необходимых для работы СПП
	case VIEW_DATA_SPP = 'oViewDataSpp';

	// Доступ к кабинету СПП
	case ACCESS_SPP_CABINET = 'oAccessSppCabinet';

	// Управление FAQ
	case FAQ_MANAGEMENT = 'oFaqManagement';

	// Возврат средств на Beeline (Oberthur) / KCell по любой операции
	case MOBILE_REFUND_ANY = 'oMobileRefundAny';

	// Перепроведение операции в биллинге
	case BILLING_REPAY_OPERATION = 'oBillingRepayOperation';

	// Получение статуса вывода через банкоматы
	case GET_ATM_STATUS = 'oGetAtmStatus';

	// Повторное уведомление мерчанта по инвойсу
	case NOTIFY_INVOICE_MERCHANT = 'oNotifyInvoiceMerchant';

	// Повторное уведомление мерчанта по собственному инвойсу
	case NOTIFY_OWN_INVOICE_MERCHANT = 'oNotifyOwnInvoiceMerchant';

	// Отчет по новым аккаунтам
	case REPORT_REGISTRATIONS = 'oReportRegistrations';

	// Возврат с Z-кошельков (псевдопользователь) на кошелек без Z
	case ZWALLET_RETURN = 'oZWalletReturn';

	// Возврат с Z-кошельков (псевдопользователь) на любой кошелек
	case ZWALLET_RETURN_TO_ANY = 'oZWalletReturnToAny';

	// Смена пароля юр.субъекта
	case JURIDICAL_SUBJECT_PASSWORD_CHANGE = 'oJuridicalSubjectPasswordChange';

	// Отчет по мерчанту для аккаунт менеджера
	case REPORT_ACCOUNT_MANAGER_MERCHANTS = 'oReportAccountManagerMerchants';

	// Отчет по мерчантам за определенный период для аккаунт менеджера
	case REPORT_ACCOUNT_MANAGER_PERIOD = 'oReportAccountManagerPeriod';

	// Возврат средств на Olimp
	case OLIMP_REFUND = 'oOlimpRefund';

	// Отмена различныз операций
	case CANCEL_OTHER_OPERATIONS = 'oCancelOtherOperations';

	// Выключение сервиса на время технических работ
	case TEMPORARILY_DISABLE_SERVICE = 'oTemporarilyDisableService';

	// Частичный возврат платежа
	case PARTIAL_REFUND = 'oPartialRefund';

	// Удаление метки о нахождении операции в очереди проверки статуса
	case DELETE_OPERATION_FROM_STATUS_QUEUE = 'oDeleteOperationFromStatusQueue';

	// Реестр возвратов для агентов, субагентов
	case REPORT_AGENT_REVERTS = 'oReportAgentReverts';

	// Итоговый отчёт о движении ЭД по кошельку субагента/агента
	case REPORT_SUBAGENT_CONSOLIDATED = 'oReportSubagentConsolidated';

	// Получить баланс и профильные данные родителя
	case GET_PARENT_INFO = 'oGetParentInfo';

	// Отчет по кредиторской задолженности
	case REPORT_CREDIT_OPERATIONS = 'oReportCreditOperations';

	// Проведение операций вывода на карту
	case COMPLETE_WITHDRAWAL = 'oCompleteWithdrawal';

	// Подтверждение пополнений с запросами к поставщику
	case OPERATION_ACQUIRING = 'oOperationAcquiring';

	// Подтверждение пополнений с привязанной карты
	case OPERATION_LINKED_CARD = 'oOperationLinkedCard';

	// Перевод неидентифицированного пользователя в именные
	case NOMINATE_USER = 'oNominateUser';

	// Операция с родительским счетом
	case OPERATION_WITH_PARENT_ACCOUNT = 'oOperationWithParentAccount';

	// Создание операций от имени пользователя
	case CREATE_OPERATION_FOR_PSEUDO_USER = 'oCreateOperationForPseudoUser';

	// Подтверждение операции
	case CONFIRM_OPERATION = 'oConfirmOperation';

	// Редактирование настроек безопасности
	case EDIT_SECURITY_SETTINGS = 'oEditSecuritySettings';

	// Получение остатков по кредиторским задолженностям
	case GET_CREDIT_AMOUNT = 'oGetCreditAmount';

	// Отправка платежа
	case PAYMENT_SEND = 'oPaymentSend';

	// Регистрация получателя безадресного перевода
	case REGISTER_ADDRESSLESS_TRANSFER_USER = 'oRegisterAddresslessTransferUser';

	// Отправка перевода
	case TRANSFER_SEND = 'oTransferSend';

	// Пополнение кошелька пользователя
	case TRANSFER_SUBAGENT = 'oTransferSubagent';

	// Отмена, подтверждение, возврат папиных операций
	case WORK_WITH_PARENT_OPERATIONS = 'oWorkWithParentOperations';

	// Возврат средств на Olimp/1XBet
	case BOOKMAKER_REFUND = 'oBookmakerRefund';

	// При подтверждении операции специалист берется из операции
	case CONFIRM_OPERATION_WITH_SPECIALIST = 'oConfirmOperationWithSpecialist';

	// Проведение операции через SMPP
	case SMPP_OPERATION = 'oSmppOperation';

	// Запрос и проверка смс-кода при создании и подтверждении операции
	case WITHDRAWAL_OTHER = 'oWithdrawalOther';

	// Создание субагента
	case CREATE_SUB_AGENT = 'oCreateSubAgent';

	// Просмотр списка подтвержденных коммиссий
	case REPORT_CONFIRMED_COMMISSIONS = 'oReportConfirmedCommissions';

	// Simple Transfer Send
	case SIMPLE_TRANSFER_SEND = 'oSimpleTransferSend';

	// Просмотр сервисов и услуг для агента
	case VIEW_SERVICES_FOR_AGENT = 'oViewServicesForAgent';

	// Просмотр операций дочерних субагентов
	case VIEW_CHILDRENS_OPERATIONS = 'oViewChildrensOperations';

	// Доступ в кабинет финансового специалиста
	case ACCESS_FINANCIAL_CABINET = 'oAccessFinancialCabinet';

	// Права на операцию выпуска электронных денег
	case MONEY_ISSUE = 'oMoneyIssue';

	// Права на операцию выпуска электронных денег
	case MONEY_OPERATIONAL_ISSUE = 'oMoneyOperationalIssue';

	// Создание операции эмиссии с любого эмитента
	case MONEY_OTHER_ISSUE = 'oMoneyOtherIssue';

	// Возможность проводить чужие эмиссии
	case MONEY_PERFORM_OTHER_ISSUE = 'oMoneyPerformOtherIssue';

	// Удаление операции, с отображением в отчётах
	case DELETE_VISIBLE_OPERATION = 'oDeleteVisibleOperation';

	// Создание перевода между субъектами
	case TRANSFER_OTHER_SEND = 'oTransferOtherSend';

	// Создание операций по кредиторской задолженности
	case CREATE_CREDIT_OPERATION = 'oCreateCreditOperation';

	// Отчёт о движении ЭД
	case REPORT_MONEY_MOVEMENT = 'oReportMoneyMovement';

	// Отчет об остатках на счетах
	case REPORT_REMAINING_BALANCE = 'oReportRemainingBalance';

	// Просмотр операций погашения кредитов
	case VIEW_LOANS_REPAYMENT_OPERATIONS = 'oViewLoansRepaymentOperations';

	// Проведение операции перевода на банковский счет
	case CONFIRM_BANK_TRANSFER = 'oConfirmBankTransfer';

	// Возврат денег по операции перевода на банковский счет
	case REVERSE_BANK_TRANSFER = 'oReverseBankTransfer';

	// Права на создание операции погашения электронных денег со счетов мерчанта
	case MONEY_MERCHANT_REDEMPTION = 'oMoneyMerchantRedemption';

	// Права на создание операции погашения электронных денег с системного счёта
	case MONEY_SYSTEM_REDEMPTION = 'oMoneySystemRedemption';

	// Права на создание операции погашения электронных денег со счёта агента
	case MONEY_AGENT_REDEMPTION = 'oMoneyAgentRedemption';

	// Права на проведение операции погашения электронных денег со счетов мерчанта
	case MERCHANT_KVITAN = 'oMerchantKvitan';

	// Права на проведение операции погашения электронных денег со счёта агента
	case AGENT_KVITAN = 'oAgentKvitan';

	// Права на проведение операции погашения электронных денег со счёта субагента
	case SUB_AGENT_KVITAN = 'oSubAgentKvitan';

	// Права на проведение операции погашения электронных денег с системного счёта
	case SYSTEM_KVITAN = 'oSystemKvitan';

	// Генерация МТ100
	case GENERATE_MT100 = 'oGenerateMT100';

	// Отчет о погашении электронных денег
	case REPORT_MONEY_REDEMPTION = 'oReportMoneyRedemption';

	// Доступ к кабинету маркетолога
	case ACCESS_MARKETOLOG_CABINET = 'oAccessMarketologCabinet';

	// Изменить баннеры в сервисах
	case SERVICES_BANNER = 'oServicesBanner';

	// Доступ к кабинету маркетолога МФС
	case ACCESS_MFS_MARKETER_CABINET = 'oAccessMfsMarketerCabinet';

	// Управление новостями МФС
	case MANAGE_MFS_NEWS = 'oManageMfsNews';

	// Просмотр доступных услуг для шлюза
	case VIEW_GATEWAY_SERVICES = 'oViewGatewayServices';

	// Отправить запрос на изменение комиссии для шлюза
	case SEND_REQUEST_TO_CHANGE_GATEWAY_COMMISSION = 'oSendRequestToChangeGatewayCommission';

	// Редактирование услуг для шлюза
	case UPDATE_GATEWAY_SERVICES = 'oUpdateGatewayServices';

	// Отправка ссылки на email для сброса пароля любого пользователя
	case PASSWORD_RESET_ANY_USER = 'oPasswordResetAnyUser';

	case CREATE_PARTNER_USER = 'oCreatePartnerUser';

	// Просмотр раздела поиска платежей
	case MERCHANT_VIEW_PAYMENT = 'oMerchantViewPayment';

	// Просмотр раздела обращений в поддержку
	case MERCHANT_REQUEST_SUPPORT = 'oMerchantRequestSupport';

	// Просмотр нового функционала (бета-тестирование)
	case NEW_FEATURES_ACCESS = 'oGetNewFunctions';

    //Просмотр расширенного отчета по операциям
    case REPORT_EXTENDED_OPERATIONS = 'oReportExtendedOperations';

    // Создание бухгалтера
    case CREATE_MERCHANT_EMPLOYEE_ACCOUNTANT = 'oCreateMerchantEmployeeAccountant';

    // Создание главного бухгалтера
    case CREATE_MERCHANT_EMPLOYEE_CHIEF_ACCOUNTANT = 'oCreateMerchantEmployeeChiefAccountant';

    // Создание главного менеджера
    case CREATE_MERCHANT_EMPLOYEE_CHIEF_MANAGER = 'oCreateMerchantEmployeeChiefManager';

    // Создание менеджера
    case CREATE_MERCHANT_EMPLOYEE_MANAGER = 'oCreateMerchantEmployeeManager';

    // Создание главного СП
    case CREATE_MERCHANT_EMPLOYEE_CHIEF_SUPPORT = 'oCreateMerchantEmployeeChiefSupport';

    // Создание СП
    case CREATE_MERCHANT_EMPLOYEE_SUPPORT = 'oCreateMerchantEmployeeSupport';

    // Поиск пользователя
    case SEARCH_USER = 'oSearchUser';

    // Проверка платежей
    case CHECK_PAYMENTS = 'oCheckPayments';

    // Проверка мобильного тарифа
    case CHECK_MOBILE_TARIFF = 'oCheckMobileTariff';

    // Проверка статуса Netbet
    case CHECK_NETBET_OPERATION = 'oCheckNetbetOperation';

    // Подтверждение операции от имени пользователя
    case CONFIRM_OPERATION_FOR_USER = 'oConfirmOperationForUser';

    // Метод смены статуса с 17-го на 11
    case RESTORE_DELETED_OPERATION = 'oRestoreDeletedOperation';

    // Возврат для пользователя
    case REVERSE_OPERATION_OF_USER = 'oReverseOperationOfUser';

    // Сторнирование перевода (платежа)
    case REVERSE_TRANSFER = 'oReverseTransfer';

    // Архивирование пользователей
    case CLOSE_SUBJECT = 'oCloseSubject';

	/**
	 * @return list<value-of<self::*>>
	 */
	public static function getValuesAsArray(): array
	{
		return array_column(self::cases(), 'value');
	}
}
