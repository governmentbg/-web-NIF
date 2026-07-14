CREATE TABLE program_categories (
	category serial NOT NULL,
	lang int NOT NULL,
	"name" varchar(255) NOT NULL,
	is_active int DEFAULT 0 NOT NULL,
	sort_order int DEFAULT 0 NOT NULL,
	CONSTRAINT program_categories_pk PRIMARY KEY (category),
	CONSTRAINT program_categories_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT
);
