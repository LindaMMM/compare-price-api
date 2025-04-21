<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414214157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7A7294869C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, brand_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, ref_marque VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', update_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', content LONGTEXT DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_category (task_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_468CF38D8DB60186 (task_id), INDEX IDX_468CF38D12469DE2 (category_id), PRIMARY KEY(task_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category ADD CONSTRAINT FK_468CF38D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP FOREIGN KEY FK_23A0E6644F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie DROP FOREIGN KEY FK_36571B658DB60186
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie DROP FOREIGN KEY FK_36571B65BCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7A11C8FB41
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D860BF7A7294869C ON bank
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D860BF7A11C8FB41 ON bank
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD product_id INT DEFAULT NULL, DROP article_id, DROP bank_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD CONSTRAINT FK_D860BF7A4584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D860BF7A4584665A ON bank (product_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCC12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7A4584665A
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, brand_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ref_marque VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, create_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', update_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_23A0E66BCF5E72D (categorie_id), INDEX IDX_23A0E6644F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_categorie (task_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_36571B658DB60186 (task_id), INDEX IDX_36571B65BCF5E72D (categorie_id), PRIMARY KEY(task_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD CONSTRAINT FK_23A0E6644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie ADD CONSTRAINT FK_36571B658DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie ADD CONSTRAINT FK_36571B65BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category DROP FOREIGN KEY FK_468CF38D8DB60186
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_category DROP FOREIGN KEY FK_468CF38D12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D860BF7A4584665A ON bank
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD bank_id INT DEFAULT NULL, CHANGE product_id article_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD CONSTRAINT FK_D860BF7A11C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD CONSTRAINT FK_D860BF7A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D860BF7A7294869C ON bank (article_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D860BF7A11C8FB41 ON bank (bank_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCC12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
