CREATE TABLE documents (
    "document" serial4 NOT NULL,
    lang int4 NOT NULL,
    "name" varchar(255) NOT NULL,
    description text NULL,
    fordate date NOT NULL,
    hidden int2 DEFAULT 0 NOT NULL,
    CONSTRAINT documents_pk PRIMARY KEY ("document"),
    CONSTRAINT documents_languages_fk FOREIGN KEY (lang) REFERENCES languages(lang) ON DELETE RESTRICT ON UPDATE RESTRICT
);
CREATE TABLE documents_types (
    "document" int4 NOT NULL,
    "type" int4 NOT NULL,
    CONSTRAINT documents_types_documents_fk FOREIGN KEY ("document") REFERENCES documents("document") ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT documents_types_document_categories_fk FOREIGN KEY ("type") REFERENCES documents_categories("category") ON DELETE RESTRICT ON UPDATE RESTRICT
);
CREATE TABLE document_files (
    file int4 NOT NULL,
    "document" int4 NOT NULL,
    pos int4 DEFAULT 0 NOT NULL,
    CONSTRAINT document_files_pk PRIMARY KEY (file, "document"),
    CONSTRAINT document_files_documents_fk FOREIGN KEY ("document") REFERENCES documents("document") ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT document_files_uploads_fk FOREIGN KEY (file) REFERENCES uploads(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);