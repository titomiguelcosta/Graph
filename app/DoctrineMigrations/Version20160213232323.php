<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160213232323 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE VIEW node_links_view AS SELECT n1.id AS node_id, n1.name AS node_name, n2.id AS destination_node_id, n2.name AS destination_node_name, l.cost AS link_length, n1.graph_id AS graph_id FROM node n1 JOIN edge l ON (n1.id = l.from_id AND n1.graph_id = l.graph_id) JOIN node n2 ON (l.to_id = n2.id AND l.graph_id = n2.graph_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW node_links_view');
    }
}
