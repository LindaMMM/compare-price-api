<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529165903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject CHANGE Name title VARCHAR(50) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject RENAME INDEX uniq_b1212d68ad9658a TO UNIQ_B1212D684584665A
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject CHANGE title Name VARCHAR(50) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject RENAME INDEX uniq_b1212d684584665a TO UNIQ_B1212D68AD9658A
        SQL);
    }
}
