<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113095251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, is_available TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_72113DE65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, published DATE NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_available TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BA5AE01D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post_blog_category (blog_post_id INT NOT NULL, blog_category_id INT NOT NULL, INDEX IDX_C9F85ADCA77FBEAF (blog_post_id), INDEX IDX_C9F85ADCCB76011C (blog_category_id), PRIMARY KEY(blog_post_id, blog_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post_blog_category ADD CONSTRAINT FK_C9F85ADCA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_post_blog_category ADD CONSTRAINT FK_C9F85ADCCB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_post_blog_category DROP FOREIGN KEY FK_C9F85ADCCB76011C');
        $this->addSql('ALTER TABLE blog_post_blog_category DROP FOREIGN KEY FK_C9F85ADCA77FBEAF');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE blog_post_blog_category');
    }
}
