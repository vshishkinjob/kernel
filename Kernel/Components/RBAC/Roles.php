<?php

namespace Kernel\Components\RBAC;

enum Roles: string
{
	// Мерчант
	case MERCHANT = 'rMerchant';

    // бухгалтер мерчанта
    case MERCHANT_ACCOUNTANT = 'rMerchantAccountant';

    // главный бухгалтер мерчанта
    case MERCHANT_CHIEF_ACCOUNTANT = 'rMerchantChiefAccountant';

    // СП мерчанта
    case MERCHANT_SUPPORT = 'rMerchantSupport';

    // главный СП мерчанта
    case MERCHANT_CHIEF_SUPPORT = 'rMerchantChiefSupport';

    // менеджер мерчанта
    case MERCHANT_MANAGER = 'rMerchantManager';

    // главный менеджер мерчанта
    case MERCHANT_CHIEF_MANAGER = 'rMerchantChiefManager';

	// Мерчант с возможностью создания операции с оплатой СМС
	case MERCHANT_SMPP = 'rMerchantSmpp';

	// Партнёр, являющийся маркетплейсом или платформой, аккумулирующей других мерчантов
	case MERCHANT_ADMIN = 'rMerchantAdmin';

	// Менеджер - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сайтами и сотрудниками
	case PARTNER_MANAGER = 'rPartnerManager';

	// Разработчик - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сотрудниками и статистики
	case PARTNER_DEVELOPER = 'rPartnerDeveloper';

	// Оператор - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сотрудниками, сайтами и статистики.
	case PARTNER_OPERATOR = 'rPartnerOperator';

	// Субмерчант
	case SUB_MERCHANT = 'rSubMerchant';

	// сотрудник СПП Олимп/1xBet для просмотра операций пополнения
	case BOOKMAKER_SPP_MERCHANT = 'rBookmakerSppMerchant';

	// сотрудник СПП Олимп/1xBet для просмотра операций вывода
	case BOOKMAKER_SPP_SUB = 'rBookmakerSppSub';

	//Букмекер
	case BOOKMAKER = 'rBookmaker';

	// Оплата родителю
	case PAYMENT_TO_PARENT = 'rPaymentToParent';

	// Мерчант с возможностью проведения операции с оплатой СМС без кода подтверждения
	case MERCHANT_BEELINE_DIRECT_PAYMENT = 'rMerchantBeelineDirectPayment';

	// Управляет данными по мерчанту, без удаления
	case MERCHANT_EDITOR = 'rMerchantEditor';

	// Мерчант для старой схемы работы с Kcell
	case MERCHANT_KCELL = 'rMerchantKcell';

	// Мерчант для офлайн оплаты по QR
	case MERCHANT_OFFLINE_QR = 'rMerchantOfflineQr';

	// Кассир QRPay
	case MERCHANT_POINT_OPERATOR = 'rMerchantPointOperator';

	// Субагент
	case SUB_AGENT = 'rSubAgent';

	// Просмотр операций дочерних субагентов
	case VIEW_CHILDRENS_OPERATIONS = 'rViewChildrensOperations';

	// Cубагент с правом просматривать реестр по кошельку
	case SUBAGENT_AUDITOR = 'rSubagentAuditor';

	// Оператор субагента
	case SUB_AGENT_OPERATOR = 'rSubAgentOperator';

	// Субагент с эквайрингом
	case SUB_AGENT_WITH_ACQUIRING = 'rSubAgentWithAcquiring';

	// Субагент для привязанных карт
	case SUB_AGENT_FOR_LINKED_CARD = 'rSubAgentForLinkedCard';

	// Субагент с правом перевода неидентифицированных пользователей в именные
	case SUBAGENT_NOMINATOR = 'rSubagentNominator';

	// Субагент, пользующийся агентским счетом
	case SUB_AGENT_POST_PAID = 'rSubAgentPostPaid';

	// Субагент для оплаты услуг от имени пользователей
	case SUB_AGENT_FOR_PSEUDO_USER = 'rSubAgentForPseudoUser';

	// Субагент с возможностью вывода денег с кошелька
	case SUB_AGENT_WITH_CASH_OUT = 'rSubAgentWithCashOut';

	// Использование сервисов родителя
	case SERVICE_BY_PARENT = 'rServiceByParent';

	//Бухгалтер
	case BOOKMAKER_ACCOUNTANT = 'rBookmakerAccountant';

	//Поддержка
	case BOOKMAKER_TECHNICAL_SUPPORT = 'rBookmakerSupport';

	//Администратор
	case BOOKMAKER_ADMIN = 'rBookmakerAdmin';

	// Мерчант с правом доступа к разделу поиска платежа
	case MERCHANT_VIEW_PAYMENT = 'rMerchantViewPayment';

	// Мерчант с правом доступа к разделу обращений в поддержку
	case MERCHANT_REQUEST_SUPPORT = 'rMerchantRequestSupport';

	// Мерчант с правом доступа к закрытому новому функционалу
	case EXPERIMENTAL_FEATURES = 'rExperimentalFeatures';

    case OPERATOR_SPP = 'rOperatorSPP';

    case UPPER_OPERATOR_SPP = 'rUpperOperatorSPP';

    case ADVANCED_OPERATOR_SPP = 'rAdvancedOperatorSPP';

    case GRAND_MASTER_SPP = 'rGrandMasterSPP';

    case MASTER_SPP = 'rMasterSPP';

	/**
	 * @return list<value-of<self::*>>
	 */
	public static function getAvailableRoles(): array
	{
		return array_column(self::cases(), 'value');
	}
}
