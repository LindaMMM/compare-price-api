<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507161814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ensign (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, brand_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, search JSON NOT NULL, ref_product VARCHAR(255) NOT NULL, media VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, ensign_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, label VARCHAR(50) NOT NULL, price VARCHAR(255) NOT NULL, stock VARCHAR(255) NOT NULL, INDEX IDX_46D8ACCC12469DE2 (category_id), INDEX IDX_46D8ACCCAE0CC1A7 (ensign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statement (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, dateinput DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, valid TINYINT(1) NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_C0DB51764584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, frequency VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_category (task_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_468CF38D8DB60186 (task_id), INDEX IDX_468CF38D12469DE2 (category_id), PRIMARY KEY(task_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCC12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCCAE0CC1A7 FOREIGN KEY (ensign_id) REFERENCES ensign (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE statement ADD CONSTRAINT FK_C0DB51764584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCCAE0CC1A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE statement DROP FOREIGN KEY FK_C0DB51764584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category DROP FOREIGN KEY FK_468CF38D8DB60186
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category DROP FOREIGN KEY FK_468CF38D12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brand
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ensign
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE refresh_tokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rule
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE statement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
    }
}
