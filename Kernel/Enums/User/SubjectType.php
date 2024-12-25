<?php

namespace Kernel\Enums\User;

enum SubjectType: int
{
    /**
     * Контрагент может выполнять операции эмитента
     */
    case EMITENT = 1000;

    /**
     * Контрагент администрирует пользователей эмитента
     */
    case EMITENT_ADMIN = 1001;

    /**
     * Операционист эмитента, проводит операции
     */
    case EMITENT_OPERATIONIST = 1002;

    /**
     * Маркетолог эмитента, смотрит отчеты по операциям
     */
    case EMITENT_MARKETOLOG = 1003;

    /**
     * Контрагент может выполнять операции агента
     */
    case AGENT = 2000;

    /**
     * Контрагент может выполнять операции агента, пользуется своим счетом
     */
    case SUB_AGENT = 2001;

    /**
     * Лицензиат
     */
    case LICENSEE = 2003;

    /**
     * Контрагент может выполнять операции торговца
     */
    case MERCHANT = 3000;

    /**
     * Группа неидентифицированных контрагентов, может выполнять операции неидентифицированного пользователя
     */
    case USER_UNIDENT = 5000;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Smart School
     */
    case USER_UNIDENT_SMART = 5001;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации
     */
    case USER_UNIDENT_PSEUDO = 5002;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, безадресный перевод
     */
    case USER_UNIDENT_ADDRESSLESS = 5003;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, вывод на карту
     */
    case USER_UNIDENT_WITHDRAWAL = 5004;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, автоматическое создание при покупке страхового полиса
     */
    case USER_UNIDENT_POLICY = 5005;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Beeline
     */
    case USER_BEELINE_PORTAL_GENERATED = 5006;

    /**
     * СПП портала Beeline
     */
    case USER_BEELINE_PORTAL_SUPPORT_USER = 5007;

    /**
     *
     * @deprecated
     */
    case USER_POST_EXPRESS_OPERATOR = 5008;

    /**
     *
     * @deprecated
     */
    case USER_POST_EXPRESS_ADMIN = 5009;

    /**
     * Пользователь, автоматически создаваемый при оплате услуг мерчантом от имени пользователя
     */
    case USER_UNIDENT_PSEUDO_BY_AGENT = 5010;

    /**
     * Пользователь, автоматически создаваемый при входе через соц. сети
     */
    case USER_UNIDENT_PSEUDO_SOCIAL = 5011;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Resmi
     */
    case USER_UNIDENT_RESMI = 5012;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации, Resmi
     */
    case USER_UNIDENT_RESMI_PSEUDO = 5013;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, безадресный перевод, Resmi
     */
    case USER_UNIDENT_RESMI_ADDRESSLESS = 5014;

    /**
     * СПП Resmi
     */
    case USER_RESMI_SUPPORT_USER = 5015;

    /**
     * оператор мерчантской точки
     */
    case USER_MERCHANT_POINT_OPERATOR = 5016;

    /**
     * СПП портала Kcell
     */
    case USER_KCELL_PORTAL_SUPPORT_USER = 5017;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Kcell
     * @deprecated
     */
    case USER_ACTIV_PORTAL_GENERATED = 5018;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации, с привязкой карт
     */
    case USER_UNIDENT_PSEUDO_WITH_CARDS = 5019;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Kcell
     */
    case USER_KCELL_PORTAL_GENERATED = 5020;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, KTPay
     */
    case USER_UNIDENT_KTPAY = 5021;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, BI
     */
    case USER_UNIDENT_BI = 5022;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Tele2
     */
    case USER_TELE2_PORTAL_GENERATED = 5023;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Region
     */
    case USER_UNIDENT_REGION = 5024;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Activ wallet
     */
    case USER_UNIDENT_ACTIV = 5025;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Kcell wallet
     */
    case USER_UNIDENT_KCELL = 5026;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Bipek
     */
    case USER_UNIDENT_BIPEK = 5027;

    /**
     * Упрощенно идентифицированный пользователь, автоматически создаваемый при оплате услуг мерчантом от имени пользователя
     */
    case USER_NOMINATED_PSEUDO_BY_AGENT = 5028;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Babilon
     */
    case USER_BABILON_PORTAL_GENERATED = 5029;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Uztelecom
     */
    case USER_UZTELECOM_PORTAL_GENERATED = 5030;

    /**
     * Идентифицированный пользователь, автоматически создаваемый при оплате услуг мерчантом от имени пользователя
     */
    case USER_IDENTIFIED_PSEUDO_BY_AGENT = 5031;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Zhiber
     */
    case USER_UNIDENT_ZHIBER = 5032;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Zhiber
     */
    case USER_UNIDENT_GABERMAN = 5033;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Beeline Uz
     */
    case USER_BEELINE_UZ_PORTAL_GENERATED = 5034;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Tcell
     */
    case USER_TCELL_PORTAL_GENERATED = 5035;

    /**
     * СПП портала Tcell
     */
    case USER_TCELL_PORTAL_SUPPORT_USER = 5036;

    /**
     * СПП портала Tele2
     */
    case USER_TELE2_PORTAL_SUPPORT_USER = 5037;

    /**
     * СПП портала Babilon
     */
    case USER_BABILON_PORTAL_SUPPORT_USER = 5038;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Zetmobile
     */
    case USER_ZETMOBILE_PORTAL_GENERATED = 5039;

    /**
     * СПП портала Zetmobile
     */
    case USER_ZETMOBILE_PORTAL_SUPPORT_USER = 5040;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, ZAAMIN
     */
    case USER_UNIDENT_ZAAMIN = 5041;

    /**
     * Пользователь, автоматически создаваемый при оплате через портал Megafon
     */
    case USER_MEGAFON_PORTAL_GENERATED = 5042;

    /**
     * СПП портала Megafon
     */
    case USER_MEGAFON_PORTAL_SUPPORT_USER = 5043;

    /**
     * Пользователь, автоматически создаваемый для OLE
     */
    case USER_UNIDENT_PSEUDO_OLE = 5044;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, InDrive
     */
    case USER_UNIDENT_INDRIVE = 5045;

    /**
     * Контрагент может выполнять операции неидентифицированного пользователя, Russia
     */
    case USER_UNIDENT_RUSSIA = 5046;

    /**
     * Физическое лицо
     */
    case PHYS_USER = 5999;

    /**
     * Администратор системы
     */
    case ADMIN = 6000;
}
