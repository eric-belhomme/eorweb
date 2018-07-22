ALTER TABLE auth_settings ADD COLUMN ldap_group_filter varchar(255);
ALTER TABLE auth_settings CHANGE ldap_filter ldap_user_filter varchar(255);
ALTER TABLE groups ADD COLUMN group_type tinyint(1);
ALTER TABLE groups ADD COLUMN group_dn varchar(255);
CREATE TABLE `ldap_groups_extended` (
  `dn` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `checked` smallint(6) NOT NULL,
  PRIMARY KEY (`dn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
