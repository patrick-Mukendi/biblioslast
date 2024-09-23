<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923143907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_of_birfth DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_of_death DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nationality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, author_book_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, edited_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', plot LONGTEXT NOT NULL, page_number INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_CBE5A33153982CC2 (author_book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_comments (book_id INT NOT NULL, comments_id INT NOT NULL, INDEX IDX_4661807316A2B381 (book_id), INDEX IDX_4661807363379586 (comments_id), PRIMARY KEY(book_id, comments_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_CCF1F1BA7DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33153982CC2 FOREIGN KEY (author_book_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE book_comments ADD CONSTRAINT FK_4661807316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_comments ADD CONSTRAINT FK_4661807363379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE editor ADD CONSTRAINT FK_CCF1F1BA7DD8AC20 FOREIGN KEY (books_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33153982CC2');
        $this->addSql('ALTER TABLE book_comments DROP FOREIGN KEY FK_4661807316A2B381');
        $this->addSql('ALTER TABLE book_comments DROP FOREIGN KEY FK_4661807363379586');
        $this->addSql('ALTER TABLE editor DROP FOREIGN KEY FK_CCF1F1BA7DD8AC20');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_comments');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
