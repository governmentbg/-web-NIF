ALTER TABLE news ADD status int NOT NULL;
ALTER TABLE news ADD description varchar(2000) NOT NULL;
ALTER TABLE news ADD "leading_news" int NOT NULL;

CREATE TABLE news_images (
	news int4 NOT NULL,
	image int4 NOT NULL,
	pos int2 NULL,
	CONSTRAINT news_images_pk PRIMARY KEY (news, image),
	CONSTRAINT news_images_news_fk FOREIGN KEY (news) REFERENCES news(news) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT news_images_uploads_fk FOREIGN KEY (image) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
CREATE TABLE news_files (
	file int4 NOT NULL,	
	"news" int4 NOT NULL,
	pos int4 DEFAULT 0 NOT NULL,
	CONSTRAINT news_files_pk PRIMARY KEY (file, news),
	CONSTRAINT news_files_news_fk FOREIGN KEY (news) REFERENCES news(news) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT news_files_uploads_fk FOREIGN KEY (file) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);