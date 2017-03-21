CREATE TABLE tx_uw_two_clicks_records (
        uid INT(11) unsigned DEFAULT '0' NOT NULL auto_increment,
        pid INT(11) DEFAULT '0' NOT NULL,
	tstamp       INT(11) DEFAULT '0'     NOT NULL,
	crdate       INT(11) DEFAULT '0'     NOT NULL,
	cruser_id    INT(11) DEFAULT '0'     NOT NULL,
        deleted      TINYINT(4) DEFAULT '0' NOT NULL,
        hidden       TINYINT(4) DEFAULT '0' NOT NULL,
        record_id varchar(255) DEFAULT '' NOT NULL,
        record_type  varchar(255) DEFAULT '' NOT NULL,
        embedded_text text NOT NULL,
        auto_play boolean Default '0' NOT NULL,
        preview_image_id int(11)  DEFAULT '0' NOT NULL,
        contet_id int(11) DEFAULT '0' NOT NULL,
        width int(11)  DEFAULT '0' NOT NULL,
        height int(11)  DEFAULT '0' NOT NULL,

        PRIMARY KEY (uid),
        KEY parent (pid)
);

CREATE TABLE tt_content(
        tx_uw_two_clicks_id INT(11) DEFAULT '0' NOT NULL,
);