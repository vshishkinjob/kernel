<?php

namespace Kernel\Components\Exception;

enum TpsErrorType: int
{
    case ERROR_UNKNOWN_ERROR = 1;

    case ERROR_HEADERS_CHECK = 2;

    case ERROR_DB_UNAVAILABLE = 1001;

    case ERROR_INSERT_SUBJECT = 1002;

    case ERROR_IDENTIFY_SUBJECT = 1003;

    case ERROR_RESET_PASSWORD = 1004;

    case ERROR_CHANGE_SUBJECT_TYPE = 1005;

    case ERROR_EMISSION = 1006;

    case ERROR_DISCHARGEMENT_FAILED = 1007;

    case ERROR_PAYMENT_FAILED = 1008;

    case ERROR_TRANSFER_FAILED = 1009;

    case ERROR_NEW_MONEY_OPERATION_FAILED = 1010;

    case ERROR_CONFIRM_OPERATION_FAILED = 1011;

    case ERROR_CREATE_COMMISSION_FAILED = 1012;

    case ERROR_CREATE_ACCOUNT_FAILED = 1013;

    case ERROR_SAVE_OPERATION_FAILED = 1015;

    case ERROR_BLOCK_TERMINAL_FAILED = 1016;

    case ERROR_UNBLOCK_TERMINAL_FAILED = 1017;

    case ERROR_USER_BLOCK_SUBJECT_FAILED = 1018;

    case ERROR_USER_UNBLOCK_SUBJECT_FAILED = 1019;

    case ERROR_SYSTEM_BLOCK_SUBJECT_FAILED = 1020;

    case ERROR_SYSTEM_UNBLOCK_SUBJECT_FAILED = 1021;

    case ERROR_GET_BALANCE_FAILED = 1022;

    case ERROR_CANCEL_OPERATION = 1026;

    case ERROR_LOGOUT_FAILED = 1027;

    case ERROR_ASSIGN_SUBJECT_ROLES_FAILED = 1028;

    case ERROR_SEARCH_SUBJECT_FAILED = 1029;

    case ERROR_INSUFFICIENT_FUNDS = 1030;

    case ERROR_MODIFY_COMMISSION_FAILED = 1031;

    case ERROR_DELETE_COMMISSION_FAILED = 1032;

    case ERROR_CREATE_LIMIT_FAILED = 1035;

    case ERROR_GET_LIMIT_FAILED = 1036;

    case ERROR_DELETE_LIMIT_FAILED = 1037;

    case ERROR_SUBJECT_SUPERVISION_ON_FAILED = 1043;

    case ERROR_SUBJECT_SUPERVISION_OFF_FAILED = 1044;

    case ERROR_ACCOUNT_SUPERVISION_ON_FAILED = 1045;

    case ERROR_ACCOUNT_SUPERVISION_OFF_FAILED = 1046;

    case ERROR_SUBJECT_BLOCK_ACCOUNT_FAILED = 1047;

    case ERROR_SUBJECT_UNBLOCK_ACCOUNT_FAILED = 1048;

    case ERROR_SYSTEM_BLOCK_ACCOUNT_FAILED = 1049;

    case ERROR_SYSTEM_UNBLOCK_ACCOUNT_FAILED = 1050;

    case ERROR_SUBJECT_BLOCK_ALL_ACCOUNTS_FAILED = 1051;

    case ERROR_SUBJECT_UNBLOCK_ALL_ACCOUNTS_FAILED = 1052;

    case ERROR_SYSTEM_BLOCK_ALL_ACCOUNTS_FAILED = 1053;

    case ERROR_SYSTEM_UNBLOCK_ALL_ACCOUNTS_FAILED = 1054;

    case ERROR_CLOSE_ACCOUNT_FAILED = 1064;

    case ERROR_CLOSE_SUBJECT_FAILED = 1065;

    case ERROR_CLOSE_ALL_ACCOUNTS_FAILED = 1066;

    case ERROR_GROUP_OPERATION_FAILED = 1074;

    case ERROR_CANCEL_EVENT_FAILED = 1077;

    case ERROR_ADD_OPERATION_TO_EVENT_FAILED = 1078;

    case ERROR_COMPLETE_EVENT_FAILED = 1079;

    case ERROR_PAY_EVENT_FAILED = 1080;

    case ERROR_UPDATE_PROFILE_FAILED = 1081;

    case ERROR_CONFIRM_PAYMENT_REQUEST_FAILED = 1082;

    case ERROR_CHANGE_PASSWORD_FAILED = 1090;

    case ERROR_ADD_COUNTRY_FAILED = 1091;

    case ERROR_MODIFY_COUNTRY_FAILED = 1092;

    case ERROR_DELETE_COUNTRY_FAILED = 1093;

    case ERROR_ADD_CURRENCY_FAILED = 1094;

    case ERROR_MODIFY_CURRENCY_FAILED = 1095;

    case ERROR_DELETE_CURRENCY_FAILED = 1096;

    case ERROR_REVERSE_FAILED = 1097;

    case ERROR_ZWALLET_RETURN_FAILED = 1098;

    case ERROR_ADD_CITY_FAILED = 1100;

    case ERROR_MODIFY_CITY_FAILED = 1101;

    case ERROR_DELETE_CITY_FAILED = 1102;

    case ERROR_ADD_SERVICE_FAILED = 1104;

    case ERROR_MODIFY_SERVICE_FAILED = 1105;

    case ERROR_DELETE_SERVICE_FAILED = 1106;

    case ERROR_SET_SUBJECT_ACTIVE_FAILED = 1107;

    case ERROR_EMPTY_DATA = 1108;

    case ERROR_ADDITIONAL_ATTRIBUTE = 1109;

    case ERROR_NO_SERVICE = 1110;

    case ERROR_OPERATION_LIMIT_EXCEEDED = 1111;

    case ERROR_ZERO_AMOUNT = 1112;

    case ERROR_SELF_OPERATION = 1113;

    case ERROR_WRONG_SECRET_ANSWER = 1114;

    case ERROR_SET_OPERATION_SENDER_FAILED = 1115;

    case ERROR_OPERATION_EXPIRED = 1116;

    case ERROR_KVITAN_FAILED = 1117;

    case ERROR_SET_EXTERNAL_ID_FAILED = 1118;

    case ERROR_ADD_SUBJECT_CARD_NUMBER_FAILED = 1119;

    case ERROR_DELETE_SUBJECT_CARD_NUMBER_FAILED = 1120;

    case ERROR_NOT_REGISTERED_CARDHOLDER = 1121;

    case ERROR_WRONG_APPROVAL_CODE = 1122;

    case ERROR_BLOCK_OPERATION_FAILED = 1123;

    case ERROR_UNBLOCK_OPERATION_FAILED = 1124;

    case ERROR_SET_OPERATION_RECEIVER_FAILED = 1125;

    case ERROR_GROUP_PAYMENT_OPERATION_FAILED = 1126;

    case ERROR_PAYMENT_OPERATION_FAILED = 1127;

    case ERROR_OPERATION_RETURN_OF_PART_FAILED = 1128;

    case ERROR_CHANGE_MONEY_OPERATION_STATUS = 1129;

    case ERROR_NOT_ENOUGH_MONEY_ON_OPERATION = 1130;

    case ERROR_GET_REMAIN_SUM_BY_OPERATION = 1131;

    case ERROR_BILLING_PAY_PERFORM_EXCEPTION = 1132;

    case ERROR_SET_PARENT_ID_FAILED = 1133;

    case ERROR_CONFIRM_SUBJECT_CARD_NUMBER_FAILED = 1134;

    case ERROR_OPERATION_HAS_CHILDREN = 1135;

    case ERROR_ACTIVE_SUBJECT_CARD_NUMBER_FAILED = 1136;

    case ERROR_DELETE_SUBJECT_FAILED = 1137;

    case ERROR_INSERT_REDIRECT_ROUTE_FOR_PAYMENT = 1138;

    case ERROR_DELETE_REDIRECT_ROUTE_FOR_PAYMENT = 1139;

    case ERROR_OPERATION_WRONG_TYPE = 1140;

    case ERROR_LINK_CARD_TO_OPERATION_FAILED = 1141;

    case ERROR_CHANGE_OPERATION_OWNER = 1142;

    case ERROR_OPERATION_WRONG_STATUS = 1143;

    case ERROR_GET_CARD_SYNONIM = 1144;

    case ERROR_CHANGE_OPERATION_PAYACC = 1145;

    case ERROR_ADD_OPERATION_DESCRIPTION = 1146;

    case ERROR_INSERT_WITHDRAWAL_FAILED = 1147;

    case ERROR_CHECK_LIMIT_FAILED = 1148;

    case ERROR_CREATE_GATEWAY_LIMIT_FAILED = 1149;

    case ERROR_UPDATE_GATEWAY_LIMIT_FAILED = 1150;

    case ERROR_DELETE_GATEWAY_LIMIT_FAILED = 1151;

    case ERROR_CHANGE_COMMISSION_STATUS_FAILED = 1152;

    case ERROR_REVERSE_BEELINE_FAILED = 1153;

    case ERROR_CHANGE_SUBJECT_STATUS_FAILED = 1154;

    case ERROR_MERCHANT_OPERATION_WAITING_FAILED = 1155;

    case ERROR_OPERATION_FORBIDDEN = 1156;

    case ERROR_SET_OPERATION_DATA_FAILED = 1157;

    case ERROR_GET_OPERATION_DATA_FAILED = 1158;

    case ERROR_CASH_IN_FROM_CARD_FORBIDDEN = 1159;

    case ERROR_CASH_OUT_ON_CARD_FORBIDDEN = 1160;

    case ERROR_ATM_CRITICAL = 1161;

    case ERROR_ADD_EVENT_PARTICIPANT = 1162;

    case ERROR_ADD_EVENT_SERVICE = 1163;

    case ERROR_ADD_EVENT_SUBJECT_TYPE = 1164;

    case ERROR_CLEAR_EVENT_PARTICIPANTS = 1165;

    case ERROR_CLEAR_EVENT_SERVICES = 1166;

    case ERROR_CLEAR_EVENT_SUBJECT_TYPES = 1167;

    case ERROR_CREATE_EVENT = 1168;

    case ERROR_CREATE_EVENT_CASHBACK = 1169;

    case ERROR_DELETE_EVENT = 1170;

    case ERROR_DELETE_EVENT_CASHBACK = 1171;

    case ERROR_CREATE_MERCHANT_POINT = 1172;

    case ERROR_MODIFY_MERCHANT_POINT = 1173;

    case ERROR_LINK_SPECIALIST_TO_POINT = 1174;

    case ERROR_UNLINK_SPECIALIST_FROM_POINT = 1175;

    case ERROR_LINK_OPERATION_TO_MERCHANT_AND_POINT = 1176;

    case ERROR_LINK_BEELINE_NUMBER_ACCOUNT = 1177;

    case ERROR_UNLINK_BEELINE_NUMBER_ACCOUNT = 1178;

    case ERROR_SET_OPERATION_CURRENCY_RATE_DATA = 1179;

    case ERROR_NOMINATE_SUBJECT = 1180;

    case ERROR_BOOKMAKER_REFUND_FAILED = 1181;

    case ERROR_CARD_IN_BLACK_LIST = 1182;

    case ERROR_ATM_PROCESS_FAILED = 1183;

    case ERROR_VIP_SUBJECT_INSUFFICIENT_FUNDS = 1186;

    case ERROR_MVISA_PROCESS_FAILED = 1187;

    case ERROR_CLONE_SERVICE_FAILED = 1188;

    case ERROR_SERVICE_IS_DEAD = 1189;

    case ERROR_CHILD_HAS_CASHBACK = 1190;

    case ERROR_ONAYPAY_REFUND_FAILED = 1191;

    case ERROR_SET_SPECIALIST_FAILED = 1192;

    case ERROR_APPROVE_OPERATION_FAILED = 1193;

    case ERROR_NOMINATED_USER_LIMIT_EXCEEDED = 1194;

    case ERROR_IDENTIFIED_USER_LIMIT_EXCEEDED = 1195;

    case ERROR_UNIDENTIFIED_USER_LIMIT_EXCEEDED = 1196;

    case ERROR_PARTNER_BLOCK_SUBJECT_FAILED = 1197;

    case ERROR_PARTNER_UNBLOCK_SUBJECT_FAILED = 1198;

    case ERROR_TRANSFER_BONUS_BALANCE_FAILED = 1199;

    case ERROR_APPLE_PAY_REQUEST_FAILED = 1200;

    case ERROR_MANIPULATE_ACCOUNT_BALANCE_LIMIT = 1201;

    case ERROR_NOMINATED_RECEIVER_LIMIT_EXCEEDED = 1202;

    case ERROR_IDENTIFIED_RECEIVER_LIMIT_EXCEEDED = 1203;

    case ERROR_UNIDENTIFIED_RECEIVER_LIMIT_EXCEEDED = 1204;

    case ERROR_BONUS_OFFER_NOT_ACCEPTED = 1205;

    case ERROR_REFERRAL_PROGRAM_ERROR = 1206;

    case ERROR_INVALID_REFERRAL_CODE = 1207;

    case ERROR_REFERRAL_CODE_ALREADY_USED = 1208;

    case ERROR_REFERRAL_CODE_COUNT_EXCEEDED = 1209;

    case ERROR_REFERRAL_CODE_NOT_FOUND = 1210;

    case ERROR_MANAGE_SUBJECT_OPERATION_ACCESSIBILITY_FAILED = 1211;

    case ERROR_CHECK_OPERATION_STATUS_FAILED = 1212;

    case ERROR_MODIFY_SERVICE_GROUP_LIMIT_FAILED = 1213;

    case ERROR_GET_UNIQUE_PAYMENT_CODE_FAILED = 1214;

    case ERROR_SUBJECT_AGE_LIMIT_EXCEEDED = 1215;

    case ERROR_ACQUIRING_ALREADY_PAID = 1401;

    case ERROR_ACQUIRING_AMOUNT_MISMATCH = 1402;

    case ERROR_ACQUIRING_BAD_RESULT = 1403;

    case ERROR_ACQUIRING_BAD_STATUS = 1404;

    case ERROR_ACQUIRING_NOT_PAYMENT = 1405;

    case ERROR_ACQUIRING_PAYMENT_ERROR = 1406;

    case ERROR_ACQUIRING_SIGNATURE_CHECK_FAILED = 1407;

    case ERROR_ACQUIRING_XML_PARSE_FAILED = 1408;

    case ERROR_ACQUIRING_INSUFFICIENT_FUNDS = 1409;

    case ERROR_ACQUIRING_FREQUENCY_EXCEEDED = 1410;

    case ERROR_ACQUIRING_AMOUNT_FORBIDDEN = 1411;

    case ERROR_ACQUIRING_TRANSACTION_BLOCKED = 1412;

    case ERROR_OBERTHUR_PURCHASE_FAILED = 1501;

    case ERROR_OBERTHUR_CONFIRM_FAILED = 1502;

    case ERROR_OBERTHUR_APPROVE_FAILED = 1503;

    case ERROR_OBERTHUR_CHARGE_FAILED = 1504;

    case ERROR_OBERTHUR_REFUND_FAILED = 1505;

    case ERROR_OBERTHUR_STATUS_FAILED = 1506;

    case ERROR_OBERTHUR_OTP_REQUIRED = 1507;

    case ERROR_OBERTHUR_PIN_REQUIRED = 1508;

    case ERROR_OBERTHUR_WRONG_OTP = 1509;

    case ERROR_OBERTHUR_ATTEMPTS_EXCEEDED = 1510;

    case ERROR_OBERTHUR_ALREADY_PERFORMED = 1511;

    case ERROR_OBERTHUR_INSUFFICIENT_FUNDS = 1512;

    case ERROR_OBERTHUR_OPERATION_FAILED = 1513;

    case ERROR_OBERTHUR_UNKNOWN_STATUS = 1514;

    case ERROR_OBERTHUR_EMPTY_RESPONSE = 1515;

    case ERROR_OBERTHUR_UNKNOWN_MSISDN = 1516;

    case ERROR_OBERTHUR_WRONG_AMOUNT = 1517;

    case ERROR_OBERTHUR_ACCUMULATOR_INSUFFICIENT_FUNDS = 1518;

    case ERROR_OBERTHUR_DUPLICATE_TRANSACTION = 1519;

    case ERROR_OBERTHUR_BLOCKED_TRANSACTION = 1520;

    case ERROR_OBERTHUR_SMS_REQUIRED = 1521;

    case ERROR_OBERTHUR_TARIFF_PLAN_MISMATCH = 1522;

    case ERROR_OBERTHUR_COUNT_EXCEEDED = 1523;

    case ERROR_OBERTHUR_AMOUNT_EXCEEDED = 1524;

    case ERROR_KCELL_SMS_REQUIRED = 1601;

    case ERROR_KCELL_OTP_REQUIRED = 1602;

    case ERROR_KCELL_ALREADY_PERFORMED = 1603;

    case ERROR_KCELL_WITHDRAWAL_FAILED = 1604;

    case ERROR_KCELL_REFUND_FAILED = 1605;

    case ERROR_KCELL_INSUFFICIENT_FUNDS = 1606;

    case ERROR_KCELL_UNKNOWN_MSISDN = 1607;

    case ERROR_KCELL_ACCUMULATOR_INSUFFICIENT_FUNDS = 1608;

    case ERROR_KCELL_TARIFF_PLAN_MISMATCH = 1609;

    case ERROR_KCELL_WRONG_AMOUNT = 1610;

    case ERROR_KCELL_NOT_PERSON = 1611;

    case ERROR_KCELL_IN_ROAMING = 1612;

    case ERROR_KCELL_INVALID_STATE = 1613;

    case ERROR_KCELL_TRANSACTION_NOT_ALLOWED = 1614;

    case ERROR_KCELL_CASHBACK_FAILED_FATAL = 1615;

    case ERROR_KCELL_CASHBACK_FAILED_RETRY = 1616;

    case ERROR_KCELL_HAS_EXTRA_BALANCE = 1617;

    case ERROR_KCELL_TIMED_OUT = 1618;

    case ERROR_KCELL_DUPLICATE_TRANSACTION = 1619;

    case ERROR_KCELL_EMPTY_RESPONSE = 1620;

    case ERROR_KCELL_REQUEST_FAILED = 1621;

    case ERROR_KCELL_REFERRAL_CODE_NOT_ALLOWED = 1622;

    case ERROR_QIWI_ALREADY_PAID = 1701;

    case ERROR_QIWI_WRONG_AMOUNT = 1702;

    case ERROR_QIWI_LIMIT_EXCEEDED = 1703;

    case ERROR_QIWI_INVOICE_FAILED = 1704;

    case ERROR_QIWI_STATUS_FAILED = 1705;

    case ERROR_ASAP_EMPTY_RESPONSE = 1801;

    case ERROR_ASAP_REQUEST_FAILED = 1802;

    case ERROR_ASAP_NOT_EXPORTED = 1803;

    case ERROR_ASAP_DIFFERENT_POOL = 1804;

    case ERROR_ASAP_DIFFERENT_SUBJECT = 1805;

    case ERROR_CREATE_RBAC_OBJECT_FAILED = 1901;

    case ERROR_REMOVE_RBAC_OBJECT_FAILED = 1902;

    case ERROR_ADD_TO_RBAC_TREE_FAILED = 1903;

    case ERROR_REMOVE_FROM_RBAC_TREE_FAILED = 1904;

    case ERROR_MODIFY_RBAC_OBJECT_FAILED = 1905;

    case ERROR_UNKNOWN_DEVICE = 2001;

    case ERROR_UNKNOWN_PACKAGE_TYPE = 2002;

    case ERROR_PACKAGE_PARSING_FAILED = 2003;

    case ERROR_UNKNOWN_COMMAND = 2005;

    case ERROR_INCORRECT_DEVICE_KEY = 2006;

    case ERROR_INCORRECT_REQUEST_TIME = 2007;

    case ERROR_UNKNOWN_MONEY_OPERATION = 2008;

    case ERROR_UNKNOWN_REPORT_TYPE = 2009;

    case ERROR_INVALID_PACKAGE_STRUCTURE = 2010;

    case ERROR_EMPTY_FIELD = 2011;

    case ERROR_BAD_TERMINAL = 2013;

    case ERROR_INCORRECT_PARTS_COUNT = 2018;

    case ERROR_UNKNOWN_PAYMENT_TRANSFER_TYPE_EXCEPTION = 2019;

    case ERROR_NEGATIVE_NUMBER = 2020;

    case ERROR_MODEL_VALIDATION = 2021;

    case ERROR_TELE2_EMPTY_RESPONSE = 2100;

    case ERROR_TELE2_PAYMENT_FAILED = 2101;

    case ERROR_TELE2_REVOKE_FAILED = 2102;

    case ERROR_TELE2_STATUS_FAILED = 2103;

    case ERROR_TELE2_ALREADY_PERFORMED = 2104;

    case ERROR_TELE2_OTP_REQUIRED = 2105;

    case ERROR_TELE2_SMS_REQUIRED = 2106;

    case ERROR_TELE2_INSUFFICIENT_FUNDS = 2107;

    case ERROR_TELE2_TARIFF_PLAN_MISMATCH = 2108;

    case ERROR_TELE2_ACCUMULATOR_INSUFFICIENT_FUNDS = 2109;

    case ERROR_TELE2_HAS_OUTSTANDING_DEPT = 2110;

    case ERROR_TELE2_NOT_B2C_SUBSCRIBER = 2111;

    case ERROR_TELE2_DUPLICATE_TRANSACTION = 2112;

    case ERROR_TELE2_CASHBACK_FAILED_FATAL = 2113;

    case ERROR_TELE2_CASHBACK_FAILED_RETRY = 2114;

    case ERROR_OVERLOOKER_REQUEST_FAILED = 2201;

    case ERROR_OVERLOOKER_EMPTY_RESPONSE = 2202;

    case ERROR_UZTELECOM_PAYMENT_FAILED = 2301;

    case ERROR_UZTELECOM_REVOKE_FAILED = 2302;

    case ERROR_UZTELECOM_STATUS_FAILED = 2303;

    case ERROR_UZTELECOM_ALREADY_PERFORMED = 2304;

    case ERROR_UZTELECOM_OTP_REQUIRED = 2305;

    case ERROR_UZTELECOM_SMS_REQUIRED = 2306;

    case ERROR_UZTELECOM_INSUFFICIENT_FUNDS = 2307;

    case ERROR_BABILON_PAYMENT_FAILED = 2401;

    case ERROR_BABILON_REVOKE_FAILED = 2402;

    case ERROR_BABILON_STATUS_FAILED = 2403;

    case ERROR_BABILON_ALREADY_PERFORMED = 2404;

    case ERROR_BABILON_OTP_REQUIRED = 2405;

    case ERROR_BABILON_SMS_REQUIRED = 2406;

    case ERROR_BABILON_INSUFFICIENT_FUNDS = 2407;

    case ERROR_BABILON_UNKNOWN_MSISDN = 2408;

    case ERROR_BABILON_AMOUNT_EXCEEDED = 2409;

    case ERROR_BABILON_PAYMENTS_DISABLED = 2410;

    case ERROR_BEELINE_UZ_PAYMENT_FAILED = 2501;

    case ERROR_BEELINE_UZ_REVOKE_FAILED = 2502;

    case ERROR_BEELINE_UZ_ALREADY_PERFORMED = 2503;

    case ERROR_BEELINE_UZ_OTP_REQUIRED = 2504;

    case ERROR_BEELINE_UZ_SMS_REQUIRED = 2505;

    case ERROR_BEELINE_UZ_INSUFFICIENT_FUNDS = 2506;

    case ERROR_BEELINE_UZ_UNKNOWN_MSISDN = 2507;

    case ERROR_BEELINE_UZ_INVALID_STATE = 2508;

    case ERROR_BEELINE_UZ_HAS_EXTRA_BALANCE = 2509;

    case ERROR_BEELINE_UZ_TARIFF_PLAN_MISMATCH = 2510;

    case ERROR_TCELL_PAYMENT_FAILED = 2601;

    case ERROR_TCELL_REVOKE_FAILED = 2602;

    case ERROR_TCELL_STATUS_FAILED = 2603;

    case ERROR_TCELL_ALREADY_PERFORMED = 2604;

    case ERROR_TCELL_OTP_REQUIRED = 2605;

    case ERROR_TCELL_SMS_REQUIRED = 2606;

    case ERROR_TCELL_INSUFFICIENT_FUNDS = 2607;

    case ERROR_TCELL_UNKNOWN_MSISDN = 2608;

    case ERROR_ISOBELLA_EMPTY_RESPONSE = 2701;

    case ERROR_ISOBELLA_REQUEST_FAILED = 2702;

    case ERROR_ISOBELLA_VALIDATION_FAILED = 2703;

    case ERROR_ISOBELLA_INVALID_UID = 2704;

    case ERROR_ISOBELLA_CARD_ALREADY_CREATED = 2705;

    case ERROR_ISOBELLA_WRONG_STATUS = 2706;

    case ERROR_ISOBELLA_CARD_HARD_LOCKED = 2707;

    case ERROR_ISOBELLA_NO_ACTIVE_CARDS = 2708;

    case ERROR_ZETMOBILE_PAYMENT_FAILED = 2801;

    case ERROR_ZETMOBILE_REVOKE_FAILED = 2802;

    case ERROR_ZETMOBILE_ALREADY_PERFORMED = 2803;

    case ERROR_ZETMOBILE_OTP_REQUIRED = 2804;

    case ERROR_ZETMOBILE_SMS_REQUIRED = 2805;

    case ERROR_ZETMOBILE_INSUFFICIENT_FUNDS = 2806;

    case ERROR_ZETMOBILE_UNKNOWN_MSISDN = 2807;

    case ERROR_MEGAFON_PAYMENT_FAILED = 2901;

    case ERROR_MEGAFON_REVOKE_FAILED = 2902;

    case ERROR_MEGAFON_ALREADY_PERFORMED = 2903;

    case ERROR_MEGAFON_OTP_REQUIRED = 2904;

    case ERROR_MEGAFON_SMS_REQUIRED = 2905;

    case ERROR_MEGAFON_INSUFFICIENT_FUNDS = 2906;

    case ERROR_MEGAFON_UNKNOWN_MSISDN = 2907;

    case ERROR_USER_ALREADY_REGISTERED = 3001;

    case ERROR_USER_NOT_REGISTERED = 3002;

    case ERROR_BAD_CREDENTIALS = 3003;

    case ERROR_SMS_SEND_FAILED = 3004;

    case ERROR_TOO_OFTEN_PASSWORD_RESET = 3005;

    case ERROR_NOT_AUTHENTICATED = 3006;

    case ERROR_AUTH_KEY_EXPIRED = 3007;

    case ERROR_TEMPORARY_BLOCKED = 3008;

    case ERROR_SELF_REQUEST = 3010;

    case ERROR_INSUFFICIENT_PRIVILEGES = 3013;

    case ERROR_BILLING_NOT_LOADED = 3014;

    case ERROR_METHOD_NOT_FOUND = 3015;

    case ERROR_CERTIFICATE_CHECK = 3017;

    case ERROR_FILE_OPERATION_FAILED = 3018;

    case ERROR_NO_ACCOUNT = 3019;

    case ERROR_TOO_WEAK_PASSWORD = 3020;

    case ERROR_NO_COMMISSION = 3021;

    case ERROR_NOT_BLOCKED_IP = 3022;

    case ERROR_LINKME_TO_BANK_FAILED = 3023;

    case ERROR_WRONG_INVOICE_LIFETIME = 3024;

    case ERROR_ALREADY_PERFORMED = 3027;

    case ERROR_NOT_EQUAL_PASSWORDS = 3028;

    case ERROR_NO_RET_SUM = 3029;

    case ERROR_PASSWORD_RESET_HASH_EXPIRED = 3031;

    case ERROR_NO_RESULT_EXCEPTION = 3036;

    case ERROR_WRONG_CONFIRMATION_CODE = 3037;

    case ERROR_TOO_OFTEN_CONFIRMATION_CODE = 3038;

    case ERROR_TOO_OFTEN_OPERATION_CALL_CODE = 3039;

    case ERROR_CALL_COUNTER_EXCEEDED = 3040;

    case ERROR_SUBJECT_IIN_NOT_SET = 3041;

    case ERROR_SUBJECT_IIN_ALREADY_SET = 3042;

    case ERROR_SUBJECT_NOT_APPROVED_MT100 = 3043;

    case ERROR_WRONG_PARAMETERS = 3044;

    case ERROR_LINK_CARD_FAILED = 3045;

    case ERROR_REMOVE_CARD_FAILED = 3046;

    case ERROR_CANCEL_CARD_AUTHORIZATION_FAILED = 3047;

    case ERROR_GET_CARD_LIST_FAILED = 3048;

    case ERROR_IIN_VERIFICATION_FAILED = 3049;

    case ERROR_EXTERNAL_OPERATION_NOT_PAID = 3050;

    case ERROR_ACCOUNT_BLOCKED = 3051;

    case ERROR_SUBJECT_WRONG_IP = 3052;

    case ERROR_OPERATION_ALREADY_CREATED = 3053;

    case ERROR_SUBJECT_KEY_NOT_FOUND = 3054;

    case ERROR_CARD_ALREADY_IN_BLACK_LIST = 3055;

    case ERROR_ACQUIRING_OPERATION_WASTED = 3056;

    case ERROR_OPERATION_IN_PROCESS = 3057;

    case ERROR_CREATE_WITHDRAWAL_FAILED = 3058;

    case ERROR_WITHDRAWAL_UUID_MISMATCH = 3059;

    case ERROR_WITHDRAWAL_LOCKED = 3060;

    case ERROR_WITHDRAWAL_DECLINED = 3061;

    case ERROR_WITHDRAWAL_NOT_FOUND = 3062;

    case ERROR_WITHDRAWAL_INVALID_STATUS = 3063;

    case ERROR_WITHDRAWAL_INPUT_PENDING = 3064;

    case ERROR_WITHDRAWAL_COMPLETE_FAILED = 3065;

    case ERROR_WITHDRAWAL_REVERSE_FAILED = 3066;

    case ERROR_WITHDRAWAL_GET_STATUS_FAILED = 3067;

    case ERROR_SERVICE_NOT_AVAILABLE_FOR_SUBJECT = 3068;

    case ERROR_OPERATION_NOT_FOUND = 3069;

    case ERROR_SOCIAL_AUTH_LOGIN_REQUIRED = 3070;

    case ERROR_SOCIAL_AUTH_LINK_NOT_FOUND = 3071;

    case ERROR_SOCIAL_AUTH_LINK_FAILED = 3072;

    case ERROR_SOCIAL_AUTH_DELETE_LINK_FAILED = 3073;

    case ERROR_NO_PARENT = 3074;

    case ERROR_SUBJECT_OTP_REQUIRED = 3075;

    case ERROR_SUBJECT_WRONG_OTP = 3076;

    case ERROR_WRONG_OPERATOR = 3077;

    case ERROR_KAZPOST_CODE_REQUIRED = 3079;

    case ERROR_WITHDRAWAL_INPUT_DATA_FAILED = 3080;

    case ERROR_CURRENCY_EXCHANGE_SERVICE_NOT_FOUND = 3081;

    case ERROR_CURRENCY_EXCHANGE_FAILED = 3082;

    case ERROR_CREATE_CARD_FAILED = 3083;

    case ERROR_UPDATE_CARD_FAILED = 3084;

    case ERROR_GET_CARD_DATA_FAILED = 3085;

    case ERROR_BILLING_UNKNOWN_ERROR = 4001;

    case ERROR_BILLING_NO_ACCOUNT = 4002;

    case ERROR_BILLING_INCORRECT_PARAMETER = 4003;

    case ERROR_BILLING_NO_FIELDS = 4004;

    case ERROR_BILLING_ACCOUNT_CHECK = 4005;

    case ERROR_BILLING_ACCOUNT_INACTIVE = 4006;

    case ERROR_BILLING_PAYMENT_PROHIBITED = 4007;

    case ERROR_BILLING_PAYMENT_UNFINISHED = 4008;

    case ERROR_BILLING_TECHNICAL_PROBLEMS = 4009;

    case ERROR_BILLING_TEMPORARY_UNAVAILABLE = 4010;

    case ERROR_BILLING_TOO_FEW = 4011;

    case ERROR_BILLING_TOO_MUCH = 4012;

    case ERROR_BILLING_WRONG_ACCOUNT_FORMAT = 4013;

    case ERROR_BILLING_NOT_TIED = 4014;

    case ERROR_BILLING_PROVIDER_ERROR = 4015;

    case ERROR_BILLING_AIRASTANA_PNR_NOT_FOUND = 4016;

    case ERROR_BILLING_AIRASTANA_PNR_NOT_VALID_FOR_APS = 4017;

    case ERROR_BILLING_AIRASTANA_ALREADY_TICKETED = 4018;

    case ERROR_BILLING_STATUS_NEED_TO_BE_WATCHED = 4019;

    case ERROR_BILLING_STATUS_CRITICAL = 4020;

    case ERROR_BILLING_NO_TXN_ID = 4021;

    case ERROR_BILLING_EMPTY_FIELD = 4022;

    case ERROR_BILLING_WRONG_FIELD_FORMAT = 4023;

    case ERROR_BILLING_UNKNOWN_VALIDATION_PARAMETER = 4024;

    case ERROR_BILLING_UNKNOWN_VALIDATOR = 4025;

    case ERROR_BILLING_UNKNOWN_STATUS = 4026;

    case ERROR_BILLING_EXTERNAL_PROCESSING_REQUIRED = 4027;

    case ERROR_BILLING_ACCOUNT_NOT_ASSOCIATED_WITH_PHONE = 4028;

    case ERROR_BILLING_ACCOUNT_NEED_IDENTIFICATION = 4029;

    case ERROR_BILLING_PRODUCT_OUT_OF_STOCK = 4030;

    public static function getErrorNameByValue(int $command): string
    {
        $result = self::tryFrom($command);
        return $result !== null ? $result->name : 'Unknown error';
    }
}