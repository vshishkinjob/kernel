<?php

namespace Kernel\Entities\User\Tps;

use DateTime;
use Kernel\Components\Repository\Components\BaseEntity;
use Kernel\Components\Repository\Components\Tps\Annotation\TpsColumn;
use Kernel\Enums\User\SubjectStatus;
use Kernel\Enums\User\SubjectType;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\Ip;

/**
 * @infection-ignore-all
 */
class SubjectData extends BaseEntity
{
    public function __construct(
        private string $login,
        #[TpsColumn(name: ['id', 'subject_id'])]
        private int $id,
        #[TpsColumn(name: 'parent_id')]
        private ?int $parentId = null,
        #[TpsColumn(name: 'subject_last_name')]
        private ?string $subjectLastName = null,
        #[TpsColumn(name: 'subject_first_name')]
        private ?string $subjectFirstName = null,
        #[TpsColumn(name: 'subject_middle_name')]
        private ?string $subjectMiddleName = null,
        #[TpsColumn(name: 'parent_login')]
        private ?string $parentLogin = null,
        #[TpsColumn(name: ['subject_type', 'id_typesub'], type: SubjectType::class)]
        private ?SubjectType $subjectType = null,
        #[TpsColumn(name: ['creation_date', 'date_create'], type: DateTime::class)]
        private ?DateTime $creationDate = null,
        private ?string $sex = null,
        #[TpsColumn(name: 'birth_date')]
        private ?string $birthDate = null,
        private ?int $region = null,
        #[TpsColumn(name:['country', 'id_country'])]
        private ?int $country = null,
        #[TpsColumn(name: 'email', type: Email::class)]
        private ?Email $email = null,
        #[TpsColumn(name: 'report_email')]
        private ?string $reportEmail = null,
        private ?string $iin = null,
        #[TpsColumn(name: 'iin_fixed')]
        private ?bool $iinFixed = null,
        #[TpsColumn(name: 'juridical_name')]
        private ?string $juridicalName = null,
        /** @var array<string, float>|null $balance */
        private ?array $balance = null,
        /** @var list<string>|null $roles */
        private ?array $roles = null,
		#[TpsColumn(name: 'authToken')]
        private ?string $token = null,
        #[TpsColumn(name: 'document_date')]
        private ?string $documentDate = null,
        #[TpsColumn(name: 'responsible_person')]
        private ?string $responsiblePerson = null,
        private ?int $approvedMT100 = null,
        private ?int $identified = null,
        #[TpsColumn(name: 'resident_kz')]
        private ?bool $residentKz = null,
        #[TpsColumn(name: 'status', type: SubjectStatus::class)]
        private ?SubjectStatus $status = null,
        #[TpsColumn(name: 'last_auth', type: DateTime::class)]
        private ?DateTime $lastAuth = null,
        #[TpsColumn(name: 'last_ip', type: Ip::class)]
        private ?Ip $lastIp = null,
    ) {
    }

    public function getLastAuth(): ?DateTime
    {
        return $this->lastAuth;
    }

    public function getLastIp(): ?Ip
    {
        return $this->lastIp;
    }

    /**
     * @return SubjectStatus|null
     */
    public function getStatus(): ?SubjectStatus
    {
        return $this->status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @return string|null
     */
    public function getSubjectLastName(): ?string
    {
        return $this->subjectLastName;
    }

    /**
     * @return string|null
     */
    public function getSubjectFirstName(): ?string
    {
        return $this->subjectFirstName;
    }

    /**
     * @return string|null
     */
    public function getSubjectMiddleName(): ?string
    {
        return $this->subjectMiddleName;
    }

    /** @psalm-mutation-free */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string|null
     */
    public function getParentLogin(): ?string
    {
        return $this->parentLogin;
    }

    public function getSubjectType(): ?SubjectType
    {
        return $this->subjectType;
    }

    /**
     * @return DateTime|null
     */
    public function getCreationDate(): ?DateTime
    {
        return $this->creationDate;
    }

    /**
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @return int|null
     */
    public function getRegion(): ?int
    {
        return $this->region;
    }

    /**
     * @return int|null
     */
    public function getCountry(): ?int
    {
        return $this->country;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getReportEmail(): ?string
    {
        return $this->reportEmail;
    }

    /**
     * @return string|null
     */
    public function getIin(): ?string
    {
        return $this->iin;
    }

    /**
     * @return bool|null
     */
    public function getIinFixed(): ?bool
    {
        return $this->iinFixed;
    }

    /**
     * @return string|null
     */
    public function getJuridicalName(): ?string
    {
        return $this->juridicalName;
    }

    /**
     * @return mixed[]|null
     */
    public function getBalance(): ?array
    {
        return $this->balance;
    }

    /**
     * @return string[]|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @return string|null
     */
    public function getAuthToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getDocumentDate(): ?string
    {
        return $this->documentDate;
    }

    /**
     * @return string|null
     */
    public function getResponsiblePerson(): ?string
    {
        return $this->responsiblePerson;
    }

    /**
     * @return int|null
     */
    public function getApprovedMT100(): ?int
    {
        return $this->approvedMT100;
    }

    /**
     * @return int|null
     */
    public function getIdentified(): ?int
    {
        return $this->identified;
    }

    /**
     * @return bool|null
     */
    public function getResidentKz(): ?bool
    {
        return $this->residentKz;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
