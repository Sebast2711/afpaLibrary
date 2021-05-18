<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518134319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, book_id_id INT NOT NULL, loan_date DATETIME NOT NULL, return_date DATETIME DEFAULT NULL, INDEX IDX_C5D30D039D86650F (user_id_id), INDEX IDX_C5D30D0371868B2E (book_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D039D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0371868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C2428192 FOREIGN KEY (genre_id_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP role, CHANGE email email VARCHAR(180) NOT NULL, CHANGE gender gender VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE loan');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331C2428192');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331714819A0');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD role INT NOT NULL, DROP roles, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender INT DEFAULT NULL');
    }
}
