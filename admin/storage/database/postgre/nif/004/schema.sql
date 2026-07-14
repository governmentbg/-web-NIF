CREATE TABLE news_categories (
	category serial NOT NULL,
	"name" varchar(255) NOT NULL,
	url varchar(1000) NOT NULL,
	lang int NOT NULL,
	CONSTRAINT news_categories_pk PRIMARY KEY (category),
	CONSTRAINT news_categories_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE news_types (
	news int NOT NULL,
	"type" int NOT NULL,
	pos int DEFAULT 0 NOT NULL,
	CONSTRAINT news_types_pk PRIMARY KEY (news, type),
	CONSTRAINT news_types_news_fk FOREIGN KEY (news) REFERENCES news(news) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT news_types_news_categories_fk FOREIGN KEY ("type") REFERENCES news_categories(category) ON DELETE RESTRICT ON UPDATE RESTRICT
);



