CREATE TABLE banners (
	banner serial NOT NULL,
	image int NOT NULL,
	title varchar(255) NOT NULL,
	alt varchar(255) NOT NULL,
	pos int2 DEFAULT 0 NOT NULL,
	lang int NOT NULL,
	link varchar(1000) NOT NULL,
	CONSTRAINT banners_pk PRIMARY KEY (banner),
	CONSTRAINT banners_uploads_fk FOREIGN KEY (image) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT banners_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT
);
