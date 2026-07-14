CREATE TABLE infoblocks (
	infoblock serial NOT NULL,
	title varchar(1000) NOT NULL,
	description varchar(2000) NOT NULL,
	icon int NULL,
	page_url text NULL,
	lang int NOT NULL,
	CONSTRAINT infoblocks_pk PRIMARY KEY (infoblock),
	CONSTRAINT infoblocks_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT infoblocks_uploads_fk FOREIGN KEY (icon) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
ALTER TABLE infoblocks ADD hidden int2 DEFAULT 0 NOT NULL;
