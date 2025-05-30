<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529164359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject ADD Name VARCHAR(50) NOT NULL, ADD Product_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject ADD CONSTRAINT FK_B1212D68AD9658A FOREIGN KEY (Product_id) REFERENCES ApiCompare_Product (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B1212D68AD9658A ON apicompare_mediaobject (Product_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject DROP FOREIGN KEY FK_B1212D68AD9658A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_B1212D68AD9658A ON ApiCompare_MediaObject
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject DROP Name, DROP Product_id
        SQL);
    }
}
