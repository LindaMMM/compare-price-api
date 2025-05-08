<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508190450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Brand (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Category (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Ensign (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, Name VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, brand_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, search JSON NOT NULL, ref_product VARCHAR(255) NOT NULL, media VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_A69F8E7A12469DE2 (category_id), INDEX IDX_A69F8E7A44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Rule (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, ensign_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, label VARCHAR(50) NOT NULL, price VARCHAR(255) NOT NULL, stock VARCHAR(255) NOT NULL, INDEX IDX_D5D3F05012469DE2 (category_id), INDEX IDX_D5D3F050AE0CC1A7 (ensign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Statement (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, dateinput DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, valid TINYINT(1) NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_3CF1D454584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ApiCompare_Task (id INT AUTO_INCREMENT NOT NULL, DAT_CRT DATE NOT NULL, USR_CRT VARCHAR(255) NOT NULL, DAT_UPD DATE NOT NULL, USR_UPD VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, frequency VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE apicompare_task_apicompare_category (apicompare_task_id INT NOT NULL, apicompare_category_id INT NOT NULL, INDEX IDX_509F3D0E25D3463 (apicompare_task_id), INDEX IDX_509F3D0B1C05D7D (apicompare_category_id), PRIMARY KEY(apicompare_task_id, apicompare_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product ADD CONSTRAINT FK_A69F8E7A12469DE2 FOREIGN KEY (category_id) REFERENCES ApiCompare_Category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product ADD CONSTRAINT FK_A69F8E7A44F5D008 FOREIGN KEY (brand_id) REFERENCES ApiCompare_Brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Rule ADD CONSTRAINT FK_D5D3F05012469DE2 FOREIGN KEY (category_id) REFERENCES ApiCompare_Category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Rule ADD CONSTRAINT FK_D5D3F050AE0CC1A7 FOREIGN KEY (ensign_id) REFERENCES ApiCompare_Ensign (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Statement ADD CONSTRAINT FK_3CF1D454584665A FOREIGN KEY (product_id) REFERENCES ApiCompare_Product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_task_apicompare_category ADD CONSTRAINT FK_509F3D0E25D3463 FOREIGN KEY (apicompare_task_id) REFERENCES ApiCompare_Task (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_task_apicompare_category ADD CONSTRAINT FK_509F3D0B1C05D7D FOREIGN KEY (apicompare_category_id) REFERENCES ApiCompare_Category (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product DROP FOREIGN KEY FK_A69F8E7A12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Product DROP FOREIGN KEY FK_A69F8E7A44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Rule DROP FOREIGN KEY FK_D5D3F05012469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Rule DROP FOREIGN KEY FK_D5D3F050AE0CC1A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ApiCompare_Statement DROP FOREIGN KEY FK_3CF1D454584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_task_apicompare_category DROP FOREIGN KEY FK_509F3D0E25D3463
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE apicompare_task_apicompare_category DROP FOREIGN KEY FK_509F3D0B1C05D7D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Brand
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Ensign
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Rule
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Statement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ApiCompare_Task
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE apicompare_task_apicompare_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE refresh_tokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
    }
}
