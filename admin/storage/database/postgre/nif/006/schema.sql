CREATE TABLE programs (
	"program" serial NOT NULL,
	lang int NOT NULL,
	title varchar(2000) NOT NULL,
	description text NOT NULL,
	status int DEFAULT 0 NOT NULL,
	m_duration int DEFAULT 1 NOT NULL,
	p_beg timestamp NOT NULL,
	p_end timestamp NOT NULL,
	budget varchar(2000) NULL,
	is_leading int DEFAULT 0 NOT NULL,
	header_img int NOT NULL,
	"content" text NULL,
	redirect_url varchar(2000) NULL,
	publish_status int DEFAULT 0 NOT NULL,
	CONSTRAINT programs_pk PRIMARY KEY ("program"),
	CONSTRAINT programs_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT programs_uploads_fk FOREIGN KEY (header_img) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
ALTER TABLE programs ADD created timestamp NOT NULL;
ALTER TABLE programs ADD updated timestamp NULL;
ALTER TABLE programs ADD created_by int NOT NULL;
ALTER TABLE programs ADD updated_by int NULL;
ALTER TABLE programs ADD CONSTRAINT programs_users_fk FOREIGN KEY (created_by) REFERENCES users(usr) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE programs ADD CONSTRAINT programs_users_fk_1 FOREIGN KEY (updated_by) REFERENCES users(usr) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE programs ADD "type" int NOT NULL;
ALTER TABLE programs ADD CONSTRAINT programs_program_categories_fk FOREIGN KEY ("type") REFERENCES program_categories(category) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE programs_images (
	"program" int NOT NULL,
	image int NOT NULL,
	pos int2 NOT NULL,
	CONSTRAINT programs_images_pk PRIMARY KEY ("program",image),
	CONSTRAINT programs_images_programs_fk FOREIGN KEY ("program") REFERENCES programs("program") ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT programs_images_uploads_fk FOREIGN KEY (image) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
CREATE TABLE programs_files (
	"program" int4 NOT NULL,
	file int4 NOT NULL,
	pos int4 DEFAULT 0 NOT NULL,
	CONSTRAINT programs_files_unique UNIQUE (file, program),
	CONSTRAINT programs_files_programs_fk FOREIGN KEY ("program") REFERENCES programs("program") ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT programs_files_uploads_fk FOREIGN KEY (file) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);


