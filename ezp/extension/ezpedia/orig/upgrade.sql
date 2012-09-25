SET storage_engine=INNODB;
UPDATE ezsite_data SET value='4.0.2' WHERE name='ezpublish-version';
UPDATE ezsite_data SET value='1' WHERE name='ezpublish-release';

-- Enhanced ISBN datatype.
CREATE TABLE ezisbn_group (
  id int(11) NOT NULL auto_increment,
  description varchar(255) NOT NULL default '',
  group_number int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
);

CREATE TABLE ezisbn_group_range (
  id int(11) NOT NULL auto_increment,
  from_number int(11) NOT NULL default '0',
  to_number int(11) NOT NULL default '0',
  group_from varchar(32) NOT NULL default '',
  group_to varchar(32) NOT NULL default '',
  group_length int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
);

CREATE TABLE ezisbn_registrant_range (
  id int(11) NOT NULL auto_increment,
  from_number int(11) NOT NULL default '0',
  to_number int(11) NOT NULL default '0',
  registrant_from varchar(32) NOT NULL default '',
  registrant_to varchar(32) NOT NULL default '',
  registrant_length int(11) NOT NULL default '0',
  isbn_group_id int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
);

-- URL alias
CREATE TABLE ezurlalias_ml_incr (
  id integer NOT NULL auto_increment,
  PRIMARY KEY(id)
);

CREATE TABLE ezurlalias_ml (
  id        integer NOT NULL DEFAULT 0,
  link      integer NOT NULL DEFAULT 0,
  parent    integer NOT NULL DEFAULT 0,
  lang_mask integer NOT NULL DEFAULT 0,
  text      longtext NOT NULL,
  text_md5  varchar(32) NOT NULL DEFAULT '',
  action    longtext NOT NULL,
  action_type varchar(32) NOT NULL DEFAULT '',
  is_original integer NOT NULL DEFAULT 0,
  is_alias    integer NOT NULL DEFAULT 0,
  alias_redirects int(11) NOT NULL default 1,
  PRIMARY KEY(parent, text_md5),
  KEY ezurlalias_ml_text_lang (text(32), lang_mask, parent),
  KEY ezurlalias_ml_text (text(32), id, link),
  KEY ezurlalias_ml_action (action(32), id, link),
  KEY ezurlalias_ml_par_txt (parent, text(32)),
  KEY ezurlalias_ml_par_lnk_txt (parent, link, text(32)),
  KEY ezurlalias_ml_par_act_id_lnk (parent, action(32), id, link),
  KEY ezurlalias_ml_id (id),
  KEY ezurlalias_ml_act_org (action(32),is_original),
  KEY ezurlalias_ml_actt_org_al (action_type, is_original, is_alias),
  KEY ezurlalias_ml_actt (action_type)
);

CREATE TABLE ezurlwildcard (
  id int(11) NOT NULL auto_increment,
  source_url longtext NOT NULL,
  destination_url longtext NOT NULL,
  type int(11) NOT NULL default '0',
  PRIMARY KEY(id)
);

-- Update old urlalias table for the import
ALTER TABLE ezurlalias ADD COLUMN is_imported integer NOT NULL DEFAULT 0;
ALTER TABLE ezurlalias ADD KEY ezurlalias_imp_wcard_fwd (is_imported, is_wildcard, forward_to_id);
ALTER TABLE ezurlalias ADD KEY ezurlalias_wcard_fwd (is_wildcard, forward_to_id);
ALTER TABLE ezurlalias DROP KEY ezurlalias_is_wildcard;

-- URL alias name pattern
ALTER TABLE ezcontentclass ADD COLUMN url_alias_name VARCHAR(255) AFTER contentobject_name;

ALTER TABLE ezorder_item CHANGE vat_value vat_value FLOAT NOT NULL default 0;

DELETE FROM ezuser_setting where user_id not in (SELECT contentobject_id FROM ezuser);

DELETE FROM ezcontentclass_classgroup WHERE NOT EXISTS (SELECT * FROM ezcontentclass c WHERE c.id=contentclass_id AND c.version=contentclass_version);
