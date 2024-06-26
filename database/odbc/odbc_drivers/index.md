---
Title: Установка ODBC
Author: Johannes M. Becher (CODATA GmbH Krefeld, Germany)
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Установка ODBC
==============

...если вам нужно знать, что творится за сценой, нужно просто взглянуть
на эти два файла, оба человеко-читаемых, оба расположенных в вашей
директории Windows.

A) ODBCINST.INI - описание всех установленных драйверов ODBC

Секция [ODBC Drivers] в каждой строчке описывает один драйвер. Здесь
прописано формальное имя драйвера, использующегося позже для
идентификации драйвера.

Каждый драйвер, как вы увидите позже, имеет собственную секцию, к
примеру, вот секция для Watcom :

    {1} [Watcom SQL 4.0]
    {2} Driver=D:\WIN31\SYSTEM\WOD40W.DLL
    {3} Setup=D:\WIN31\SYSTEM\WOD40W.DLL

Строка 1 содержит имя секции драйвера из [ODBC Drivers].

Строка 2 сообщает Windows о том, где следует искать DLL, содержащую
методы, применяемые ODBC для доступа к базам данных Watcom.

Строка 3 сообщает Windows о том, где следует искать DLL, содержащую
методы, применяемые ODBC для административных целей.

Все, что имеется в файле ODBCINST.INI - теперь содержится в файле #2
(таком же легком для изучения):

B) ODBC.INI - описание всех ваших баз данных (источников данных, говоря
языком ODBC)

Секция [ODBC Data Sources] в каждой строчке описывает одну базу
данных; формат:  
{описание базы данных} = {описание драйвера из ODBCINST.INI}

Данный файл сообщает ODBC, к каким базам данных вы хотите иметь доступ и
какой драйвер для каждой конкретной базы данных для этого необходим.

Каждая база данных, как вы увидите позже, имеет собственную секцию, к
примеру, вот секция PB Demo:

    {1} [Powersoft Demo DB=Watcom SQL 4.0]
    {2} DatabaseFile=E:\PB4\EXAMPLES\PSDEMO.DB
    {3} DatabaseName=PSDEMODB
    {4} UID=dba
    {5} PWD=sql
    {6} Driver=D:\WIN31\SYSTEM\WOD40W.DLL
    {7} Start=D:\WSQL40\DBSTARTW -d -c512

Строка 1 содержит ссылку на секцию [ODBC Data Sources].

Строка 2 содержит физический путь к файлу базы данных.

Строка 3 - описание, только для вашего чтения.

Строка 4 - User ID, которое Watcom применяет для установления связи.

Строка 5 - Пароль, используемый для установления соединения. - Это не очень секретно;
если вы оставите эту строку пустой, Watcom сам
спросит пароль при получении доступа к базе данных.

Строка 6 содержит имя драйвера (снова - сравните с OBDCINST.INI)

Строка 7 содержит имя движка базы данных для ее запуска (это необходимо
лишь для баз данных SQL, например, в версии Client / Server).

Все это может быть отредактировано как вручную (в любом текстовом
редакторе), так и в ODBCADM (ODBC Administration). Что касается меня
лично, то я более не использую ODBCADM; я ощущаю себя гораздо лучше,
если имею больший контроль над INI-файлами, редактируя строки вручную.

Структура секций в файле ODBC.INI может отличаться для разных драйверов,
поэтому вам необходимо научиться ориентироваться по ключевым словам,
описанным выше.

**Предупреждение:**  
весь опубликованный мною материал получен путем моих
собственных исследований, вследствие чего я не могу гарантировать его
достоверность. По крайней мере я успешно использую его для получения
доступа к ODBC уже более года.


