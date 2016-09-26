<?php

use yii\db\Migration;

/**
 * Handles the creation for table `films`.
 */
class m160925_172147_create_films_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("CREATE TABLE `film` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `year` smallint(6) NOT NULL,
            `title` varchar(200) NOT NULL COMMENT 'Movie title',
            `url` varchar(2000) NOT NULL COMMENT 'URL',
            `rating` float(5,3) DEFAULT NULL COMMENT 'Rating',
            `externalId` int(10) unsigned DEFAULT NULL COMMENT 'External ID',
            PRIMARY KEY (`id`),
            KEY `year` (`year`)
          ) ENGINE=InnoDB AUTO_INCREMENT=7505 DEFAULT CHARSET=utf8");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('film');
    }
}
