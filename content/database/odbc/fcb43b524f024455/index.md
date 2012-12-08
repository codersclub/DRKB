---
Title: Конфигурирование ODBC и псевдонима
Date: 01.01.2007
---


Конфигурирование ODBC и псевдонима
==================================

::: {.date}
01.01.2007
:::

Настройка ODBC в Панели Управления

При инсталляции, Delphi устанавливает в Панель Управления апплет
\"ODBC\" (далее - \"настройка ODBC\"). \"Настройка ODBC\" содержит
доступные источники данных (драйвера), установленных для использования
ODBC. Как вы можете видеть на главной странице \"Data Sources\", ODBC
содержит внушительный набор форматов, которые могут использоваться в
Delphi. Дополнительные форматы поддерживаются установленными драйверами
и могут быть добавлены с помощью кнопки \"Add\...\".

Для добавления нового или удаления существующего драйвера:

В окне \"Data Sources\" нажмите кнопку \"Drivers\...\". В появившемся
диалоговом окне \"Drivers\" нажмите кнопку \"Add\...\" и укажите путь к
новому драйверу ODBC.

Возвратитесь в окно \"Data Sources\" и добавьте доступные с новым
драйвером источники данных с помощью кнопки \"Add\...\".

Для настройки конкретного источника данных используйте кнопку
\"Setup\...\". Функция кнопки \"Setup\...\" меняется с каждым форматом
данных. Частенько настройки типа рабочей директории для драйвера
настраиваются как раз в этом месте.

Разделы электронной справки доступны для каждой страницы и диалогового
окна \"Настроки ODBC\".

BDE CONFIGURATION UTILITY

После установки драйвера ODBC, запустите BDE Configuration utility для
конфигурации BDE для работы с новым драйвером.

На странице драйверов нажмите на кнопку \"New ODBC driver\".

Появится диалог с заголовком \"Add ODBC driver\". Опция \"SQL link
driver\" позволяет выяснить, с какими типами баз данных можно работать с
помощью данного драйвера ODBC.

Затем выбирайте default ODBC driver (драйвер ODBC по-умолчанию).
Выпадающий список содержит список типов файлов, поддерживаемых
установленными в системе драйверами ODBC.

Выберите для ODBC-драйвера источник данных по-умолчанию (default data
source). Имея уже установленный на шаге 3 драйвер ODBC, список этого
combobox\'а будет содержать имена источников данных, подходящих для
использования с выбранным драйвером.

Нажмите Ok.

Возвратитесь на страницу драйверов, выберите File/Save из главного меню
и сохраните данную конфигурацию.

Создание псевдонима в DATABASE DESKTOP

Хотя создать псевдоним ODBC можно и из BDE Configuration utility,
Database Desktop предоставляет более комфортное решение.

В меню \"File\" выберите пункт \"Aliases..\".

В появившемся диалоге \"Alias Manager\" нажмите кнопку \"New\".

Введите имя вашего нового псевдонима в поле редактирования, помеченной
как \"Database Alias\".

Используя выпадающий список \"Driver Type\" (типы драйверов), выберите
драйвер, подходящий для данного псевдонима. Таблицы Paradox и dBase
считаются STANDARD. Если в BDE Configuration utility драйвер ODBC был
правильно сконфигурирован, то его имя появится в списке.

Дополнительные опции опции могут появляться в зависимости от выбранного
типа драйвера.

После завершения всех описанных действий сохраните новый псевдоним,
выбрав \"Keep New\". Затем нажмите \"Ok\". Появится подсказка,
спрашивающая о необходимости сохранения псевдонима в IDAPI.CFG. Выберите
\"Ok\".

Теперь псевдоним будет работать и в Database Desktop, и в Delphi.

Взято с <https://delphiworld.narod.ru>