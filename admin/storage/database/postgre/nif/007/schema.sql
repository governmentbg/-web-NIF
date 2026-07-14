CREATE TABLE documents_categories (
	category serial NOT NULL,
	name varchar(255) NOT NULL,
	ord int4 DEFAULT 0 NOT NULL,
	lang int NOT NULL,
	CONSTRAINT documents_categories_pk PRIMARY KEY (category),
	CONSTRAINT documents_categories_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT
);
