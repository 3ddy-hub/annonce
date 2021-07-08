<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707193536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, salaire DOUBLE PRECISION NOT NULL, contrat VARCHAR(5) NOT NULL, cdd_duree VARCHAR(3) NOT NULL, visibilite VARCHAR(10) NOT NULL, entretient VARCHAR(20) NOT NULL, adresse VARCHAR(255) NOT NULL, cp INT NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, mail VARCHAR(30) NOT NULL, mail_suivi VARCHAR(30) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, mode_reponse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(30) NOT NULL, ref VARCHAR(15) NOT NULL, titre VARCHAR(15) NOT NULL, localisation VARCHAR(20) NOT NULL, pays VARCHAR(255) NOT NULL, site VARCHAR(15) NOT NULL, description LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', secteur VARCHAR(40) NOT NULL, experience VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE offre');
    }
}
