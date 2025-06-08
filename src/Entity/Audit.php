<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[MappedSuperclass]
#[HasLifecycleCallbacks]
class Audit
{
    #[Groups(['read:Audit'])]
    #[Column(type: Types::DATE_MUTABLE, name: 'DAT_CRT')]
    protected ?\DateTime  $createdAt = null;

    #[Groups(['read:Audit'])]
    #[Column(type: Types::STRING, name: 'USR_CRT')]
    protected ?string $userCreate;

    #[Groups(['read:Audit'])]
    #[Column(type: Types::DATE_MUTABLE, name: 'DAT_UPD')]
    protected ?\DateTime  $dateUpdate = null;

    #[Groups(['read:Audit'])]
    #[Column(type: Types::STRING, name: 'USR_UPD')]
    protected ?string $userUpdate;

    public function __construct() {}

    #[ORM\PrePersist]
    public function setCreatedAtValue(PrePersistEventArgs $eventArgs): void
    {
        $this->createdAt = new \DateTime();
        $this->dateUpdate = new \DateTime();
        $this->userCreate = "USER_AUDIT";
        $this->userUpdate = "USER_AUDIT";
    }

    #[ORM\PreUpdate]
    public function setUpdateAtValue(PreUpdateEventArgs $eventArgs): void
    {
        $this->dateUpdate = new \DateTime();
        $this->userUpdate = "USER_AUDIT";
    }
}
