<?php

return array(
	'rAcceptAllOrders' =>
		array(
			'description' => 'Мерчант, который может принимать все заказы разом',
			'id' => 382,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptAllOrders',
				),
		),
	'rAcceptBonusOfferAgreementOnOtpWriteoff' =>
		array(
			'description' => 'Принятие бонусной оферты при подтверждении запроса на согласие с оплатой без ОТП',
			'id' => 1840,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptBonusOfferAgreementOnOtpWriteoff',
				),
		),
	'rAccountManager' =>
		array(
			'description' => 'Аккаунт менеджер',
			'id' => 1148,
			'type' => 2,
			'children' =>
				array(
					0 => 'oChangeStatus',
					1 => 'oChangeSubjectStatusToModerating',
					2 => 'oEditMerchant',
					3 => 'oGetSubjectType',
					4 => 'oJuridicalSubjectPasswordChange',
					5 => 'oJuridicalSubjectProfileEdit',
					6 => 'oModifyConversionService',
					7 => 'oReportAccountManagerMerchants',
					8 => 'oReportAccountManagerPeriod',
					9 => 'oReportConversionService',
					10 => 'oReportJuridicalSubjects',
					11 => 'oSetDischargeEnabled',
					12 => 'oSetDischargeEnabledAny',
					13 => 'oSetIdentificationStatusToSubject',
					14 => 'oSetMT100Approved',
					15 => 'oUpdatePremerchant',
				),
		),
	'rAccountMaster' =>
		array(
			'description' => 'Специалист который может создавать/подтверждать субъектов, подтверждать комиссии, управлять гашением ',
			'id' => 1878,
			'type' => 2,
			'children' =>
				array(
					0 => 'oChangeStatus',
					1 => 'oChangeSubjectStatusToModerating',
					2 => 'oCreateAgent',
					3 => 'oCreateEmitent',
					4 => 'oCreateEmitentAdmin',
					5 => 'oCreateSubAgent',
					6 => 'oCreateSubSubAgent',
					7 => 'oEditMerchant',
					8 => 'oGetSubjectType',
					9 => 'oJuridicalSubjectPasswordChange',
					10 => 'oJuridicalSubjectProfileEdit',
					11 => 'oReportAccountManagerMerchants',
					12 => 'oReportAccountManagerPeriod',
					13 => 'oReportJuridicalSubjects',
					14 => 'oSetDischargeEnabled',
					15 => 'oSetDischargeEnabledAny',
					16 => 'oSetMT100Approved',
					17 => 'oUpdatePremerchant',
				),
		),
	'rAccumsTotal' =>
		array(
			'description' => 'Роль для суммирования аккумуляторов(HD-58167)',
			'id' => 2018,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccumsTotal',
				),
		),
	'rAddresslessTransferUser' =>
		array(
			'description' => 'Пользователь, на которого проводится безадресный перевод',
			'id' => 938,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddresslessTransferUserOperations',
					1 => 'oCancelOperation',
					2 => 'oChangeOperationsPaymentAccount',
					3 => 'oConfirmOperation',
					4 => 'oPayFromWallet',
					5 => 'oPaymentSend',
					6 => 'oRegisterAddresslessTransferUser',
					7 => 'oReportTransfers',
					8 => 'oTransferReceive',
					9 => 'oTransferSend',
					10 => 'oTransferSubagent',
					11 => 'oViewServices',
				),
		),
	'rAdministrator' =>
		array(
			'description' => 'Администратор системы',
			'id' => 11,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oAddCurrency',
					2 => 'oAddService',
					3 => 'oAnySubjectPasswordReset',
					4 => 'oAssignRole',
					5 => 'oBeelineUSSD',
					6 => 'oBillingCancelOperation',
					7 => 'oBillingRepayOperation',
					8 => 'oBlockIP',
					9 => 'oBlockOperation',
					10 => 'oBlockPayment',
					11 => 'oBookmakerRefund',
					12 => 'oBookmakerRefundAny',
					13 => 'oChangeType',
					14 => 'oCheckInvoices',
					15 => 'oCheckOperationStatus',
					16 => 'oClearFavorites',
					17 => 'oClearSubjectCache',
					18 => 'oCloneService',
					19 => 'oCloseSubject',
					20 => 'oCreateAccountBalanceLimit',
					21 => 'oCreateAgent',
					22 => 'oCreateCommission',
					23 => 'oCreateEmitent',
					24 => 'oCreateEmitentAdmin',
					25 => 'oCreateGatewayLimit',
					26 => 'oCreateLimit',
					27 => 'oCreateMerchant',
					28 => 'oCreateModerator',
					29 => 'oCreateNalogoviyInspector',
					30 => 'oCreateSubAgent',
					31 => 'oCreateSubSubAgent',
					32 => 'oCreateSupportGrandMaster',
					33 => 'oCreateSupportMaster',
					34 => 'oCreateSupportUser',
					35 => 'oDeleteAccountBalanceLimit',
					36 => 'oDeleteCurrency',
					37 => 'oDeleteGatewayLimit',
					38 => 'oDeleteLimit',
					39 => 'oDeleteService',
					40 => 'oDeleteSubject',
					41 => 'oEditLandingForPromo',
					42 => 'oEditMerchant',
					43 => 'oEditServicesListForPromo',
					44 => 'oEditSynonym',
					45 => 'oEditTags',
					46 => 'oGetAtmStatus',
					47 => 'oGetCardOperationInfo',
					48 => 'oGetCurrencies',
					49 => 'oGetIpWhitelist',
					50 => 'oGetServices',
					51 => 'oGetStorningOperations',
					52 => 'oGetSubjectParent',
					53 => 'oGetSubjectType',
					54 => 'oGetSupportFilterData',
					55 => 'oJuridicalSubjectPasswordChange',
					56 => 'oJuridicalSubjectProfileEdit',
					57 => 'oLandingPagesAdd',
					58 => 'oLandingPagesDelete',
					59 => 'oLandingPagesEdit',
					60 => 'oLandingPagesInsertJS',
					61 => 'oLandingPagesList',
					62 => 'oListCommission',
					63 => 'oManageRedirections',
					64 => 'oManageSubjectOperationAccessibility',
					65 => 'oMarkServiceAsDead',
					66 => 'oMetaTagsEdit',
					67 => 'oMobileRefund',
					68 => 'oMobileRefundAny',
					69 => 'oModifyCommission',
					70 => 'oModifyConversionService',
					71 => 'oModifyCurrency',
					72 => 'oModifyService',
					73 => 'oModifyServiceGroupLimit',
					74 => 'oNotifyInvoiceMerchant',
					75 => 'oNotifyWithdrawalAgent',
					76 => 'oPasswordChangeReportForAnyUser',
					77 => 'oPasswordReset',
					78 => 'oRbacEdit',
					79 => 'oReportBirthday',
					80 => 'oReportBlockedUsers',
					81 => 'oReportBlocking',
					82 => 'oReportCommissions',
					83 => 'oReportConfirmedCommissions',
					84 => 'oReportConversionService',
					85 => 'oReportExtendedOperations',
					86 => 'oReportIdentifications',
					87 => 'oReportJuridicalSubjects',
					88 => 'oReportMerchants',
					89 => 'oReportMoneyIssue',
					90 => 'oReportMoneyRedemption',
					91 => 'oReportMT100',
					92 => 'oReportOperDay',
					93 => 'oReportPasswordReset',
					94 => 'oReportRegistrations',
					95 => 'oReportTransfers',
					96 => 'oReportVipSubjects',
					97 => 'oReverseTransfer',
					98 => 'oServiceEdit',
					99 => 'oSetIpWhitelist',
					100 => 'oSetIpWhitelistAny',
					101 => 'oSetIpWhitelistSelf',
					102 => 'oSetMRPAmount',
					103 => 'oSetOperatorToNumber',
					104 => 'oSetOtpSecret',
					105 => 'oSetOtpSecretAny',
					106 => 'oSetOtpSecretSelf',
					107 => 'oSetSubjectParent',
					108 => 'oSystemBlockUser',
					109 => 'oSystemUnblockUser',
					110 => 'oTextPagesAdd',
					111 => 'oTextPagesDelete',
					112 => 'oTextPagesEdit',
					113 => 'oTextPagesInsertJS',
					114 => 'oTextPagesView',
					115 => 'oUnblockIP',
					116 => 'oUpdateAccountBalanceLimit',
					117 => 'oUpdateGatewayLimit',
					118 => 'oViewBankServicesConfig',
					119 => 'oViewErrorDetails',
					120 => 'oViewModeratingServices',
					121 => 'oViewUserCount',
					122 => 'oVipSubjectListModify',
					123 => 'oWithdrawalToBankAccountDataWork',
					124 => 'oWorkWithRedemptionDetails',
					125 => 'oZWalletReturn',
					126 => 'tViewLogs',
				),
		),
	'rAdvancedOperatorSPP' =>
		array(
			'description' => 'Оператор СПП с квалификацией. Расширяет rUpperOperatorSPP',
			'id' => 1930,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBillingRepayOperation',
					1 => 'oBookmakerRefund',
					2 => 'oBookmakerRefundAny',
					3 => 'oCompletePaymentOfBlockedUser',
					4 => 'oConfirmOperationForUser',
					5 => 'oMobileRefund',
					6 => 'oMobileRefundAny',
					7 => 'oRestoreDeletedOperation',
					8 => 'oReverseOperationOfUser',
					9 => 'oReverseTransfer',
				),
		),
	'rAgent' =>
		array(
			'description' => 'Агент',
			'id' => 6,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelOperation',
					2 => 'oCompleteWithdrawal',
					3 => 'oConfirmOperation',
					4 => 'oCreatePaymentsReport',
					5 => 'oCreateSubAgent',
					6 => 'oEditProfile',
					7 => 'oEditSecuritySettings',
					8 => 'oGetIdentifiedStatus',
					9 => 'oGetOwnStorningOperations',
					10 => 'oGetRemainsToDate',
					11 => 'oGetReturnsCount',
					12 => 'oGetServiceOperationsCount',
					13 => 'oPaymentReceive',
					14 => 'oPaymentSend',
					15 => 'oRegisterAddresslessTransferUser',
					16 => 'oReportAgentReverts',
					17 => 'oReportConfirmedCommissions',
					18 => 'oReportDetailedOperations',
					19 => 'oReportTransfers',
					20 => 'oSimpleTransferSend',
					21 => 'oTransferReceive',
					22 => 'oTransferSend',
					23 => 'oTransferSubagent',
					24 => 'oUnlimitedTransfer',
					25 => 'oViewAgentCommissions',
					26 => 'oViewRelatedOperations',
					27 => 'oViewServicesForAgent',
				),
		),
	'rAgentSmpp' =>
		array(
			'description' => 'Агент с возможностью проведения операции без авторизации',
			'id' => 1037,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptOtpWriteoff',
					1 => 'oActivateDirectPayer',
					2 => 'oBabilonOperation',
					3 => 'oBabilonSMSNotification',
					4 => 'oBeelineSMSNotification',
					5 => 'oBeelineUzOperation',
					6 => 'oBeelineUzSMSNotification',
					7 => 'oCancelOtpWriteoff',
					8 => 'oChangeOperationOwner',
					9 => 'oConfirmChildOperation',
					10 => 'oConfirmInvoiceBySMS',
					11 => 'oDeleteDirectPayer',
					12 => 'oDeleteOwnDirectPayer',
					13 => 'oGetDirectPayerStatus',
					14 => 'oGetOperationDataByExtId',
					15 => 'oGetReceiptByTransactionId',
					16 => 'oKCellOperation',
					17 => 'oKcellSMSNotification',
					18 => 'oMegafonOperation',
					19 => 'oMegafonSMSNotification',
					20 => 'oMobileRefund',
					21 => 'oOberthurNotification',
					22 => 'oOberthurOperation',
					23 => 'oOberthurStatus',
					24 => 'oReportTransfers',
					25 => 'oSendSMSPaymentWithoutCode',
					26 => 'oSetOperationAdditionalData',
					27 => 'oSetOperationWaiting',
					28 => 'oSetParentId',
					29 => 'oSmppOperation',
					30 => 'oSmppPayment',
					31 => 'oTcellOperation',
					32 => 'oTcellSMSNotification',
					33 => 'oTele2Operation',
					34 => 'oTele2SMSNotification',
					35 => 'oUztelecomOperation',
					36 => 'oUztelecomSMSNotification',
					37 => 'oViewRelatedOperations',
					38 => 'oZetmobileOperation',
					39 => 'oZetmobileSMSNotification',
				),
		),
	'rAuthorized' =>
		array(
			'description' => 'Авторизованный пользователь',
			'id' => 182,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAuthorizedActions',
				),
		),
	'rAutoAcceptOffer' =>
		array(
			'description' => 'Автопринятие оферты при оплате',
			'id' => 1926,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAutoAcceptOffer',
				),
		),
	'rBabilonNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Babilon',
			'id' => 1757,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBabilonSMSNotification',
				),
		),
	'rBaPAdmin' =>
		array(
			'description' => 'Администратор портала Babilon',
			'id' => 1810,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBabilonAdminCabinet',
					1 => 'oBabilonBlockUser',
					2 => 'oBabilonPasswordReset',
					3 => 'oBabilonUnblockUser',
					4 => 'oCreateBaPSupportUser',
					5 => 'oCreateGatewayLimit',
					6 => 'oCreateGatewayServiceSynonym',
					7 => 'oDelayedHistory',
					8 => 'oDeleteGatewayLimit',
					9 => 'oGetParentInfo',
					10 => 'oGetRemainsToDate',
					11 => 'oGetServiceOperationsCount',
					12 => 'oReportCommissions',
					13 => 'oReportConfirmedCommissions',
					14 => 'oReportTransfers',
					15 => 'oSendRequestToChangeGatewayCommission',
					16 => 'oUpdateGatewayLimit',
					17 => 'oUpdateGatewayServices',
					18 => 'oViewGatewayAdminMainPage',
					19 => 'oViewGatewayReport',
					20 => 'oViewGatewayServices',
					21 => 'oViewParentsChildrensOperations',
					22 => 'oViewParentsOperations',
					23 => 'oViewRelatedOperations',
				),
		),
	'rBaPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала Babilon',
			'id' => 1809,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBabilonAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
	'rBeelineNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Билайн',
			'id' => 1577,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBeelineSMSNotification',
				),
		),
	'rBeelineUzNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Beeline Uz',
			'id' => 1773,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBeelineUzSMSNotification',
				),
		),
	'rBillingCheckMobile' =>
		array(
			'description' => 'Проверка мобильного оператора из биллинга',
			'id' => 1393,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetMobileOperator',
				),
		),
	'rBKManager' =>
		array(
			'description' => 'Роль менеджера БК',
			'id' => 2000,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBKBalanceNotificationAdministration',
				),
		),
	'rBookmaker' =>
		array(
			'description' => 'Букмекер',
			'id' => 1856,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerCabinet',
					1 => 'oCancelIncomingOperation',
					2 => 'oCancelOperation',
					3 => 'oCreateInvoice',
					4 => 'oCreatePartnerUser',
					5 => 'oCreatePaymentsReport',
					6 => 'oCreateSubMerchant',
					7 => 'oCustomizeInvoice',
					8 => 'oDeleteChildSubject',
					9 => 'oEditMerchantProfile',
					10 => 'oEditProfile',
					11 => 'oEmployeesManagement',
					12 => 'oGetMobileOperator',
					13 => 'oGetRemainsToDate',
					14 => 'oGetReturnsCount',
					15 => 'oGetServiceOperationsCount',
					16 => 'oGetSubjectParent',
					17 => 'oGroupOperation',
					18 => 'oMerchantReturn',
					19 => 'oNotifyOwnInvoiceMerchant',
					20 => 'oPaymentReceive',
					21 => 'oReportDetailedOperations',
					22 => 'oReportTransfers',
					23 => 'oReturnPartOfOperation',
					24 => 'oReverseOwnTransfer',
					25 => 'oTransferReceive',
					26 => 'oViewCommissionAccount',
					27 => 'oViewMerchantProfile',
					28 => 'oViewProfile',
				),
		),
	'rBookmakerAccountant' =>
		array(
			'description' => 'Бухгалтер букмекера',
			'id' => 1858,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerCabinet',
					1 => 'oGetParentInfo',
					2 => 'oGetSubjectParent',
					3 => 'oReportDetailedOperations',
					4 => 'oReportTransfers',
					5 => 'oViewParentsOperations',
				),
		),
	'rBookmakerAdmin' =>
		array(
			'description' => 'Администратор букмекеров',
			'id' => 1859,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerCabinet',
					1 => 'oCreatePaymentsReport',
					2 => 'oGetParentInfo',
					3 => 'oGetSubjectParent',
					4 => 'oMobileRefund',
					5 => 'oReportDetailedOperations',
					6 => 'oReportTransfers',
					7 => 'oReturnPartOfOperation',
					8 => 'oReverseTransfer',
					9 => 'oViewParentsChildrensOperations',
					10 => 'oViewParentsOperations',
					11 => 'oWorkWithParentOperations',
				),
		),
	'rBookmakerSppMerchant' =>
		array(
			'description' => 'сотрудник СПП Олимп/1xBet для просмотра операций пополнения',
			'id' => 1596,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerSppCabinet',
					1 => 'oCheckInvoices',
					2 => 'oGetCardOperationInfo',
					3 => 'oGetOperationDataByExtId',
					4 => 'oGetOwnStorningOperations',
					5 => 'oViewParentsOperations',
				),
		),
	'rBookmakerSppSub' =>
		array(
			'description' => 'сотрудник СПП Олимп/1xBet для просмотра операций вывода',
			'id' => 1595,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerSppCabinet',
					1 => 'oCheckInvoices',
					2 => 'oGetCardOperationInfo',
					3 => 'oGetOperationDataByExtId',
					4 => 'oGetOwnStorningOperations',
					5 => 'oViewParentsOperations',
				),
		),
	'rBookmakerSupport' =>
		array(
			'description' => 'Сотрудник поддержки букмекеров',
			'id' => 1857,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBookmakerCabinet',
					1 => 'oGetParentInfo',
					2 => 'oMerchantRequestSupport',
					3 => 'oMerchantViewPayment',
					4 => 'oNotifyOwnInvoiceMerchant',
					5 => 'oViewParentsOperations',
					6 => 'oWorkWithParentOperations',
				),
		),
	'rBPAdmin' =>
		array(
			'description' => 'Администратор портала «Билайн»',
			'id' => 1047,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBeelineAdminCabinet',
					1 => 'oBeelineBlockUser',
					2 => 'oBeelinePasswordReset',
					3 => 'oBeelineUnblockUser',
					4 => 'oCreateBPSupportUser',
					5 => 'oCreateGatewayLimit',
					6 => 'oCreateGatewayServiceSynonym',
					7 => 'oDelayedHistory',
					8 => 'oDeleteGatewayLimit',
					9 => 'oGetParentInfo',
					10 => 'oGetRemainsToDate',
					11 => 'oGetServiceOperationsCount',
					12 => 'oGetSubjectSiblings',
					13 => 'oReportCommissions',
					14 => 'oReportConfirmedCommissions',
					15 => 'oReportTransfers',
					16 => 'oSendRequestToChangeGatewayCommission',
					17 => 'oUpdateGatewayLimit',
					18 => 'oUpdateGatewayServices',
					19 => 'oViewGatewayAdminMainPage',
					20 => 'oViewGatewayReport',
					21 => 'oViewGatewayServices',
					22 => 'oViewParentsChildrensOperations',
					23 => 'oViewParentsOperations',
					24 => 'oViewRelatedOperations',
				),
		),
	'rBPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала «Билайн»',
			'id' => 1049,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessBeelineAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
	'rCancelWaitingOperation' =>
		array(
			'description' => 'Роль для отмены операции со статусом waiting',
			'id' => 1744,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCancelWaitingOperation',
				),
		),
	'rCheckParentTxnId' =>
		array(
			'description' => 'Роль с правом проверки txn_id в родительском пополнении',
			'id' => 1957,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCheckParentTxnId',
				),
		),
	'rCheckTxnIdWithSpecialist' =>
		array(
			'description' => 'Роль с правом проверки txn_id по специалисту',
			'id' => 1849,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCheckTxnIdWithSpecialist',
				),
		),
	'rChildOperationConfirmer' =>
		array(
			'description' => 'Роль, позволяющая подтверждать операции потомков',
			'id' => 1682,
			'type' => 2,
			'children' =>
				array(
					0 => 'oConfirmChildOperation',
				),
		),
	'rCommissionByParent' =>
		array(
			'description' => 'Расчет комиссии по родителю',
			'id' => 1502,
			'type' => 2,
			'children' =>
				array(
					0 => 'oUseParentCommissions',
				),
		),
	'rCommissionSpec' =>
		array(
			'description' => 'Роль для подтверждения комиссий на статус «Действующий»',
			'id' => 1446,
			'type' => 2,
			'children' =>
				array(
					0 => 'oActivateCommission',
					1 => 'oChangeCommissionStatus',
					2 => 'oDeleteCommission',
					3 => 'oReportCommissions',
					4 => 'oReportRegistrations',
				),
		),
	'rControlAgeLimit' =>
		array(
			'description' => 'Создание и редактирование возрастного лимита в кабинете модератора',
			'id' => 1999,
			'type' => 2,
			'children' =>
				array(
					0 => 'oControlAgeLimit',
				),
		),
	'rControlBlockedAddressCache' =>
		array(
			'description' => 'Роль с возможностью управлять списком блокированных IP',
			'id' => 1873,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBlockIP',
					1 => 'oUnblockIP',
				),
		),
	'rCoreAdmin' =>
		array(
			'description' => 'Администратор ядра, администратор CoreAPI и MobiAPI',
			'id' => 1625,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAppConfig',
					1 => 'oBackendAll',
					2 => 'oCleanerManage',
					3 => 'oGeoCityManage',
					4 => 'oGeoCountryManage',
					5 => 'oGeoCurrencyManage',
					6 => 'oGeoRegionManage',
					7 => 'oGetCities',
					8 => 'oGetCountries',
					9 => 'oGetCountryCities',
					10 => 'oGetServiceGroups',
					11 => 'oGetServices',
					12 => 'oGiiManage',
					13 => 'oLogreaderManage',
					14 => 'oNotifyManage',
					15 => 'oOfflineManage',
					16 => 'oPartnerManage',
					17 => 'oRbacManage',
					18 => 'oRestClientAll',
					19 => 'oServiceBlacklistManage',
					20 => 'oServiceCategoryManage',
					21 => 'oServiceFieldManage',
					22 => 'oServiceHistoryManage',
					23 => 'oServiceJournalManage',
					24 => 'oServiceServiceManage',
				),
		),
	'rCreditor' =>
		array(
			'description' => 'Роль для пользования родительскими деньгами в рамках кредитной задолженности',
			'id' => 1603,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationWithParentAccount',
					1 => 'oOperationWithParentCredit',
					2 => 'oReportCreditOperations',
				),
		),
	'rCron' =>
		array(
			'description' => 'Имеет доступ только рассылать отчеты мерчантам',
			'id' => 364,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCronReports',
					1 => 'oReportMerchants',
					2 => 'oViewAllOperations',
				),
		),
	'rCustomer' =>
		array(
			'description' => 'Заказчик (читай терминал)',
			'id' => 1899,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oAccessSubAgentCabinet',
					2 => 'oCancelOperation',
					3 => 'oCompleteWithdrawal',
					4 => 'oConfirmOperation',
					5 => 'oEditProfile',
					6 => 'oEditSecuritySettings',
					7 => 'oGetCardOperationInfo',
					8 => 'oGetCreditAmount',
					9 => 'oGetIdentifiedStatus',
					10 => 'oGetOwnStorningOperations',
					11 => 'oGetRemainsToDate',
					12 => 'oGetReturnsCount',
					13 => 'oGetServiceOperationsCount',
					14 => 'oPaymentReceive',
					15 => 'oPaymentSend',
					16 => 'oRegisterAddresslessTransferUser',
					17 => 'oReportAgentReverts',
					18 => 'oReportCreditOperations',
					19 => 'oReportDetailedOperations',
					20 => 'oReportTransfers',
					21 => 'oTransferReceive',
					22 => 'oTransferSend',
					23 => 'oTransferSubagent',
					24 => 'oUnlimitedTransfer',
					25 => 'oViewAgentCommissions',
				),
		),
	'rCustomerAccountant' =>
		array(
			'description' => 'Роль для бухгалтера заказчика, позволяет получать баланс, сальдо, сводный отчёт по платежам. Скрывает меню Выплаты и История ',
			'id' => 1900,
			'type' => 2,
			'children' =>
				array(
					0 => 'oDoNotShowHistoryAccMenu',
					1 => 'oDoNotShowPayoutsAccMenu',
					2 => 'oGetCreditBalanceToDate',
					3 => 'oGetSubjectParent',
					4 => 'oGetSummaryReport',
				),
		),
	'rCustomerAdmin' =>
		array(
			'description' => ' Заказчик с правами администрирования своего портала',
			'id' => 1901,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSendRequestToChangeGatewayCommission',
					1 => 'oUpdateGatewayServices',
					2 => 'oViewGatewayServices',
				),
		),
	'rCustomerAuditor' =>
		array(
			'description' => 'заказчик с правом просматривать реестр по кошельку',
			'id' => 1902,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetRemainsToDate',
					1 => 'oReportSubagentConsolidated',
				),
		),
	'rCustomerCabinetWithdrawal' =>
		array(
			'description' => 'Заказчик c правом вывода на карту и БС через кабинет',
			'id' => 1903,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewWithdrawalToBankAccMenu',
					1 => 'oViewWithdrawalToCardAccMenu',
				),
		),
	'rCustomerChangePaymentService' =>
		array(
			'description' => 'Заказчик сервис прямого платеж которого может быть изменен в зависимости от psp_tid',
			'id' => 1904,
			'type' => 2,
			'children' =>
				array(
					0 => 'oChangePaymentService',
				),
		),
	'rCustomerForApplePay' =>
		array(
			'description' => 'Заказчик для Apple Pay',
			'id' => 1905,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationApplePay',
				),
		),
	'rCustomerForBonuses' =>
		array(
			'description' => 'Заказчик для конвертации бонусов',
			'id' => 1906,
			'type' => 2,
			'children' =>
				array(
					0 => 'oManageReferralProgram',
					1 => 'oTransferBonusBalance',
				),
		),
	'rCustomerForGooglePay' =>
		array(
			'description' => 'Заказчик для Google Pay',
			'id' => 1898,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationGooglePay',
				),
		),
	'rCustomerForIdentifiedPseudoUser' =>
		array(
			'description' => 'Заказчик для оплаты услуг от имени идентифицированных псевдо-пользователей',
			'id' => 1907,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateIdentifiedPseudoUser',
				),
		),
	'rCustomerForLinkedCard' =>
		array(
			'description' => 'Заказчик для привязанных карт',
			'id' => 1908,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationLinkedCard',
				),
		),
	'rCustomerForNominatedPseudoUser' =>
		array(
			'description' => 'Заказчик для оплаты услуг от имени упрощенно идентифицированных псевдо-пользователей',
			'id' => 1909,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateNominatedPseudoUser',
				),
		),
	'rCustomerForPseudoUser' =>
		array(
			'description' => 'Заказчик для оплаты услуг от имени псевдо-пользователей',
			'id' => 1910,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateOperationForPseudoUser',
					1 => 'oReturnPartOfOperation',
					2 => 'oReverseOwnTransfer',
				),
		),
	'rCustomerForUser' =>
		array(
			'description' => 'Заказчик для оплаты услуг от имени пользователей',
			'id' => 1911,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptBonusOfferAgreementForUser',
					1 => 'oBlockSubjectForUser',
					2 => 'oCloseOwnUsers',
					3 => 'oConfirmOperationForUser',
					4 => 'oCreateOperationForUser',
					5 => 'oCreateOperationWithSpecialist',
					6 => 'oGetBalanceOfUser',
					7 => 'oGetLinkedCardList',
					8 => 'oManageCardsForUser',
					9 => 'oManageReferralProgramForUser',
					10 => 'oPartnerBlockUser',
					11 => 'oPartnerUnblockUser',
					12 => 'oRegisterOwnUsers',
					13 => 'oRegisterUser',
					14 => 'oReturnPartOfOperation',
					15 => 'oReverseOwnTransfer',
					16 => 'oSetSpendingPriorityForUser',
					17 => 'oUserBlockUser',
					18 => 'oUserUnblockUser',
					19 => 'oViewOperationsOfUser',
					20 => 'oWithdrawalOther',
				),
		),
	'rCustomerFullCheckNominator' =>
		array(
			'description' => 'Заказчик с правом перевода неидентифицированных пользователей в именные (с фоновой полной идентификацией)',
			'id' => 1912,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNominateUserFullCheck',
				),
		),
	'rCustomerIdentifier' =>
		array(
			'description' => 'Заказчик с правом идентификации пользователей',
			'id' => 1913,
			'type' => 2,
			'children' =>
				array(
					0 => 'oIdentifyUser',
				),
		),
	'rCustomerIndividualReplenishment' =>
		array(
			'description' => 'Роль позволяющая делать платежи внутри кабинета заказчика ',
			'id' => 1914,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewIndividualReplenishment',
				),
		),
	'rCustomerMobileWithdrawal' =>
		array(
			'description' => 'Роль позволяющая делать выводы на баланс мобильного оператора с кабинета заказчика',
			'id' => 1915,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewMobileWithdrawal',
				),
		),
	'rCustomerNominator' =>
		array(
			'description' => 'Заказчик с правом перевода неидентифицированных пользователей в именные',
			'id' => 1916,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNominateUser',
				),
		),
	'rCustomerOperator' =>
		array(
			'description' => 'Оператор заказчика',
			'id' => 1917,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oGetParentInfo',
					2 => 'oGetRemainsToDate',
					3 => 'oGetServiceOperationsCount',
					4 => 'oReportAgentReverts',
					5 => 'oReportCreditOperations',
					6 => 'oReportDetailedOperations',
					7 => 'oReportTransfers',
					8 => 'oViewAgentCommissions',
					9 => 'oViewParentsOperations',
					10 => 'oWorkWithParentOperations',
				),
		),
	'rCustomerPostPaid' =>
		array(
			'description' => 'Заказчик, пользующийся агентским счетом',
			'id' => 1918,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationWithParentAccount',
				),
		),
	'rCustomerReports' =>
		array(
			'description' => 'Заказчик с правом доступа к своим отчетам в partnerCabinet',
			'id' => 1919,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportMoneyMovement',
					1 => 'oReportSubagentClientReconciliation',
					2 => 'oReportSubagentEMIncomeReconciliation',
					3 => 'oReportSubagentEMSaleReconciliation',
					4 => 'oReportSubagentEMSaleToClientReconciliation',
				),
		),
	'rCustomerWithAcquiring' =>
		array(
			'description' => 'Заказчик с эквайрингом',
			'id' => 1920,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationAcquiring',
				),
		),
	'rCustomerWithCashOut' =>
		array(
			'description' => 'Заказчик с возможностью вывода денег с кошелька',
			'id' => 1921,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oBabilonOperation',
					2 => 'oBeelineUzOperation',
					3 => 'oBookmakerRefund',
					4 => 'oCancelOperation',
					5 => 'oCompleteWithdrawal',
					6 => 'oConfirmOperation',
					7 => 'oConfirmOperationWithSpecialist',
					8 => 'oCreateOperationWithSpecialist',
					9 => 'oEditProfile',
					10 => 'oEditSecuritySettings',
					11 => 'oGetBalanceOfAnyUser',
					12 => 'oGetRemainsToDate',
					13 => 'oGetReturnsCount',
					14 => 'oGetServiceOperationsCount',
					15 => 'oKCellOperation',
					16 => 'oMegafonOperation',
					17 => 'oMobileRefund',
					18 => 'oOberthurOperation',
					19 => 'oPaymentReceive',
					20 => 'oPaymentSend',
					21 => 'oReportAgentReverts',
					22 => 'oReportDetailedOperations',
					23 => 'oReportTransfers',
					24 => 'oReverseOwnTransfer',
					25 => 'oSmppOperation',
					26 => 'oTcellOperation',
					27 => 'oTele2Operation',
					28 => 'oTransferOtherSend',
					29 => 'oTransferReceive',
					30 => 'oTransferSend',
					31 => 'oUztelecomOperation',
					32 => 'oWithdrawalOther',
					33 => 'oZetmobileOperation',
				),
		),
	'rDebitor' =>
		array(
			'description' => 'Роль для дебитора',
			'id' => 1850,
			'type' => 2,
		),
	'rDischargePayer' =>
		array(
			'description' => 'Специалист с погашением после платежа',
			'id' => 1812,
			'type' => 2,
			'children' =>
				array(
					0 => 'oPaymentDischarge',
				),
		),
	'rDivider' =>
		array(
			'description' => 'Роль, позволяющая из операции, превышающей лимит создавать несколько операций в пределах лимита',
			'id' => 757,
			'type' => 2,
			'children' =>
				array(
					0 => 'oDivideOperation',
				),
		),
	'rEmissionPayer' =>
		array(
			'description' => 'Эмитент, выпускающий деньги на один платеж',
			'id' => 928,
			'type' => 2,
			'children' =>
				array(
					0 => 'oEmissionPayment',
					1 => 'oPaymentSend',
				),
		),
	'rEmitent' =>
		array(
			'description' => 'Эмитент',
			'id' => 185,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddOperationDescription',
					1 => 'oConfirmOperation',
					2 => 'oGetOwnStorningOperations',
					3 => 'oMoneyIssue',
					4 => 'oReportEmissionPayment',
					5 => 'oReportEmitentRemainings',
					6 => 'oReportForNationalBankForm10',
					7 => 'oReportForNationalBankForm7',
					8 => 'oReportForNationalBankForm8',
					9 => 'oReportForNationalBankForm9',
					10 => 'oReportMoneyIssue',
					11 => 'oReportMoneyRedemption',
					12 => 'oReportMT100',
					13 => 'oReportTransfers',
					14 => 'oTransferReceive',
				),
		),
	'rEmitentAdmin' =>
		array(
			'description' => 'Эмитент-администратор',
			'id' => 8,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddOperationDescription',
					1 => 'oConfirmOperation',
					2 => 'oReportCommissions',
					3 => 'oReportEmissionPayment',
					4 => 'oReportIdentifications',
					5 => 'oReportMoneyIssue',
					6 => 'oReportMoneyRedemption',
					7 => 'oReportMT100',
					8 => 'oReportOperDay',
					9 => 'oReportTransfers',
					10 => 'oViewGatewayServices',
				),
		),
	'rEmitentInfoReporter' =>
		array(
			'description' => 'Пользователь для просмотра доступных сервисов, ставок по сервисам, проведенных платежей Эмитента',
			'id' => 1588,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddOperationDescription',
					1 => 'oConfirmChildOperation',
					2 => 'oEmissionPayment',
					3 => 'oGetSubjectSiblings',
					4 => 'oLinkCard',
					5 => 'oReportCommissions',
					6 => 'oReportEmissionPayment',
				),
		),
	'rEmitentMarketolog' =>
		array(
			'description' => 'Эмитент-маркетолог',
			'id' => 9,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddOperationDescription',
					1 => 'oReportEmissionPayment',
					2 => 'oReportEmitentRemainings',
					3 => 'oReportIdentifications',
					4 => 'oReportMoneyIssue',
					5 => 'oReportMoneyRedemption',
					6 => 'oReportTransfers',
				),
		),
	'rEmitentOperational' =>
		array(
			'description' => 'Эмитент-операционист',
			'id' => 10,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddOperationDescription',
					1 => 'oConfirmOperation',
					2 => 'oEmissionPayment',
					3 => 'oGetSubjectSiblings',
					4 => 'oLinkCard',
					5 => 'oMoneyOperationalIssue',
					6 => 'oMoneyOperationalRedemption',
					7 => 'oReportCommissions',
					8 => 'oReportEmissionPayment',
					9 => 'oReportEmitentRemainings',
					10 => 'oReportForNationalBankForm10',
					11 => 'oReportForNationalBankForm7',
					12 => 'oReportForNationalBankForm8',
					13 => 'oReportForNationalBankForm9',
					14 => 'oReportMoneyIssue',
					15 => 'oReportMoneyRedemption',
					16 => 'oReportTransfers',
					17 => 'oUpdateGatewayServices',
					18 => 'oViewGatewayReport',
					19 => 'oViewGatewayServices',
					20 => 'oViewParentsOperations',
				),
		),
	'rEmitentPayWatcher' =>
		array(
			'description' => 'Роль, для просмотра платежей эмитента',
			'id' => 1289,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportEmissionPayment',
				),
		),
	'rEmployee' =>
		array(
			'description' => 'Сотрудник Wooppay',
			'id' => 389,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewUserCount',
				),
		),
	'rEUBankSpecialist' =>
		array(
			'description' => 'Роль для просмотра выпуска ЭД от имени специалиста',
			'id' => 1451,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportAllEmissionPayments',
				),
		),
	'rExperimentalFeatures' =>
		array(
			'description' => 'Роль для экспериментальные функции',
			'id' => 1874,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetNewFunctions',
				),
		),
	'rFinanceSpecialist' =>
		array(
			'description' => 'Специалист финансового отдела',
			'id' => 291,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessFinancialCabinet',
					1 => 'oActivateCommission',
					2 => 'oAgentKvitan',
					3 => 'oCancelOperation',
					4 => 'oCancelWaitingOperation',
					5 => 'oChangeCommissionStatus',
					6 => 'oChangeStatus',
					7 => 'oChangeSubjectStatusToActive',
					8 => 'oChangeSubjectStatusToCreated',
					9 => 'oConfirmOperation',
					10 => 'oConfirmOtherOperations',
					11 => 'oCreateCreditOperation',
					12 => 'oDeleteVisibleOperation',
					13 => 'oEditAgent',
					14 => 'oEditBankTransferCancelReasons',
					15 => 'oEditRedirectRouteForPayment',
					16 => 'oEditSystemUser',
					17 => 'oGenerateMT100',
					18 => 'oGetAccountsMerchant',
					19 => 'oGetAccountSumToDate',
					20 => 'oGetCreditAmount',
					21 => 'oGetCurrencies',
					22 => 'oGetDischargeAmount',
					23 => 'oGetRemainsCreditAmount',
					24 => 'oGetRemainsToDate',
					25 => 'oGetSubjectListByRole',
					26 => 'oMerchantKvitan',
					27 => 'oMerchantReturn',
					28 => 'oMobileRefund',
					29 => 'oMoneyAgentRedemption',
					30 => 'oMoneyDischargeReportForAnyUser',
					31 => 'oMoneyEmissionReportForAnyUser',
					32 => 'oMoneyMerchantRedemption',
					33 => 'oMoneyPerformOtherIssue',
					34 => 'oMoneySubAgentRedemption',
					35 => 'oMoneySystemRedemption',
					36 => 'oReportACBReturn',
					37 => 'oReportAccounts',
					38 => 'oReportActED',
					39 => 'oReportAgents',
					40 => 'oReportAllCreditOperations',
					41 => 'oReportByDecade',
					42 => 'oReportCommissions',
					43 => 'oReportCreditOperations',
					44 => 'oReportForNationalBankForm10',
					45 => 'oReportForNationalBankForm15',
					46 => 'oReportForNationalBankForm7',
					47 => 'oReportForNationalBankForm8',
					48 => 'oReportForNationalBankForm9',
					49 => 'oReportJuridicalSubjects',
					50 => 'oReportMerchants',
					51 => 'oReportMoneyIssue',
					52 => 'oReportMoneyMovement',
					53 => 'oReportMoneyRedemption',
					54 => 'oReportReconciliation',
					55 => 'oReportRegistrations',
					56 => 'oReportRegOperationByED',
					57 => 'oReportRemainingBalance',
					58 => 'oReportReward',
					59 => 'oReportVipSubjects',
					60 => 'oReportWithdrawal',
					61 => 'oReturnPartOfOperation',
					62 => 'oReturnPartOfOperationAnyUser',
					63 => 'oReverseBankTransfer',
					64 => 'oReverseTransfer',
					65 => 'oSetDischargeEnabled',
					66 => 'oSetDischargeEnabledAny',
					67 => 'oSetDischargementSchedule',
					68 => 'oSetMT100Approved',
					69 => 'oSetPlannedIndicators',
					70 => 'oSubAgentKvitan',
					71 => 'oSystemKvitan',
					72 => 'oTransferOtherPerform',
					73 => 'oViewAllOperations',
					74 => 'oViewLoansRepaymentOperations',
					75 => 'oVipSubjectListModify',
				),
		),
	'rGameMaster' =>
		array(
			'description' => 'Роль позволяющая запускать игры без подтверждения списания',
			'id' => 1712,
			'type' => 2,
			'children' =>
				array(
					0 => 'oStartGameSzhuldyz',
				),
		),
	'rGetAllOperationsDataByExtId' =>
		array(
			'description' => 'Пользователь с правом получения данных по любой операции по extid',
			'id' => 1997,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetAllOperationsDataByExtId',
				),
		),
	'rGetCardOperationInfo' =>
		array(
			'description' => 'Пользователь с правом получения данных по операции из эквайринга',
			'id' => 1718,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetCardOperationInfo',
				),
		),
	'rGetCreditBalanceToDate' =>
		array(
			'description' => 'Просмотр остатка кредиторской задолженности по субъекту',
			'id' => 1985,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetCreditBalanceToDate',
				),
		),
	'rGetOperationDataByExtId' =>
		array(
			'description' => 'Пользователь с правом получения данных по своей операции по extid',
			'id' => 1580,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetOperationDataByExtId',
				),
		),
	'rGetReceiptByTransactionId' =>
		array(
			'description' => 'Роль, с правом получать чек по внешнему id операции',
			'id' => 1830,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetReceiptByTransactionId',
				),
		),
	'rGetUniquePaymentCode' =>
		array(
			'description' => 'Роль для получения данных УКП по extref(БЦК)',
			'id' => 1990,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetUniquePaymentCode',
				),
		),
	'rGrandMasterSPP' =>
		array(
			'description' => 'Позволяет оператору СПП делать возвраты по моб. финансам и перепроводить операции в биллинге',
			'id' => 1581,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBillingRepayOperation',
					1 => 'oBKBalanceNotificationAdministration',
					2 => 'oBookmakerRefund',
					3 => 'oBookmakerRefundAny',
					4 => 'oCancelOperation',
					5 => 'oCancelOtherOperations',
					6 => 'oCancelWaitingOperation',
					7 => 'oCheckPayments',
					8 => 'oCloseOwnUsers',
					9 => 'oCompletePaymentOfBlockedUser',
					10 => 'oConfirmOperationForUser',
					11 => 'oCreateSupportMaster',
					12 => 'oCreateSupportUser',
					13 => 'oDeleteOperationFromStatusQueue',
					14 => 'oGetBalanceOfAnyUser',
					15 => 'oGetSubjectSocialLinks',
					16 => 'oJuridicalSubjectPasswordChange',
					17 => 'oJuridicalSubjectProfileEdit',
					18 => 'oMarkServiceAsDead',
					19 => 'oMobileRefund',
					20 => 'oMobileRefundAny',
					21 => 'oNominateUser',
					22 => 'oNotifyWithdrawalAgent',
					23 => 'oPaasBalanceNotificationAdministration',
					24 => 'oPasswordResetAnyUser',
					25 => 'oReportAccountManagerMerchants',
					26 => 'oReportAccountManagerPeriod',
					27 => 'oReportCommissions',
					28 => 'oReportJuridicalSubjects',
					29 => 'oRestoreDeletedOperation',
					30 => 'oReverseOperationOfUser',
					31 => 'oSetOperatorToNumber',
					32 => 'oSystemBalanceNotificationAdministration',
					33 => 'oTransferBonusBalance',
					34 => 'oZWalletReturn',
					35 => 'oZWalletReturnToAny',
					36 => 'tViewLogs',
				),
		),
	'rGuest' =>
		array(
			'description' => 'Гость',
			'id' => 14,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGuestOperations',
					1 => 'oRegisterUser',
					2 => 'oViewCompareList',
					3 => 'oViewServices',
					4 => 'oViewYaShare',
				),
		),
	'rHalykConversionUser' =>
		array(
			'description' => 'Пользователь, отправляющий запросы по курсам конвертации валют Halyk Bank',
			'id' => 1755,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddHalykConversionRate',
				),
		),
	'rIgnoreExistingConfirmationCode' =>
		array(
			'description' => 'Роль с правом oIgnoreExistingConfirmationCode',
			'id' => 1988,
			'type' => 2,
			'children' =>
				array(
					0 => 'oIgnoreExistingConfirmationCode',
				),
		),
	'rIgnoreLimitExceededExceptions' =>
		array(
			'description' => 'Роль, позволяющая игнорировать ошибки лимитов по неидентифицированным пользователям',
			'id' => 1941,
			'type' => 2,
			'children' =>
				array(
					0 => 'oIgnoreLimitExceededExceptions',
				),
		),
	'rInvoiceUser' =>
		array(
			'description' => 'Пользователь по умолчанию для операций по инвойсам',
			'id' => 847,
			'type' => 2,
			'children' =>
				array(
					0 => 'oPaymentSend',
				),
		),
	'rJurSubjectCreator' =>
		array(
			'description' => 'Роль для регистрирования юридических субъектов',
			'id' => 1600,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateAgent',
					1 => 'oCreateEmitent',
					2 => 'oCreateEmitentAdmin',
					3 => 'oCreateSubAgent',
					4 => 'oCreateSubSubAgent',
					5 => 'oJuridicalSubjectProfileEdit',
					6 => 'oReportJuridicalSubjects',
				),
		),
	'rJustRegistered' =>
		array(
			'description' => 'Свежезарегистрированный пользователь',
			'id' => 192,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCompleteRegistration',
					1 => 'oPasswordReset',
				),
		),
	'rKcellContentManager' =>
		array(
			'description' => 'позволяет управлять баннерами на лендинге Кселл Ogobonus',
			'id' => 1879,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessKcellAdminCabinet',
					1 => 'oCreateBanner',
					2 => 'oDeleteBanner',
					3 => 'oReadBanner',
					4 => 'oUpdateBanner',
				),
		),
	'rKcellNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Kcell',
			'id' => 1583,
			'type' => 2,
			'children' =>
				array(
					0 => 'oKcellSMSNotification',
				),
		),
	'rKcellTimeout' =>
		array(
			'description' => 'Партнеры, у которых проблемы из-за медленной работы Kcell',
			'id' => 1618,
			'type' => 2,
			'children' =>
				array(
					0 => 'oIgnoreKcellLanguage',
				),
		),
	'rKcellWalletUser' =>
		array(
			'description' => 'Неидентифицированный пользователь кошелька Kcell',
			'id' => 1714,
			'type' => 2,
			'children' =>
				array(
					0 => 'oRemovePrefixFromLogin',
					1 => 'oUserInOperationByPhone',
				),
		),
	'rKeepFailedBillingOperation' =>
		array(
			'description' => 'Роль, позволяющая не отменять платежи при биллинговых ошибках',
			'id' => 1894,
			'type' => 2,
			'children' =>
				array(
					0 => 'oKeepFailedBillingOperation',
				),
		),
	'rKPAdmin' =>
		array(
			'description' => 'Администратор портала «Kcell»',
			'id' => 1491,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessKcellAdminCabinet',
					1 => 'oCloseOwnUsers',
					2 => 'oCreateBanner',
					3 => 'oCreateGatewayLimit',
					4 => 'oCreateGatewayServiceSynonym',
					5 => 'oCreateKPContentManager',
					6 => 'oCreateKPSupportUser',
					7 => 'oDelayedHistory',
					8 => 'oDeleteBanner',
					9 => 'oDeleteGatewayLimit',
					10 => 'oGetParentInfo',
					11 => 'oGetRemainsToDate',
					12 => 'oGetServiceOperationsCount',
					13 => 'oKcellBlockUser',
					14 => 'oKcellPasswordReset',
					15 => 'oKcellUnblockUser',
					16 => 'oReadBanner',
					17 => 'oReportCommissions',
					18 => 'oReportConfirmedCommissions',
					19 => 'oReportTransfers',
					20 => 'oSendRequestToChangeGatewayCommission',
					21 => 'oUpdateBanner',
					22 => 'oUpdateGatewayLimit',
					23 => 'oUpdateGatewayServices',
					24 => 'oViewGatewayAdminMainPage',
					25 => 'oViewGatewayReport',
					26 => 'oViewGatewayServices',
					27 => 'oViewParentsChildrensOperations',
					28 => 'oViewParentsOperations',
					29 => 'oViewRelatedOperations',
				),
		),
	'rKPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала «Kcell»',
			'id' => 1504,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessKcellAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetBalanceOfUser',
					3 => 'oGetRemainsToDate',
					4 => 'oReportMoneyMovement',
					5 => 'oReportTransfers',
					6 => 'oViewGatewayAdminMainPage',
					7 => 'oViewGatewayReport',
					8 => 'oViewGatewayReportForSupportUser',
					9 => 'oViewParentsChildrensOperations',
					10 => 'oViewParentsOperations',
					11 => 'oViewRelatedOperations',
				),
		),
	'rLandingPagesManager' =>
		array(
			'description' => 'Менеджер посадочных страниц',
			'id' => 627,
			'type' => 2,
			'children' =>
				array(
					0 => 'oLandingPagesAdd',
					1 => 'oLandingPagesDelete',
					2 => 'oLandingPagesEdit',
					3 => 'oLandingPagesInsertJS',
					4 => 'oLandingPagesList',
					5 => 'oTextPagesAdd',
					6 => 'oTextPagesDelete',
					7 => 'oTextPagesEdit',
					8 => 'oTextPagesInsertJS',
					9 => 'oTextPagesView',
				),
		),
	'rLimitByParent' =>
		array(
			'description' => 'Лимиты по родителю',
			'id' => 1658,
			'type' => 2,
			'children' =>
				array(
					0 => 'oUseParentLimits',
				),
		),
	'rLoansRepaymentSpecialist' =>
		array(
			'description' => 'Специалист по погашению кредитов',
			'id' => 800,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessFinancialCabinet',
					1 => 'oCancelBankTransfer',
					2 => 'oChangeStatus',
					3 => 'oChangeSubjectStatusToActive',
					4 => 'oChangeSubjectStatusToCreated',
					5 => 'oConfirmBankTransfer',
					6 => 'oDeleteVisibleOperation',
					7 => 'oEditBankTransferCancelReasons',
					8 => 'oGenerateMT100',
					9 => 'oGetAccountsMerchant',
					10 => 'oGetCurrencies',
					11 => 'oGetDischargeAmount',
					12 => 'oGetRemainsToDate',
					13 => 'oGetStorningOperations',
					14 => 'oMobileRefund',
					15 => 'oMoneyOtherIssue',
					16 => 'oReportJuridicalSubjects',
					17 => 'oReportReconciliation',
					18 => 'oReportRegistrations',
					19 => 'oReportRemainingBalance',
					20 => 'oReverseBankTransfer',
					21 => 'oTransferOtherSend',
					22 => 'oViewAllOperations',
					23 => 'oViewLoansRepaymentOperations',
					24 => 'oWithdrawalToBankAccountDataWork',
				),
		),
	'rLocalTpsUser' =>
		array(
			'description' => 'Пользователь очереди TPS',
			'id' => 1587,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBillingRepayOperation',
					1 => 'oCancelOtherOperations',
					2 => 'oCancelWaitingOperation',
					3 => 'oConfirmOtherOperations',
					4 => 'oMobileRefund',
					5 => 'oMobileRefundAny',
					6 => 'oOberthurNotification',
					7 => 'oViewAllOperations',
				),
		),
	'rMakeMerchantActive' =>
		array(
			'description' => 'Роль позволяющая перевести мерчанта на статус "Действующий"',
			'id' => 1646,
			'type' => 2,
			'children' =>
				array(
					0 => 'oChangeStatus',
					1 => 'oChangeSubjectStatusToActive',
					2 => 'oChangeSubjectStatusToCreated',
				),
		),
	'rMarketolog' =>
		array(
			'description' => 'Маркетолог системы',
			'id' => 13,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMarketologCabinet',
					1 => 'oGetServicesBySystem',
					2 => 'oManageRedirections',
					3 => 'oMetaTagsEdit',
					4 => 'oModeratingComment',
					5 => 'oNotifyManage',
					6 => 'oReportBirthday',
					7 => 'oReportIdentifications',
					8 => 'oReportMarketerInfo',
					9 => 'oReportRegistrations',
					10 => 'oReportSessions',
					11 => 'oReportTransfers',
					12 => 'oSendDirectMail',
					13 => 'oServicesBanner',
					14 => 'oSetPlannedIndicators',
					15 => 'oStatisticsViewAttraction',
					16 => 'oStatisticsViewDeduction',
					17 => 'oViewStatisticsReports',
					18 => 'oViewUserCount',
					19 => 'oWriteSystemMessage',
				),
		),
	'rMasterSPP' =>
		array(
			'description' => 'Старший специалист СПП',
			'id' => 1623,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBillingRepayOperation',
					1 => 'oCheckPayments',
					2 => 'oCompletePaymentOfBlockedUser',
					3 => 'oFaqManagement',
					4 => 'oGetAtmStatus',
					5 => 'oGetBalanceOfAnyUser',
					6 => 'oGetSubjectSocialLinks',
					7 => 'oMarkServiceAsDead',
					8 => 'oMobileRefund',
					9 => 'oMobileRefundAny',
					10 => 'oNominateUser',
					11 => 'oNotifyInvoiceMerchant',
					12 => 'oNotifyWithdrawalAgent',
					13 => 'oPasswordResetAnyUser',
					14 => 'oReportCommissions',
					15 => 'oReportRegistrations',
					16 => 'oSetOperatorToNumber',
					17 => 'oZWalletReturn',
					18 => 'oZWalletReturnToAny',
					19 => 'tViewLogs',
				),
		),
	'rMegafonNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Megafon',
			'id' => 1953,
			'type' => 2,
			'children' =>
				array(
					0 => 'oMegafonSMSNotification',
				),
		),
	'rMerchant' =>
		array(
			'description' => 'Мерчант',
			'id' => 5,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelIncomingOperation',
					2 => 'oCancelOperation',
					3 => 'oChangeOperationStatus',
					4 => 'oCommentWrite',
					5 => 'oCreateInvoice',
					6 => 'oCreateMerchantEmployeeChiefAccountant',
					7 => 'oCreateMerchantEmployeeChiefManager',
					8 => 'oCreateMerchantEmployeeChiefSupport',
					9 => 'oCreateMerchantPoint',
					10 => 'oCreatePaymentsReport',
					11 => 'oCreateSubMerchant',
					12 => 'oCustomizeInvoice',
					13 => 'oCustomModifyService',
					14 => 'oEditLotTags',
					15 => 'oEditMerchantProfile',
					16 => 'oEditProfile',
					17 => 'oEmployeesManagement',
					18 => 'oExecuteDream',
					19 => 'oGetMerchantPoints',
					20 => 'oGetMobileOperator',
					21 => 'oGetRemainsToDate',
					22 => 'oGetReturnsCount',
					23 => 'oGetServiceOperationsCount',
					24 => 'oGetSubjectParent',
					25 => 'oGroupOperation',
					26 => 'oLinkOperationToSpecialistAndMerchant',
					27 => 'oLinkSpecialistToPoint',
					28 => 'oLotEdit',
					29 => 'oLotsViewStatNotSend',
					30 => 'oMerchantRequestSupport',
					31 => 'oMerchantReturn',
					32 => 'oModifyMerchantPoint',
					33 => 'oPaymentReceive',
					34 => 'oRegisterPointOperator',
					35 => 'oReportDetailedOperations',
					36 => 'oReportDreamers',
					37 => 'oReportExtendedOperations',
					38 => 'oReportMerchantFullRegisterOperation',
					39 => 'oReportMerchantPoints',
					40 => 'oReportTransfers',
					41 => 'oReturnPartOfOperation',
					42 => 'oReverseOwnTransfer',
					43 => 'oServiceEditWaiting',
					44 => 'oSetDischargeEnabled',
					45 => 'oShopCreate',
					46 => 'oShopEdit',
					47 => 'oTransferReceive',
					48 => 'oUnlinkSpecialistFromPoint',
					49 => 'oViewCommissionAccount',
					50 => 'oViewDreamers',
					51 => 'oViewMerchantProfile',
					52 => 'oViewMessages',
					53 => 'oViewProfile',
					54 => 'oViewRelatedParentOperations',
					55 => 'oWriteMessage',
				),
		),
	'rMerchantAccountant' =>
		array(
			'description' => 'Бухгалтер мерчанта',
			'id' => 1963,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelOperation',
					2 => 'oCreatePaymentsReport',
					3 => 'oEditProfile',
					4 => 'oGetParentInfo',
					5 => 'oGetRemainsToDate',
					6 => 'oGetReturnsCount',
					7 => 'oGetServiceOperationsCount',
					8 => 'oGetSubjectParent',
					9 => 'oMerchantReturn',
					10 => 'oNotifyOwnInvoiceMerchant',
					11 => 'oReportDetailedOperations',
					12 => 'oReportExtendedOperations',
					13 => 'oReportTransfers',
					14 => 'oReturnPartOfOperation',
					15 => 'oReverseOwnTransfer',
					16 => 'oViewParentsOperations',
					17 => 'oViewProfile',
				),
		),
	'rMerchantActive' =>
		array(
			'description' => 'Роль для отложенного получения денег',
			'id' => 1877,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReceiveMoneyAsynchronously',
				),
		),
	'rMerchantAdmin' =>
		array(
			'description' => 'Партнёр, являющийся маркетплейсом или платформой, аккумулирующей других мерчантов',
			'id' => 1598,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMerchantAdminCabinet',
					1 => 'oAccessPartnerCabinet',
					2 => 'oBabilonSMSNotification',
					3 => 'oBeelineSMSNotification',
					4 => 'oBeelineUzSMSNotification',
					5 => 'oCancelIncomingOperation',
					6 => 'oCancelOperation',
					7 => 'oChangeOperationStatus',
					8 => 'oCreateInvoice',
					9 => 'oCreatePartnerUser',
					10 => 'oCreatePaymentsReport',
					11 => 'oDeleteChildSubject',
					12 => 'oEditProfile',
					13 => 'oEmployeesManagement',
					14 => 'oGetMobileOperator',
					15 => 'oGetRemainsToDate',
					16 => 'oGetReturnsCount',
					17 => 'oGetServiceOperationsCount',
					18 => 'oGetSubjectParent',
					19 => 'oGroupOperation',
					20 => 'oKcellSMSNotification',
					21 => 'oMegafonSMSNotification',
					22 => 'oMerchantReturn',
					23 => 'oMerchantSiteManagement',
					24 => 'oReportDetailedOperations',
					25 => 'oReportTransfers',
					26 => 'oReturnPartOfOperation',
					27 => 'oReverseOwnTransfer',
					28 => 'oTcellSMSNotification',
					29 => 'oTele2SMSNotification',
					30 => 'oUztelecomSMSNotification',
					31 => 'oViewChildrensOperations',
					32 => 'oViewCommissionAccount',
					33 => 'oViewMerchantProfile',
					34 => 'oViewPartnerStatistic',
					35 => 'oViewProfile',
					36 => 'oWriteMessage',
					37 => 'oZetmobileSMSNotification',
				),
		),
	'rMerchantBeelineDirectPayment' =>
		array(
			'description' => 'Мерчант с возможностью проведения операции с оплатой СМС без кода подтверждения',
			'id' => 1317,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSendSMSPaymentWithoutCode',
				),
		),
	'rMerchantChiefAccountant' =>
		array(
			'description' => 'Главный бухгалтер мерчанта',
			'id' => 1962,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelOperation',
					2 => 'oCreateMerchantEmployeeAccountant',
					3 => 'oCreatePaymentsReport',
					4 => 'oEditProfile',
					5 => 'oEmployeesManagement',
					6 => 'oGetParentInfo',
					7 => 'oGetRemainsToDate',
					8 => 'oGetReturnsCount',
					9 => 'oGetServiceOperationsCount',
					10 => 'oGetSubjectParent',
					11 => 'oMerchantReturn',
					12 => 'oNotifyOwnInvoiceMerchant',
					13 => 'oReportDetailedOperations',
					14 => 'oReportExtendedOperations',
					15 => 'oReportTransfers',
					16 => 'oReturnPartOfOperation',
					17 => 'oReverseOwnTransfer',
					18 => 'oViewParentsOperations',
					19 => 'oViewProfile',
				),
		),
	'rMerchantChiefManager' =>
		array(
			'description' => 'Главный менеджер мерчанта',
			'id' => 1961,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelIncomingOperation',
					2 => 'oCancelOperation',
					3 => 'oCreateInvoice',
					4 => 'oCreateMerchantEmployeeChiefAccountant',
					5 => 'oCreateMerchantEmployeeChiefSupport',
					6 => 'oCreateMerchantEmployeeManager',
					7 => 'oCreatePartnerUser',
					8 => 'oCreatePaymentsReport',
					9 => 'oCreateSubMerchant',
					10 => 'oCustomizeInvoice',
					11 => 'oCustomModifyService',
					12 => 'oEditProfile',
					13 => 'oEmployeesManagement',
					14 => 'oGetMobileOperator',
					15 => 'oGetParentInfo',
					16 => 'oGetRemainsToDate',
					17 => 'oGetReturnsCount',
					18 => 'oGetServiceOperationsCount',
					19 => 'oGetSubjectParent',
					20 => 'oGroupOperation',
					21 => 'oMerchantReturn',
					22 => 'oNotifyOwnInvoiceMerchant',
					23 => 'oPaymentReceive',
					24 => 'oReportDetailedOperations',
					25 => 'oReportExtendedOperations',
					26 => 'oReportTransfers',
					27 => 'oReturnPartOfOperation',
					28 => 'oReverseOwnTransfer',
					29 => 'oTransferReceive',
					30 => 'oViewCommissionAccount',
					31 => 'oViewMerchantProfile',
					32 => 'oViewParentsChildrensOperations',
					33 => 'oViewParentsOperations',
					34 => 'oViewProfile',
					35 => 'oWorkWithParentOperations',
				),
		),
	'rMerchantChiefSupport' =>
		array(
			'description' => 'Главный специалист поддержки мерчанта',
			'id' => 1964,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelOperation',
					2 => 'oCreateMerchantEmployeeSupport',
					3 => 'oCreatePaymentsReport',
					4 => 'oEditProfile',
					5 => 'oEmployeesManagement',
					6 => 'oGetParentInfo',
					7 => 'oGetRemainsToDate',
					8 => 'oGetReturnsCount',
					9 => 'oGetServiceOperationsCount',
					10 => 'oGetSubjectParent',
					11 => 'oMerchantReturn',
					12 => 'oNotifyOwnInvoiceMerchant',
					13 => 'oReportDetailedOperations',
					14 => 'oReportExtendedOperations',
					15 => 'oReportTransfers',
					16 => 'oReturnPartOfOperation',
					17 => 'oReverseOwnTransfer',
					18 => 'oViewParentsChildrensOperations',
					19 => 'oViewParentsOperations',
					20 => 'oViewProfile',
				),
		),
	'rMerchantEditor' =>
		array(
			'description' => 'Управляет данными по мерчанту, без удаления',
			'id' => 1500,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateMerchant',
					1 => 'oEditMerchant',
					2 => 'oJuridicalSubjectProfileEdit',
					3 => 'oListJuridicalSubject',
					4 => 'oReportJuridicalSubjects',
					5 => 'oReportTransfers',
				),
		),
	'rMerchantLinkedCardPayment' =>
		array(
			'description' => 'Использование мерчантом способа оплаты с помощью привязанной карты',
			'id' => 2016,
			'type' => 2,
			'children' =>
				array(
					0 => 'oMerchantLinkedCardPayment',
				),
		),
	'rMerchantManager' =>
		array(
			'description' => 'Менеджер мерчанта',
			'id' => 1960,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportExtendedOperations',
				),
		),
	'rMerchantOfflineQr' =>
		array(
			'description' => 'Мерчант для офлайн оплаты по QR',
			'id' => 1394,
			'type' => 2,
			'children' =>
				array(
					0 => 'oMobileRefund',
				),
		),
	'rMerchantPointOperator' =>
		array(
			'description' => 'Кассир QRPay',
			'id' => 1463,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportTransfers',
				),
		),
	'rMerchantRequestSupport' =>
		array(
			'description' => 'Роль позволяющая иметь доступ к разделу запросов в СП',
			'id' => 1935,
			'type' => 2,
			'children' =>
				array(
					0 => 'oMerchantRequestSupport',
				),
		),
	'rMerchantReturnBlock' =>
		array(
			'description' => 'Роль скрывающая кнопку возврата в кабинете мерчанта (НЕ запрещает создавать возвраты!)',
			'id' => 1851,
			'type' => 2,
		),
	'rMerchantSmart' =>
		array(
			'description' => 'Мерчант, с правом oCreateSchoolkid',
			'id' => 510,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreatePaymentsReport',
					1 => 'oCreateSchoolkid',
					2 => 'oGroupPayment',
					3 => 'oPaymentReceive',
					4 => 'oReportSchoolkidsRefills',
					5 => 'oReportSmartSchoolAccounts',
					6 => 'oReportTransfers',
					7 => 'oReturnPartOfOperation',
					8 => 'oReverseOwnTransfer',
					9 => 'oViewMerchantProfile',
					10 => 'oViewProfile',
				),
		),
	'rMerchantSmpp' =>
		array(
			'description' => 'Мерчант с возможностью создания операции с оплатой СМС',
			'id' => 1277,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAddDirectPayer',
					1 => 'oBabilonOperation',
					2 => 'oBabilonSMSNotification',
					3 => 'oBeelineSMSNotification',
					4 => 'oBeelineUzOperation',
					5 => 'oBeelineUzSMSNotification',
					6 => 'oCancelOtpWriteoff',
					7 => 'oCreateOperationWithSpecialist',
					8 => 'oDeleteOwnDirectPayer',
					9 => 'oGetDirectPayerStatus',
					10 => 'oGetMobileOperator',
					11 => 'oGetReceiptByTransactionId',
					12 => 'oKCellOperation',
					13 => 'oKcellSMSNotification',
					14 => 'oMegafonOperation',
					15 => 'oMegafonSMSNotification',
					16 => 'oMobileRefund',
					17 => 'oOberthurOperation',
					18 => 'oSendOtpWriteoff',
					19 => 'oSmppPayment',
					20 => 'oTcellOperation',
					21 => 'oTcellSMSNotification',
					22 => 'oTele2Operation',
					23 => 'oTele2SMSNotification',
					24 => 'oUztelecomOperation',
					25 => 'oUztelecomSMSNotification',
					26 => 'oZetmobileOperation',
					27 => 'oZetmobileSMSNotification',
				),
		),
	'rMerchantSupport' =>
		array(
			'description' => 'Специалист поддержки мерчанта',
			'id' => 1965,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oCancelOperation',
					2 => 'oCreatePaymentsReport',
					3 => 'oEditProfile',
					4 => 'oGetParentInfo',
					5 => 'oGetRemainsToDate',
					6 => 'oGetReturnsCount',
					7 => 'oGetServiceOperationsCount',
					8 => 'oGetSubjectParent',
					9 => 'oMerchantReturn',
					10 => 'oNotifyOwnInvoiceMerchant',
					11 => 'oReportDetailedOperations',
					12 => 'oReportExtendedOperations',
					13 => 'oReportTransfers',
					14 => 'oReturnPartOfOperation',
					15 => 'oReverseOwnTransfer',
					16 => 'oViewParentsOperations',
					17 => 'oViewProfile',
				),
		),
	'rMerchantViewPayment' =>
		array(
			'description' => 'Роль позволяющая просматривать раздел "Поиск платежа" в кабинете партнера',
			'id' => 1932,
			'type' => 2,
			'children' =>
				array(
					0 => 'oMerchantViewPayment',
				),
		),
	'rMfsCabinet' =>
		array(
			'description' => 'Роль для сотрудника отдела МФС',
			'id' => 1717,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMfsCabinet',
					1 => 'oAccessSppCabinet',
					2 => 'oCheckMobileTariff',
					3 => 'oGetAtmStatus',
					4 => 'oGetBalanceOfUser',
					5 => 'oReportCommissions',
					6 => 'oReportDetailedOperations',
					7 => 'oReportJuridicalSubjects',
					8 => 'oReportRegistrations',
					9 => 'oSearchUser',
					10 => 'oViewAllOperations',
					11 => 'oViewDataSpp',
				),
		),
	'rMfsMarketer' =>
		array(
			'description' => 'Маркетолог МФС',
			'id' => 1679,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMfsMarketerCabinet',
					1 => 'oManageMfsNews',
				),
		),
	'rMobileAppAdmin' =>
		array(
			'description' => 'Возможность редактирования summary на уровне ядра',
			'id' => 1923,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBackendAll',
					1 => 'oSummaryManage',
				),
		),
	'rModerator' =>
		array(
			'description' => 'Модератор системы',
			'id' => 12,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oAddCity',
					2 => 'oAddCountry',
					3 => 'oAddService',
					4 => 'oAddServiceGroup',
					5 => 'oAddWalletPromoCoupon',
					6 => 'oBeelinePromoManagement',
					7 => 'oChangeCommissionStatus',
					8 => 'oCloneService',
					9 => 'oCloseCommission',
					10 => 'oConfirmCommission',
					11 => 'oCreateCommission',
					12 => 'oCreateGatewayLimit',
					13 => 'oCreateMerchant',
					14 => 'oDeleteCity',
					15 => 'oDeleteCommission',
					16 => 'oDeleteCountry',
					17 => 'oDeleteGatewayLimit',
					18 => 'oDeleteService',
					19 => 'oDeleteServiceGroup',
					20 => 'oEditLabels',
					21 => 'oEditLotTags',
					22 => 'oEditMerchant',
					23 => 'oEditSynonym',
					24 => 'oEditTags',
					25 => 'oExecuteDream',
					26 => 'oGatewayServices',
					27 => 'oGetCities',
					28 => 'oGetCountries',
					29 => 'oGetCountryCities',
					30 => 'oGetServiceGroups',
					31 => 'oGetServices',
					32 => 'oKcellPromoManagement',
					33 => 'oListCommission',
					34 => 'oLotsModerating',
					35 => 'oLotsParse',
					36 => 'oLotsViewStatNotSend',
					37 => 'oManageRedirections',
					38 => 'oMetaTagsEdit',
					39 => 'oMfsPromoZeroing',
					40 => 'oMobileOperatorManagement',
					41 => 'oMobilePrefixManagement',
					42 => 'oModifyCity',
					43 => 'oModifyCommission',
					44 => 'oModifyCountry',
					45 => 'oModifyService',
					46 => 'oModifyServiceGroup',
					47 => 'oReportCommissions',
					48 => 'oReportFailedLogins',
					49 => 'oReportIdentifications',
					50 => 'oReportMerchants',
					51 => 'oReportPasswordReset',
					52 => 'oReportRegistrations',
					53 => 'oReportTransfers',
					54 => 'oSendRequestToChangeGatewayCommission',
					55 => 'oServiceEdit',
					56 => 'oServicesBanner',
					57 => 'oSetOperatorToNumber',
					58 => 'oShopEdit',
					59 => 'oShopsDelivery',
					60 => 'oTextPagesAdd',
					61 => 'oTextPagesDelete',
					62 => 'oTextPagesEdit',
					63 => 'oUpdateGatewayLimit',
					64 => 'oViewAllOperations',
					65 => 'oViewBankServicesConfig',
					66 => 'oViewBillingHistory',
					67 => 'oViewModeratingServices',
					68 => 'oViewUserCount',
					69 => 'oWorkWithAvailableServicesForSubject',
				),
		),
	'rMPAdmin' =>
		array(
			'description' => 'Администратор портала Megafon',
			'id' => 1954,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMegafonAdminCabinet',
					1 => 'oCreateGatewayLimit',
					2 => 'oCreateGatewayServiceSynonym',
					3 => 'oCreateMPSupportUser',
					4 => 'oDelayedHistory',
					5 => 'oDeleteGatewayLimit',
					6 => 'oGetParentInfo',
					7 => 'oGetRemainsToDate',
					8 => 'oGetServiceOperationsCount',
					9 => 'oMegafonBlockUser',
					10 => 'oMegafonPasswordReset',
					11 => 'oMegafonUnblockUser',
					12 => 'oReportCommissions',
					13 => 'oReportConfirmedCommissions',
					14 => 'oReportTransfers',
					15 => 'oSendRequestToChangeGatewayCommission',
					16 => 'oUpdateGatewayLimit',
					17 => 'oUpdateGatewayServices',
					18 => 'oViewGatewayAdminMainPage',
					19 => 'oViewGatewayReport',
					20 => 'oViewGatewayServices',
					21 => 'oViewParentsChildrensOperations',
					22 => 'oViewParentsOperations',
					23 => 'oViewRelatedOperations',
				),
		),
	'rMPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала Megafon',
			'id' => 1955,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMegafonAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
	'rNotifyOwnInvoiceMerchant' =>
		array(
			'description' => 'Пользователь с правом на повторное уведомление по своему инвойсу',
			'id' => 1822,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNotifyOwnInvoiceMerchant',
				),
		),
	'rNotifyOwnWithdrawalAgent' =>
		array(
			'description' => 'Пользователь с правом на повторное уведомление по своему карточному выводу',
			'id' => 2013,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNotifyWithdrawalAgent',
				),
		),
	'rOperatorMT100' =>
		array(
			'description' => 'Оператор МТ100',
			'id' => 277,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGenerateMT100',
					1 => 'oGetCurrencies',
					2 => 'oReportMerchants',
					3 => 'oReportMoneyRedemption',
				),
		),
	'rOperatorSPP' =>
		array(
			'description' => 'Оператор службы поддержки',
			'id' => 121,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oAccessSppCabinet',
					2 => 'oAddConversion',
					3 => 'oBankControl',
					4 => 'oChangeStatus',
					5 => 'oCheckMobileTariff',
					6 => 'oCheckNetbetOperation',
					7 => 'oCheckOperationStatus',
					8 => 'oCheckPayments',
					9 => 'oFaqManagement',
					10 => 'oGetAtmStatus',
					11 => 'oGetBalanceOfAnyUser',
					12 => 'oGetBalanceOfUser',
					13 => 'oGetCardOperationInfo',
					14 => 'oGetSubjectSocialLinks',
					15 => 'oJuridicalSubjectPasswordChange',
					16 => 'oMapMarkerEdit',
					17 => 'oNominateUser',
					18 => 'oNotifyInvoiceMerchant',
					19 => 'oNotifyWithdrawalAgent',
					20 => 'oOnlineConsultant',
					21 => 'oOtherPasswordReset',
					22 => 'oPasswordChangeReportForAnyUser',
					23 => 'oPasswordResetAnyUser',
					24 => 'oReportACBReturn',
					25 => 'oReportAccountManagerMerchants',
					26 => 'oReportAccountManagerPeriod',
					27 => 'oReportAccounts',
					28 => 'oReportBirthday',
					29 => 'oReportBlockedUsers',
					30 => 'oReportBlocking',
					31 => 'oReportCommissions',
					32 => 'oReportFailedLogins',
					33 => 'oReportJuridicalSubjects',
					34 => 'oReportRegistrations',
					35 => 'oReportStatusChange',
					36 => 'oResetPasswordRecoveryAttempts',
					37 => 'oSearchUser',
					38 => 'oSetMT100Approved',
					39 => 'oTemporarilyDisableService',
					40 => 'oUnblockIP',
					41 => 'oUserRating',
					42 => 'oViewAllOperations',
					43 => 'oViewBillingHistory',
					44 => 'oViewDataSpp',
					45 => 'tViewLogs',
				),
		),
	'rPaasManager' =>
		array(
			'description' => 'Роль для управления уведомлениями Paas(HD-57623)',
			'id' => 2009,
			'type' => 2,
			'children' =>
				array(
					0 => 'oPaasBalanceNotificationAdministration',
				),
		),
	'rPartnerAuditor' =>
		array(
			'description' => 'Партнёр с правом просмотра акта сверки',
			'id' => 1353,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetDischargeAmount',
					1 => 'oGetRemainsToDate',
					2 => 'oReportReconciliation',
				),
		),
	'rPartnerDeveloper' =>
		array(
			'description' => 'Разработчик - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сотрудниками и статистики',
			'id' => 1609,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMerchantAdminCabinet',
					1 => 'oCreatePaymentsReport',
					2 => 'oEditProfile',
					3 => 'oGetSubjectParent',
					4 => 'oMerchantSiteManagement',
					5 => 'oReportDetailedOperations',
					6 => 'oReportTransfers',
					7 => 'oViewParentsChildrensOperations',
					8 => 'oViewParentsOperations',
					9 => 'oViewProfile',
				),
		),
	'rPartnerManager' =>
		array(
			'description' => 'Менеджер - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сайтами и сотрудниками',
			'id' => 1608,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMerchantAdminCabinet',
					1 => 'oCreatePaymentsReport',
					2 => 'oEditProfile',
					3 => 'oGetParentInfo',
					4 => 'oGetSubjectParent',
					5 => 'oMobileRefund',
					6 => 'oReportDetailedOperations',
					7 => 'oReportTransfers',
					8 => 'oReturnPartOfOperation',
					9 => 'oReverseTransfer',
					10 => 'oViewParentsChildrensOperations',
					11 => 'oViewParentsOperations',
					12 => 'oViewPartnerStatistic',
					13 => 'oViewProfile',
					14 => 'oWorkWithParentOperations',
				),
		),
	'rPartnerOperator' =>
		array(
			'description' => 'Оператор - дочерний субъект партнера. Пользуется его кабинетом. Имеет доступ ко всем функциям, кроме управления сотрудниками, сайтами и статистики.',
			'id' => 1610,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessMerchantAdminCabinet',
					1 => 'oCreatePaymentsReport',
					2 => 'oEditProfile',
					3 => 'oGetSubjectParent',
					4 => 'oReportDetailedOperations',
					5 => 'oReportTransfers',
					6 => 'oViewParentsChildrensOperations',
					7 => 'oViewParentsOperations',
					8 => 'oViewProfile',
				),
		),
	'rPartnerUnknownUser' =>
		array(
			'description' => 'Неидентифицированный пользователь партнера',
			'id' => 1697,
			'type' => 2,
			'children' =>
				array(
					0 => 'oRemovePrefixFromLogin',
				),
		),
	'rPaymentToParent' =>
		array(
			'description' => 'Оплата родителю',
			'id' => 799,
			'type' => 2,
			'children' =>
				array(
					0 => 'oPaymentOnParentAccount',
					1 => 'oViewParentsOperations',
				),
		),
	'rPremerchant' =>
		array(
			'description' => 'Пре-мерчант',
			'id' => 1739,
			'type' => 2,
		),
	'rPseudoUser' =>
		array(
			'description' => 'Для прямого платежа с карты',
			'id' => 736,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBabilonOperation',
					1 => 'oBeelineUzOperation',
					2 => 'oCancelOperation',
					3 => 'oChangeOperationsPaymentAccount',
					4 => 'oCheckHasEpayPercent0',
					5 => 'oConfirmOperation',
					6 => 'oCreateOperationWithSpecialist',
					7 => 'oKCellOperation',
					8 => 'oLinkOperationToSpecialistAndMerchant',
					9 => 'oMegafonOperation',
					10 => 'oOberthurOperation',
					11 => 'oPaymentSend',
					12 => 'oPseudoUserOperations',
					13 => 'oRegisterAddresslessTransferUser',
					14 => 'oRemovePrefixFromLogin',
					15 => 'oReportTransfers',
					16 => 'oTcellOperation',
					17 => 'oTele2Operation',
					18 => 'oTransferReceive',
					19 => 'oTransferSend',
					20 => 'oUserInOperationByPhone',
					21 => 'oUztelecomOperation',
					22 => 'oViewServices',
					23 => 'oZetmobileOperation',
				),
		),
	'rPseudoUserCreator' =>
		array(
			'description' => 'Роль для создания псевдо пользователей',
			'id' => 1701,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreatePseudoUser',
				),
		),
	'rPseudoUserWithCards' =>
		array(
			'description' => 'Для прямого платежа с привязанной карты',
			'id' => 1507,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetLinkedCardList',
				),
		),
	'rQASpecialist' =>
		array(
			'description' => 'Специалист QA',
			'id' => 1895,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oAccessSppCabinet',
					2 => 'oCheckMobileTariff',
					3 => 'oCheckNetbetOperation',
					4 => 'oCheckPayments',
					5 => 'oGetCardOperationInfo',
					6 => 'oReportCommissions',
					7 => 'oReportRegistrations',
					8 => 'oSearchUser',
					9 => 'oViewAllOperations',
					10 => 'oViewBillingHistory',
					11 => 'oViewDataSpp',
					12 => 'oViewService',
				),
		),
	'rRbacManager' =>
		array(
			'description' => 'Роль для тех. пользователя, который обновляет RBAC',
			'id' => 2010,
			'type' => 2,
			'children' =>
				array(
					0 => 'oRbacManage',
				),
		),
	'rRegisterPremerchant' =>
		array(
			'description' => 'Роль для создания пре-мерчантов ',
			'id' => 1741,
			'type' => 2,
			'children' =>
				array(
					0 => 'oRegisterPremerchant',
				),
		),
	'rReportExtendedOperations' =>
		array(
			'description' => 'Роль с правом oReportExtendedOperations для использования отчетов ClickHouse ',
			'id' => 1992,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportExtendedOperations',
				),
		),
	'rResmiAddresslessTransferUser' =>
		array(
			'description' => 'Пользователь resmi, на которого проводится безадресный перевод',
			'id' => 1418,
			'type' => 2,
			'children' =>
				array(
					0 => 'oConfirmOperationWithSpecialist',
					1 => 'oCreateOperationWithSpecialist',
				),
		),
	'rResmiAdmin' =>
		array(
			'description' => 'Администратор Resmi',
			'id' => 1416,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessResmiAdminCabinet',
					1 => 'oAddEventParticipant',
					2 => 'oAddEventParticipants',
					3 => 'oAddEventService',
					4 => 'oAddEventSubjectType',
					5 => 'oCreateEvent',
					6 => 'oCreateEventCashback',
					7 => 'oCreateGatewayLimit',
					8 => 'oCreateGatewayServiceSynonym',
					9 => 'oCreateResmiSupportUser',
					10 => 'oDeleteEvent',
					11 => 'oDeleteEventCashback',
					12 => 'oDeleteEventParticipants',
					13 => 'oDeleteEventServices',
					14 => 'oDeleteEventSubjectTypes',
					15 => 'oDeleteGatewayLimit',
					16 => 'oGetEventParticipants',
					17 => 'oGetEventServices',
					18 => 'oGetEventSubjectTypes',
					19 => 'oGetParentInfo',
					20 => 'oGetRemainsToDate',
					21 => 'oGetServiceOperationsCount',
					22 => 'oRegisterUser',
					23 => 'oReportCommissions',
					24 => 'oReportConfirmedCommissions',
					25 => 'oReportEventCashback',
					26 => 'oReportEvents',
					27 => 'oReportTransfers',
					28 => 'oResmiBlockUser',
					29 => 'oResmiPasswordReset',
					30 => 'oResmiUnblockUser',
					31 => 'oSendRequestToChangeGatewayCommission',
					32 => 'oUpdateGatewayLimit',
					33 => 'oUpdateGatewayServices',
					34 => 'oViewGatewayAdminMainPage',
					35 => 'oViewGatewayReport',
					36 => 'oViewGatewayServices',
					37 => 'oViewParentsChildrensOperations',
					38 => 'oViewParentsOperations',
				),
		),
	'rResmiMarketolog' =>
		array(
			'description' => 'Кабинет маркетолога для ресми',
			'id' => 1431,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessResmiMarketologCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetServicesBySystem',
					3 => 'oGetServicesWithPayments',
					4 => 'oReportMarketerInfo',
					5 => 'oSendDirectMail',
				),
		),
	'rResmiPseudoUser' =>
		array(
			'description' => 'Пользователь resmi для прямого платежа с карты',
			'id' => 1417,
			'type' => 2,
			'children' =>
				array(
					0 => 'oConfirmOperationWithSpecialist',
					1 => 'oCreateOperationWithSpecialist',
				),
		),
	'rResmiSPPAdmin' =>
		array(
			'description' => 'Администратор службы поддержи пользователей Resmi',
			'id' => 1384,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessResmiSppCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetCardOperationInfo',
					3 => 'oReportAccounts',
					4 => 'oReportBlockedUsers',
					5 => 'oReportBlocking',
					6 => 'oReportFailedLogins',
					7 => 'oReportIdentifications',
					8 => 'oReportMoneyRedemption',
					9 => 'oReportPasswordReset',
					10 => 'oReportRegistrations',
					11 => 'oReportSessions',
					12 => 'oViewAllOperations',
					13 => 'oViewDataSpp',
				),
		),
	'rResmiSupportUser' =>
		array(
			'description' => 'Сотрудник СПП Resmi',
			'id' => 1415,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessResmiSppCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportTransfers',
					4 => 'oViewGatewayAdminMainPage',
					5 => 'oViewGatewayReportForSupportUser',
					6 => 'oViewParentsOperations',
				),
		),
	'rResmiUnknownUser' =>
		array(
			'description' => 'Неидентифицированный пользователь resmi',
			'id' => 1405,
			'type' => 2,
			'children' =>
				array(
					0 => 'oConfirmOperationWithSpecialist',
					1 => 'oCreateOperationWithSpecialist',
					2 => 'oGetMobileOperator',
					3 => 'oRemovePrefixFromLogin',
					4 => 'oViewAccountsAggregator',
				),
		),
	'rResmiUser' =>
		array(
			'description' => 'Пользователь Resmi',
			'id' => 1572,
			'type' => 2,
			'children' =>
				array(
					0 => 'oConfirmOperationWithSpecialist',
					1 => 'oCreateOperationWithSpecialist',
				),
		),
	'rReverseOwnTransfer' =>
		array(
			'description' => 'Роль с возможностью сторнирования своего перевода (платежа)',
			'id' => 1871,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReverseOwnTransfer',
				),
		),
	'rSchoolkid' =>
		array(
			'description' => 'Школоло',
			'id' => 535,
			'type' => 2,
			'children' =>
				array(
					0 => 'oPaymentSend',
					1 => 'oTransferReceive',
					2 => 'oTransferSend',
				),
		),
	'rSecurityOfficer' =>
		array(
			'description' => 'Сотрудник отдела ИБ',
			'id' => 545,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBlockIP',
					1 => 'oBlockPayment',
					2 => 'oCloseSubject',
					3 => 'oGetAllCardList',
					4 => 'oGetBalanceOfAnyUser',
					5 => 'oGetCardList',
					6 => 'oGetIpWhitelist',
					7 => 'oGetSubjectType',
					8 => 'oPasswordResetAnyUser',
					9 => 'oReportAccounts',
					10 => 'oReportBirthday',
					11 => 'oReportBlockedUsers',
					12 => 'oReportFailedLogins',
					13 => 'oReportRegistrations',
					14 => 'oReportStatusChange',
					15 => 'oSetIpWhitelist',
					16 => 'oSetIpWhitelistAny',
					17 => 'oSetIpWhitelistSelf',
					18 => 'oSetOtpSecret',
					19 => 'oSetOtpSecretAny',
					20 => 'oSetOtpSecretSelf',
					21 => 'oSystemBlockUser',
					22 => 'oSystemUnblockUser',
					23 => 'oUnblockIP',
					24 => 'oViewAllOperations',
					25 => 'oViewDataSpp',
					26 => 'oWorkWithBWListCard',
				),
		),
	'rServiceByParent' =>
		array(
			'description' => 'Доступность сервиса по родителю',
			'id' => 1592,
			'type' => 2,
			'children' =>
				array(
					0 => 'oUseParentServices',
				),
		),
	'rServiceChecker' =>
		array(
			'description' => 'Пользователь для проверки доступности сервисов',
			'id' => 1589,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSkipPendingOperations',
				),
		),
	'rSetIdentificationStatusToSubject' =>
		array(
			'description' => 'Роль для установления статуса идентификации юр субъектам',
			'id' => 1980,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSetIdentificationStatusToSubject',
				),
		),
	'rSetOperationWaiting' =>
		array(
			'description' => 'Пользователь с возможностью перевода операции на 19 статус',
			'id' => 1776,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSetOperationWaiting',
				),
		),
	'rSkipLogs' =>
		array(
			'bizRule' => '',
			'description' => 'Не логировать пользователя',
			'id' => 1351,
			'type' => 2,
			'children' =>
				array(
					0 => 'oStealthForLogs',
				),
		),
	'rStatisticsModerator' =>
		array(
			'description' => 'Модератор статистики',
			'id' => 450,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCorrectStatisticsData',
					1 => 'oModeratingComment',
					2 => 'oSetPlannedIndicators',
					3 => 'oViewAllStatisticsReports',
					4 => 'rMarketolog',
				),
		),
	'rSubAgent' =>
		array(
			'description' => 'Субагент (читай терминал)',
			'id' => 7,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oAccessSubAgentCabinet',
					2 => 'oCancelOperation',
					3 => 'oCompleteWithdrawal',
					4 => 'oConfirmOperation',
					5 => 'oEditProfile',
					6 => 'oEditSecuritySettings',
					7 => 'oGetCardOperationInfo',
					8 => 'oGetCreditAmount',
					9 => 'oGetIdentifiedStatus',
					10 => 'oGetOwnStorningOperations',
					11 => 'oGetRemainsToDate',
					12 => 'oGetReturnsCount',
					13 => 'oGetServiceOperationsCount',
					14 => 'oPaymentReceive',
					15 => 'oPaymentSend',
					16 => 'oRegisterAddresslessTransferUser',
					17 => 'oReportAgentReverts',
					18 => 'oReportCreditOperations',
					19 => 'oReportDetailedOperations',
					20 => 'oReportTransfers',
					21 => 'oTransferReceive',
					22 => 'oTransferSend',
					23 => 'oTransferSubagent',
					24 => 'oUnlimitedTransfer',
					25 => 'oViewAgentCommissions',
				),
		),
	'rSubAgentAccountant' =>
		array(
			'description' => 'Роль для бухгалтера субагента, позволяет получать баланс, сальдо, сводный отчёт по платежам. Скрывает меню Выплаты и История ',
			'id' => 1835,
			'type' => 2,
			'children' =>
				array(
					0 => 'oDoNotShowHistoryAccMenu',
					1 => 'oDoNotShowPayoutsAccMenu',
					2 => 'oGetCreditBalanceToDate',
					3 => 'oGetSubjectParent',
					4 => 'oGetSummaryReport',
				),
		),
	'rSubagentAdmin' =>
		array(
			'description' => ' Субагент с правами администрирования своего портала',
			'id' => 1699,
			'type' => 2,
			'children' =>
				array(
					0 => 'oSendRequestToChangeGatewayCommission',
					1 => 'oUpdateGatewayServices',
					2 => 'oViewGatewayServices',
				),
		),
	'rSubagentAuditor' =>
		array(
			'description' => 'субагент с правом просматривать реестр по кошельку',
			'id' => 1357,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetRemainsToDate',
					1 => 'oReportSubagentConsolidated',
				),
		),
	'rSubAgentCabinetWithdrawal' =>
		array(
			'description' => 'Субагент c правом вывода на карту и БС через кабинет',
			'id' => 1825,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewWithdrawalToBankAccMenu',
					1 => 'oViewWithdrawalToCardAccMenu',
				),
		),
	'rSubagentChangePaymentService' =>
		array(
			'description' => 'Субагент сервис прямого платеж которого может быть изменен в зависимости от psp_tid',
			'id' => 1870,
			'type' => 2,
			'children' =>
				array(
					0 => 'oChangePaymentService',
				),
		),
	'rSubAgentForApplePay' =>
		array(
			'description' => 'Субагент для Apple Pay',
			'id' => 1702,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationApplePay',
				),
		),
	'rSubAgentForBonuses' =>
		array(
			'description' => 'Субагент для конвертации бонусов',
			'id' => 1763,
			'type' => 2,
			'children' =>
				array(
					0 => 'oManageReferralProgram',
					1 => 'oTransferBonusBalance',
				),
		),
	'rSubAgentForGooglePay' =>
		array(
			'description' => 'Субагент для Google Pay',
			'id' => 1884,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationGooglePay',
				),
		),
	'rSubAgentForIdentifiedPseudoUser' =>
		array(
			'description' => 'Субагент для оплаты услуг от имени идентифицированных псевдо-пользователей',
			'id' => 1743,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateIdentifiedPseudoUser',
				),
		),
	'rSubAgentForLinkedCard' =>
		array(
			'description' => 'Субагент для привязанных карт',
			'id' => 1332,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationLinkedCard',
				),
		),
	'rSubAgentForNominatedPseudoUser' =>
		array(
			'description' => 'Субагент для оплаты услуг от имени упрощенно идентифицированных псевдо-пользователей',
			'id' => 1737,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateNominatedPseudoUser',
				),
		),
	'rSubAgentForPseudoUser' =>
		array(
			'description' => 'Субагент для оплаты услуг от имени псевдо-пользователей',
			'id' => 1333,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateOperationForPseudoUser',
					1 => 'oReturnPartOfOperation',
					2 => 'oReverseOwnTransfer',
				),
		),
	'rSubAgentForUser' =>
		array(
			'description' => 'Субагент для оплаты услуг от имени пользователей',
			'id' => 1688,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptBonusOfferAgreementForUser',
					1 => 'oBlockSubjectForUser',
					2 => 'oCloseOwnUsers',
					3 => 'oConfirmOperationForUser',
					4 => 'oCreateOperationForUser',
					5 => 'oCreateOperationWithSpecialist',
					6 => 'oCreateUser',
					7 => 'oGetBalanceOfUser',
					8 => 'oGetLinkedCardList',
					9 => 'oManageCardsForUser',
					10 => 'oManageReferralProgramForUser',
					11 => 'oPartnerBlockUser',
					12 => 'oPartnerUnblockUser',
					13 => 'oRegisterOwnUsers',
					14 => 'oRegisterUser',
					15 => 'oReturnPartOfOperation',
					16 => 'oReverseOwnTransfer',
					17 => 'oSetSpendingPriorityForUser',
					18 => 'oUserBlockUser',
					19 => 'oUserUnblockUser',
					20 => 'oViewOperationsOfUser',
					21 => 'oWithdrawalOther',
				),
		),
	'rSubagentFullCheckNominator' =>
		array(
			'description' => 'Субагент с правом перевода неидентифицированных пользователей в именные (с фоновой полной идентификацией)',
			'id' => 1780,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNominateUserFullCheck',
				),
		),
	'rSubagentIdentifier' =>
		array(
			'description' => 'Субагент с правом идентификации пользователей',
			'id' => 1774,
			'type' => 2,
			'children' =>
				array(
					0 => 'oIdentifyUser',
				),
		),
	'rSubAgentIndividualReplenishment' =>
		array(
			'description' => 'Роль позволяющая делать платежи внутри кабинета субагента ',
			'id' => 1828,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewIndividualReplenishment',
				),
		),
	'rSubAgentMobileWithdrawal' =>
		array(
			'description' => 'Роль позволяющая делать выводы на баланс мобильного оператора с кабинета субагента',
			'id' => 1829,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewMobileWithdrawal',
				),
		),
	'rSubagentNominator' =>
		array(
			'description' => 'Субагент с правом перевода неидентифицированных пользователей в именные',
			'id' => 1575,
			'type' => 2,
			'children' =>
				array(
					0 => 'oNominateUser',
				),
		),
	'rSubAgentOperator' =>
		array(
			'description' => 'Оператор субагента',
			'id' => 1361,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oGetParentInfo',
					2 => 'oGetRemainsToDate',
					3 => 'oGetServiceOperationsCount',
					4 => 'oReportAgentReverts',
					5 => 'oReportCreditOperations',
					6 => 'oReportDetailedOperations',
					7 => 'oReportTransfers',
					8 => 'oViewAgentCommissions',
					9 => 'oViewParentsOperations',
					10 => 'oWorkWithParentOperations',
				),
		),
	'rSubAgentPostPaid' =>
		array(
			'description' => 'Субагент, пользующийся агентским счетом',
			'id' => 747,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationWithParentAccount',
				),
		),
	'rSubagentReports' =>
		array(
			'description' => 'Субагент с правом доступа к своим отчетам в partnerCabinet',
			'id' => 1425,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReportMoneyMovement',
					1 => 'oReportSubagentClientReconciliation',
					2 => 'oReportSubagentEMIncomeReconciliation',
					3 => 'oReportSubagentEMSaleReconciliation',
					4 => 'oReportSubagentEMSaleToClientReconciliation',
				),
		),
	'rSubAgentWithAcquiring' =>
		array(
			'description' => 'Субагент с эквайрингом',
			'id' => 716,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationAcquiring',
				),
		),
	'rSubAgentWithCashOut' =>
		array(
			'description' => 'Субагент с возможностью вывода денег с кошелька',
			'id' => 1386,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessPartnerCabinet',
					1 => 'oBabilonOperation',
					2 => 'oBeelineUzOperation',
					3 => 'oBookmakerRefund',
					4 => 'oCancelOperation',
					5 => 'oCompleteWithdrawal',
					6 => 'oConfirmOperation',
					7 => 'oConfirmOperationWithSpecialist',
					8 => 'oCreateOperationWithSpecialist',
					9 => 'oEditProfile',
					10 => 'oEditSecuritySettings',
					11 => 'oGetBalanceOfAnyUser',
					12 => 'oGetRemainsToDate',
					13 => 'oGetReturnsCount',
					14 => 'oGetServiceOperationsCount',
					15 => 'oKCellOperation',
					16 => 'oMegafonOperation',
					17 => 'oMobileRefund',
					18 => 'oOberthurOperation',
					19 => 'oPaymentReceive',
					20 => 'oPaymentSend',
					21 => 'oReportAgentReverts',
					22 => 'oReportDetailedOperations',
					23 => 'oReportTransfers',
					24 => 'oReverseOwnTransfer',
					25 => 'oSmppOperation',
					26 => 'oTcellOperation',
					27 => 'oTele2Operation',
					28 => 'oTransferOtherSend',
					29 => 'oTransferReceive',
					30 => 'oTransferSend',
					31 => 'oUztelecomOperation',
					32 => 'oWithdrawalOther',
					33 => 'oZetmobileOperation',
				),
		),
	'rSubjectCloser' =>
		array(
			'description' => 'Роль для закрытия юр. субъектов',
			'id' => 1601,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCloseSubject',
				),
		),
	'rSubjectStornableSell' =>
		array(
			'description' => 'Субъект, операции продаж которого могут быть сторнированы',
			'id' => 1707,
			'type' => 2,
			'children' =>
				array(
					0 => 'oStornableSell',
				),
		),
	'rSubMerchant' =>
		array(
			'description' => 'Субмерчант',
			'id' => 1403,
			'type' => 2,
			'children' =>
				array(
					0 => 'oCreateInvoice',
					1 => 'oPaymentReceive',
					2 => 'oUseParentInvoice',
				),
		),
	'rT2PAdmin' =>
		array(
			'description' => 'Администратор портала Tele2',
			'id' => 1802,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessTele2AdminCabinet',
					1 => 'oCreateGatewayLimit',
					2 => 'oCreateGatewayServiceSynonym',
					3 => 'oCreateT2PSupportUser',
					4 => 'oDelayedHistory',
					5 => 'oDeleteGatewayLimit',
					6 => 'oGetCardOperationInfo',
					7 => 'oGetParentInfo',
					8 => 'oGetRemainsToDate',
					9 => 'oGetServiceOperationsCount',
					10 => 'oReportCommissions',
					11 => 'oReportConfirmedCommissions',
					12 => 'oReportDetailedOperations',
					13 => 'oReportTransfers',
					14 => 'oSendRequestToChangeGatewayCommission',
					15 => 'oTele2BlockUser',
					16 => 'oTele2PasswordReset',
					17 => 'oTele2UnblockUser',
					18 => 'oUpdateGatewayLimit',
					19 => 'oUpdateGatewayServices',
					20 => 'oViewGatewayAdminMainPage',
					21 => 'oViewGatewayReport',
					22 => 'oViewGatewayReportForSupportUser',
					23 => 'oViewGatewayServices',
					24 => 'oViewParentsChildrensOperations',
					25 => 'oViewParentsOperations',
					26 => 'oViewRelatedOperations',
				),
		),
	'rT2PSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала Tele2',
			'id' => 1803,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessTele2AdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
	'rTcellNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Tcell',
			'id' => 1784,
			'type' => 2,
			'children' =>
				array(
					0 => 'oTcellSMSNotification',
				),
		),
	'rTechManager' =>
		array(
			'description' => 'Еще один технический специалист',
			'id' => 1769,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oCreateAccountBalanceLimit',
					2 => 'oCreateGatewayLimit',
					3 => 'oCreateLimit',
					4 => 'oDeleteAccountBalanceLimit',
					5 => 'oDeleteGatewayLimit',
					6 => 'oDeleteLimit',
					7 => 'oModifyServiceGroupLimit',
					8 => 'oSetMRPAmount',
					9 => 'oUpdateAccountBalanceLimit',
					10 => 'oUpdateGatewayLimit',
				),
		),
	'rTechSpecialist' =>
		array(
			'description' => 'Технический специалист',
			'id' => 191,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oNotifyInvoiceMerchant',
					2 => 'oNotifyWithdrawalAgent',
					3 => 'oReportAccounts',
					4 => 'oReportBirthday',
					5 => 'oReportBlockedUsers',
					6 => 'oReportBlocking',
					7 => 'oReportIdentifications',
					8 => 'oReportPasswordReset',
					9 => 'oReportSessions',
					10 => 'oReportStatusChange',
					11 => 'oUnblockIP',
					12 => 'oViewAllOperations',
					13 => 'oViewDataSpp',
				),
		),
	'rTele2NotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Tele2',
			'id' => 1676,
			'type' => 2,
			'children' =>
				array(
					0 => 'oTele2SMSNotification',
				),
		),
	'rTestTostoviy' =>
		array(
			'description' => 'test dlya proverki CI',
			'id' => 1934,
			'type' => 2,
		),
	'rTextPagesManager' =>
		array(
			'description' => 'Менеджер текстовых страниц',
			'id' => 251,
			'type' => 2,
			'children' =>
				array(
					0 => 'oTextPagesAdd',
					1 => 'oTextPagesDelete',
					2 => 'oTextPagesEdit',
					3 => 'oTextPagesView',
				),
		),
	'rThirdPartyApprover' =>
		array(
			'description' => 'Роль для подтверждения операций третьим лицом',
			'id' => 1669,
			'type' => 2,
			'children' =>
				array(
					0 => 'oThirdPartyConfirmation',
					1 => 'oViewChildrensOperations',
				),
		),
	'rThirdPartyCreator' =>
		array(
			'description' => 'Роль для создания операций с подтверждением третьим лицом',
			'id' => 1654,
			'type' => 2,
			'children' =>
				array(
					0 => 'oOperationWithThirdPartyConfirmation',
				),
		),
	'rTPAdmin' =>
		array(
			'description' => 'Администратор портала Tcell',
			'id' => 1790,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessTcellAdminCabinet',
					1 => 'oCreateGatewayLimit',
					2 => 'oCreateGatewayServiceSynonym',
					3 => 'oCreateTPSupportUser',
					4 => 'oDelayedHistory',
					5 => 'oDeleteGatewayLimit',
					6 => 'oGetParentInfo',
					7 => 'oGetRemainsToDate',
					8 => 'oGetServiceOperationsCount',
					9 => 'oReportCommissions',
					10 => 'oReportConfirmedCommissions',
					11 => 'oReportTransfers',
					12 => 'oSendRequestToChangeGatewayCommission',
					13 => 'oTcellBlockUser',
					14 => 'oTcellPasswordReset',
					15 => 'oTcellUnblockUser',
					16 => 'oUpdateGatewayLimit',
					17 => 'oUpdateGatewayServices',
					18 => 'oViewGatewayAdminMainPage',
					19 => 'oViewGatewayReport',
					20 => 'oViewGatewayServices',
					21 => 'oViewParentsChildrensOperations',
					22 => 'oViewParentsOperations',
					23 => 'oViewRelatedOperations',
				),
		),
	'rTPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала Tcell',
			'id' => 1791,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessTcellAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
	'rUnknownUser' =>
		array(
			'description' => 'Неидентифицированный пользователь',
			'id' => 3,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAcceptTransferRequest',
					1 => 'oCancelOperation',
					2 => 'oChangeOperationsPaymentAccount',
					3 => 'oCheckHasEpayPercent0',
					4 => 'oCommentEvent',
					5 => 'oCommentWrite',
					6 => 'oConfirmOperation',
					7 => 'oCreateWPCard',
					8 => 'oCustomAddService',
					9 => 'oCustomModifyService',
					10 => 'oDelayedPayment',
					11 => 'oDontShowNegativeBalance',
					12 => 'oEditBasket',
					13 => 'oEditDream',
					14 => 'oEditEvent',
					15 => 'oEditFriend',
					16 => 'oEditInterests',
					17 => 'oEditProfile',
					18 => 'oEditSecuritySettings',
					19 => 'oGetBrokerAccountList',
					20 => 'oGetLinkedCardList',
					21 => 'oGroupOperation',
					22 => 'oInviteEvent',
					23 => 'oJoinEvent',
					24 => 'oLinkPromoCodeToSubject',
					25 => 'oNotifyEmptyEmailAddress',
					26 => 'oPasswordReset',
					27 => 'oPayFromWallet',
					28 => 'oPaymentSend',
					29 => 'oRegisterAddresslessTransferUser',
					30 => 'oReportTransfers',
					31 => 'oResponseWrite',
					32 => 'oSetSpendingPriority',
					33 => 'oTransferDream',
					34 => 'oTransferEvent',
					35 => 'oTransferReceive',
					36 => 'oTransferRequestList',
					37 => 'oTransferRequestReceive',
					38 => 'oTransferRequestSend',
					39 => 'oTransferSend',
					40 => 'oViewAccountsAggregator',
					41 => 'oViewBasket',
					42 => 'oViewCompareList',
					43 => 'oViewEvent',
					44 => 'oViewFavoriteList',
					45 => 'oViewFriendList',
					46 => 'oViewMessages',
					47 => 'oViewProfile',
					48 => 'oViewServices',
					49 => 'oViewYaShare',
				),
		),
	'rUpdateOperationByPspTid' =>
		array(
			'description' => 'Роль с возможностью обновления отправителя/специалиста в операции карточного пополнения в зависимости от терминала psp',
			'id' => 1815,
			'type' => 2,
			'children' =>
				array(
					0 => 'oUpdateOperationByPspTid',
				),
		),
	'rUpperOperatorSPP' =>
		array(
			'description' => 'Оператор СПП с квалификацией. Расширяет rOperatorSPP',
			'id' => 1937,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBillingRepayOperation',
					1 => 'oBookmakerRefund',
					2 => 'oBookmakerRefundAny',
					3 => 'oMobileRefund',
					4 => 'oMobileRefundAny',
				),
		),
	'rUser' =>
		array(
			'description' => 'Пользователь',
			'id' => 2,
			'type' => 2,
			'children' =>
				array(
					0 => 'oLinkBankAccount',
					1 => 'rUnknownUser',
				),
		),
	'rUserNotWorksheet' =>
		array(
			'description' => 'Пользователь без анкетных данных',
			'id' => 696,
			'type' => 2,
			'children' =>
				array(
					0 => 'oEmptyProfile',
				),
		),
	'rUsersOperationsVerifier' =>
		array(
			'description' => 'Субъект, проверяющий операции пользователей по своему сервису',
			'id' => 1929,
			'type' => 2,
			'children' =>
				array(
					0 => 'oReverseOperationOfUser',
					1 => 'oViewOperationsOfUser',
				),
		),
	'rUssdAdmin' =>
		array(
			'description' => 'Роль администратора Ussd',
			'id' => 1578,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessAdminPanel',
					1 => 'oUssdView',
				),
		),
	'rUztelecomNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Uztelecom',
			'id' => 1750,
			'type' => 2,
			'children' =>
				array(
					0 => 'oUztelecomSMSNotification',
				),
		),
	'rViewAllOperations' =>
		array(
			'description' => 'Роль, позволяющая видеть все операции',
			'id' => 1685,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewAllOperations',
				),
		),
	'rViewChildrensOperations' =>
		array(
			'description' => 'Роль, позволяющая видеть операций дочерних субъектов',
			'id' => 1705,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewChildrensOperations',
				),
		),
	'rViewParentOperations' =>
		array(
			'description' => 'Роль, позволяющая видеть операции родителя',
			'id' => 1602,
			'type' => 2,
			'children' =>
				array(
					0 => 'oViewParentsOperations',
				),
		),
	'rViewPayment' =>
		array(
			'description' => 'Роль позволяющая просматривать раздел "Поиск платежа" в кабинете партнера',
			'id' => 1931,
			'type' => 2,
		),
	'rVipSub' =>
		array(
			'description' => 'Роль для вип-субъектов',
			'id' => 1615,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGoIntoMinus',
				),
		),
	'rWhiteSubject' =>
		array(
			'description' => 'Роль, которая показывает является ли субъект присутствующим в белом списке',
			'id' => 1706,
			'type' => 2,
			'children' =>
				array(
					0 => 'oWhiteSubjectLimit',
				),
		),
	'rWithdrawalRefunder' =>
		array(
			'description' => 'Пользователь делающий возвраты по отмененным выводам',
			'id' => 1586,
			'type' => 2,
			'children' =>
				array(
					0 => 'oBookmakerRefund',
					1 => 'oBookmakerRefundAny',
					2 => 'oMobileRefund',
					3 => 'oMobileRefundAny',
				),
		),
	'rWPFinanceSpecialist' =>
		array(
			'description' => 'Финансовый специалист Wooppay',
			'id' => 1410,
			'type' => 2,
			'children' =>
				array(
					0 => 'oGetSubjectSiblings',
					1 => 'oGetSubjectType',
					2 => 'oGetSubjectTypes',
					3 => 'oGetSupportFilterData',
					4 => 'oReportFinspec',
					5 => 'oViewAllOperations',
					6 => 'oViewRelatedOperations',
					7 => 'oWooppayFinspecReport',
				),
		),
	'rZetmobileNotificationSender' =>
		array(
			'description' => 'Пользователь с возможностью отправки СМС через шлюз Zet-Mobile',
			'id' => 1847,
			'type' => 2,
			'children' =>
				array(
					0 => 'oZetmobileSMSNotification',
				),
		),
	'rZPAdmin' =>
		array(
			'description' => 'Администратор портала Zet-Mobile',
			'id' => 1862,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessZetmobileAdminCabinet',
					1 => 'oCreateGatewayLimit',
					2 => 'oCreateGatewayServiceSynonym',
					3 => 'oCreateZPSupportUser',
					4 => 'oDelayedHistory',
					5 => 'oDeleteGatewayLimit',
					6 => 'oGetParentInfo',
					7 => 'oGetRemainsToDate',
					8 => 'oGetServiceOperationsCount',
					9 => 'oReportCommissions',
					10 => 'oReportConfirmedCommissions',
					11 => 'oReportTransfers',
					12 => 'oSendRequestToChangeGatewayCommission',
					13 => 'oUpdateGatewayLimit',
					14 => 'oUpdateGatewayServices',
					15 => 'oViewGatewayAdminMainPage',
					16 => 'oViewGatewayReport',
					17 => 'oViewGatewayServices',
					18 => 'oViewParentsChildrensOperations',
					19 => 'oViewParentsOperations',
					20 => 'oViewRelatedOperations',
					21 => 'oZetmobileBlockUser',
					22 => 'oZetmobilePasswordReset',
					23 => 'oZetmobileUnblockUser',
				),
		),
	'rZPSupportUser' =>
		array(
			'description' => 'Сотрудник СПП портала Zet-Mobile',
			'id' => 1863,
			'type' => 2,
			'children' =>
				array(
					0 => 'oAccessZetmobileAdminCabinet',
					1 => 'oDelayedHistory',
					2 => 'oGetRemainsToDate',
					3 => 'oReportMoneyMovement',
					4 => 'oReportTransfers',
					5 => 'oViewGatewayAdminMainPage',
					6 => 'oViewGatewayReport',
					7 => 'oViewGatewayReportForSupportUser',
					8 => 'oViewParentsOperations',
					9 => 'oViewRelatedOperations',
				),
		),
);
