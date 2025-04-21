<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414212524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, bank_id INT DEFAULT NULL, INDEX IDX_D860BF7A7294869C (article_id), INDEX IDX_D860BF7A11C8FB41 (bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ensign (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, dateinput DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, valid TINYINT(1) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, ensign_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, price VARCHAR(255) NOT NULL, stock VARCHAR(255) NOT NULL, INDEX IDX_46D8ACCC12469DE2 (category_id), INDEX IDX_46D8ACCCAE0CC1A7 (ensign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, frequency VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_categorie (task_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_36571B658DB60186 (task_id), INDEX IDX_36571B65BCF5E72D (categorie_id), PRIMARY KEY(task_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD CONSTRAINT FK_D860BF7A7294869C FOREIGN KEY (article_id) REFERENCES article (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank ADD CONSTRAINT FK_D860BF7A11C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCC12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCCAE0CC1A7 FOREIGN KEY (ensign_id) REFERENCES ensign (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie ADD CONSTRAINT FK_36571B658DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie ADD CONSTRAINT FK_36571B65BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `group`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE group_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE marque
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tache
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD brand_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD CONSTRAINT FK_23A0E6644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_23A0E6644F5D008 ON article (brand_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX uniq_identifier_email TO UNIQ_8D93D649E7927C74
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP FOREIGN KEY FK_23A0E6644F5D008
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE group_user (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4C98D39A76ED395 (user_id), INDEX IDX_A4C98D39FE54D947 (group_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, frequence VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7A7294869C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bank DROP FOREIGN KEY FK_D860BF7A11C8FB41
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCCAE0CC1A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie DROP FOREIGN KEY FK_36571B658DB60186
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_categorie DROP FOREIGN KEY FK_36571B65BCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bank
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brand
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ensign
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rule
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_23A0E6644F5D008 ON article
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP brand_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_IDENTIFIER_EMAIL
        SQL);
    }
}
