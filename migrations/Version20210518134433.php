<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518134433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331714819A0');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331C2428192');
        $this->addSql('DROP INDEX IDX_CBE5A331C2428192 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A331714819A0 ON book');
        $this->addSql('ALTER TABLE book ADD genre_id INT NOT NULL, ADD type_id INT NOT NULL, DROP genre_id_id, DROP type_id_id');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3314296D31F ON book (genre_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331C54C8C93 ON book (type_id)');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0371868B2E');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D039D86650F');
        $this->addSql('DROP INDEX IDX_C5D30D039D86650F ON loan');
        $this->addSql('DROP INDEX IDX_C5D30D0371868B2E ON loan');
        $this->addSql('ALTER TABLE loan ADD user_id INT NOT NULL, ADD book_id INT NOT NULL, DROP user_id_id, DROP book_id_id');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0316A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D03A76ED395 ON loan (user_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D0316A2B381 ON loan (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331C54C8C93');
        $this->addSql('DROP INDEX IDX_CBE5A3314296D31F ON book');
        $this->addSql('DROP INDEX IDX_CBE5A331C54C8C93 ON book');
        $this->addSql('ALTER TABLE book ADD genre_id_id INT NOT NULL, ADD type_id_id INT NOT NULL, DROP genre_id, DROP type_id');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C2428192 FOREIGN KEY (genre_id_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331C2428192 ON book (genre_id_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331714819A0 ON book (type_id_id)');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03A76ED395');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0316A2B381');
        $this->addSql('DROP INDEX IDX_C5D30D03A76ED395 ON loan');
        $this->addSql('DROP INDEX IDX_C5D30D0316A2B381 ON loan');
        $this->addSql('ALTER TABLE loan ADD user_id_id INT NOT NULL, ADD book_id_id INT NOT NULL, DROP user_id, DROP book_id');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0371868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D039D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D039D86650F ON loan (user_id_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D0371868B2E ON loan (book_id_id)');
    }
}
