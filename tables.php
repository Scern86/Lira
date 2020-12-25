<?php
defined('_DEXEC') or DIE;

// Системные таблицы (авторизация)
const TBL_LOGIN					= 'main_login';				// Авторизация

// Системные объекты (ресурсы)
const TBL_TAG					= 'main_tag';				// Теги (определения)
const TBL_DEFINITION			= 'main_definition';		// Определения свойств объектов
const TBL_OBJECT				= 'main_object';			// Объекты

// Расширенные поля объектов
const TBL_EXT_NUMBER			= 'ext_field_number';		// Число (до 10 разрядов)
const TBL_EXT_STRING			= 'ext_field_string';		// Строка (до 500 символов)
const TBL_EXT_DATE				= 'ext_field_date';			// Дата (+время)
const TBL_EXT_SHORT_TEXT		= 'ext_field_short_text';	// Короткий текст (до 16к символов)
const TBL_EXT_LONG_TEXT			= 'ext_field_long_text';	// Длинный текст (до 16м символов)
const TBL_EXT_TAG				= 'ext_field_tag';			// Связь объекта с тегом
const TBL_EXT_OBJECT			= 'ext_field_object';		// Связь объекта с объектом