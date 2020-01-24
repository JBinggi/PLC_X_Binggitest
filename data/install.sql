--
-- Base Table
--
CREATE TABLE `binggitest` (
  `Binggitest_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `binggitest`
  ADD PRIMARY KEY (`Binggitest_ID`);

ALTER TABLE `binggitest`
  MODIFY `Binggitest_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Binggitest\\Controller\\BinggitestController', 'Add', '', '', 0),
('edit', 'OnePlace\\Binggitest\\Controller\\BinggitestController', 'Edit', '', '', 0),
('index', 'OnePlace\\Binggitest\\Controller\\BinggitestController', 'Index', 'Binggitests', '/binggitest', 1),
('list', 'OnePlace\\Binggitest\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Binggitest\\Controller\\BinggitestController', 'View', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`) VALUES ('binggitest-single', 'Binggitest');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('binggitest-index', 'binggitest-single', 'Binggitest Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('binggitest-base', 'binggitest-single', 'Binggitest', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Binggitest', 'fas fa-save', 'Save Binggitest', '#', 'primary saveForm', '', 'binggitest-single', 'link', '', ''),
(NULL, 'Edit Binggitest', 'fas fa-edit', 'Edit Binggitest', '/binggitest/edit/##ID##', 'primary', '', 'binggitest-view', 'link', '', ''),
(NULL, 'Add Binggitest', 'fas fa-plus', 'Add Binggitest', '/binggitest/add', 'primary', '', 'binggitest-index', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'binggitest-base', 'binggitest-single', 'col-md-3', '/binggitest/view/##ID##', '', 0, 1, 0, '', '', '');

COMMIT;