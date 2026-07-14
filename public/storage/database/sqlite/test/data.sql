INSERT INTO tree_struct (lft, rgt, lvl, pid, pos) VALUES (1, 2, 0, NULL, 0);

INSERT INTO sites (name, domains, tree, disabled, dflt) VALUES ('localhost', '127.0.0.1\nlocalhost', 1, 0, 1);

INSERT INTO languages (code, name, local) VALUES ('bg', 'Български', 'Български');
INSERT INTO languages (code, name, local) VALUES ('en', 'English', 'Английски');

INSERT INTO site_domain (site, domain) VALUES (1, '127.0.0.1');
INSERT INTO site_domain (site, domain) VALUES (1, 'localhost');

INSERT INTO site_lang (site, lang) VALUES (1, 1);
INSERT INTO site_lang (site, lang) VALUES (1, 2);

INSERT INTO templates (name, base, is_default) VALUES ('Страница', 'pages__page', 1);
INSERT INTO templates (name, base, is_default) VALUES ('Начало', 'pages__home', 0);
INSERT INTO templates (name, base, is_default) VALUES ('Търсене', 'pages__search', 0);
INSERT INTO templates (name, base, is_default) VALUES ('Новини', 'news__news', 0);
INSERT INTO templates (name, base, is_default) VALUES ('Галерии', 'galleries__gallery', 0);

INSERT INTO tree_data (id, lang, version, from_version, created, usr, title, hidden, url, redirect, settings, content, permissions, template, published) VALUES (1, 1, 1, NULL, CURRENT_TIMESTAMP, 1, 'Начало', 0, 'bg/1', '', '{}', '{}', NULL, 1, 1);
INSERT INTO tree_data (id, lang, version, from_version, created, usr, title, hidden, url, redirect, settings, content, permissions, template, published) VALUES (1, 2, 1, NULL, CURRENT_TIMESTAMP, 1, 'Home', 0, 'en/1', '', '{}', '{}', NULL, 1, 1);

INSERT INTO menus (name, site, lang, is_default, items) VALUES ('Основно меню', 1, 1, 1, '[{"type":"1","name":"","href":"","depth":""}]');
INSERT INTO menus (name, site, lang, is_default, items) VALUES ('Main menu', 1, 2, 1, '[{"type":"1","name":"","href":"","depth":""}]');