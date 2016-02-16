ALTER TABLE  `#__sportsmanagement_round` ADD `rdatefirst_timestamp` INT( 11 ) NOT NULL DEFAULT  0 ;
ALTER TABLE  `#__sportsmanagement_round` ADD `rdatelast_timestamp` INT( 11 ) NOT NULL DEFAULT  0 ;

ALTER TABLE `#__sportsmanagement_season_team_person_id` DROP INDEX `combi`;
ALTER TABLE `#__sportsmanagement_season_team_person_id` ADD UNIQUE INDEX `combi` (`person_id`,`season_id`,`team_id`,`persontype`) ;

ALTER TABLE `#__sportsmanagement_season_person_id` DROP INDEX `combi`;
ALTER TABLE `#__sportsmanagement_season_person_id` ADD UNIQUE INDEX `combi` (`person_id`,`season_id`,`team_id`,`persontype`) ;

INSERT INTO `#__sportsmanagement_version_history` (`id`, `date`, `text`, `version`) VALUES
(NULL, '2015-11-31', 'COM_SPORTSMANAGEMENT_DB_UPDATE_2016_02_11', '1.0.54');