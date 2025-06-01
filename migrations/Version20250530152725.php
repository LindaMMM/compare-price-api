<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530152725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject DROP FOREIGN KEY FK_B1212D68AD9658A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_B1212D684584665A ON apicompare_mediaobject
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_mediaobject DROP Product_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_product ADD media_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_product ADD CONSTRAINT FK_A69F8E7AEA9FDD75 FOREIGN KEY (media_id) REFERENCES ApiCompare_MediaObject (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A69F8E7AEA9FDD75 ON apicompare_product (media_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product DROP FOREIGN KEY FK_A69F8E7AEA9FDD75
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_A69F8E7AEA9FDD75 ON ApiCompare_Product
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product DROP media_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject ADD Product_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_MediaObject ADD CONSTRAINT FK_B1212D68AD9658A FOREIGN KEY (Product_id) REFERENCES apicompare_product (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B1212D684584665A ON ApiCompare_MediaObject (Product_id)
        SQL);
    }
}
