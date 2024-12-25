<?php

namespace Kernel\Enums\User;

enum SubjectPrefix: string
{
	case BABILON = "L";
	case BEELINE = "B";
	case BEELINE_UZ = "E";
	case KCELL = "K";
	case MEGAFON = "F";
	case TCELL = "C";
	case TELE2 = "T";
	case UZTELECOM = "U";
	case ZETMOBILE = "O";
	case ADDRESSLESS = "\$";
	case IDENTIFIED_PSEUDO_BY_AGENT = "I";
	case NOMINATED_PSEUDO_BY_AGENT = "N";
	case PSEUDO = "Z";
	case PSEUDO_SOCIAL = "S";
	case PSEUDO_WITH_CARDS = "G";
	case RESMI_ADDRESSLESS = "\$R";
	case RESMI_PSEUDO = "ZR";
	case UNIDENT_PSEUDO_BY_AGENT = "M";
	case WITHDRAWAL = "W";
	case RESMI = "R";

    /**
     * @return list<value-of<self::*>>
     */
    public static function getValuesAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
