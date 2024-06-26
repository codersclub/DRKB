---
Title: Использование BDE приложений в Peer-To-Peer сети
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Использование BDE приложений в Peer-To-Peer сети
================================================

Сетью Peer-To-Peer (сеть, где каждая машина действует как клиент и как
сервер) может быть одна из следующих сетей, включая другие сетевые
платформы, совместимые с ними:

- Windows 95
- Windows NT
- Lantastic
- Netware Lite

BDE автоматически обнаруживает таблицы на сетевом диске, но он не может
их определить на dedicated сервере или server/client. Dedicated-сервера
уведомляют приложение клиента о том, что файл был изменен или
заблокирован. Данная функциональность отсутствует в Peer-To-Peer
(не-dedicated) сетях. Для ее включения в сетях Peer-To-Peer, установите
"LOCAL SHARE" в TRUE в BDE Configuration Utility на странице System.
Это должно быть сделано на всех клиентах BDE, которые имеют доступ к
таблицам в сетях, указанных выше. В случае файловых серверов Novell
данное требование не является необходимым.

Если используемые таблицы - таблицы Paradox, они также должны
использовать каталог с сетевым контролем. Данный каталог должен
находиться в сети для всех используемых клиентских приложений. Хорошим
стилем считается использование отдельного каталога для приложения, сети
и таблиц. Поясним примером:

    <Каталог общего доступа>
        | 
        |--- <Каталог таблиц>
        |--- <Каталог Exe-файлов>
        |--- <Сетевой каталог>

Существуют две различных среды BDE, которые необходимо принимать во
внимание:

- Использование только 32-битных приложений BDE.
- Использование только 32-битных приложений BDE совместно с 16-битными.
- Установка только для 32-битных приложений

32-битное BDE полностью поддерживает соглашение об путях UNC вместе с
длинными именами файлов. Рекомендуется использование соглашения UNC для
всех сетевых соединений BDE. UNC позволяет обойтись без подключения
(mapped) сетевых дисков. Это позволяет иметь доступ к таблицам и сетевым
каталогам без необходимости заставлять пользователя подключать сетевые
диски. UNC имеет следующий синтаксис:

    \\<Имя сервера>\<Имя каталога общего доступа>\<Путь к каталогу>+\<Имя файла>

Вот простой пример стандартного псевдонима (alias) BDE с использованием
UNC:

Псевдоним: MyUNCAlias 

    Тип: STANDARD 
    Путь: \\FooServer\FooShare\Sharedir\Tables 
    Драйвер по умолчанию: Paradox

Сетевой каталог может быть установлен и таким способом:

    Драйвер: Paradox 
    Сетевой каталог: \\FooServer\FooShare\Sharedir\NetDir

Сетевой каталог может быть установлен во время выполнения приложения с
помощью session.netfiledir (Delphi) или DbiSetProp (C++ / Delphi)

Если по какой-либо причине UNC не может использоваться в 32-битных
приложениях, следуйте за следующими инструкциями для среды с 32-битными
и 16-битными приложениями BDE.

Установка для 16-битных и 32-битных приложений BDE

Поскольку 16-битное Windows API не поддерживает UNC, ее не поддерживает
и 16-битное BDE. Для того, чтобы позволить приложениям иметь общий
доступ к таблицам, все клиенты должны подключить один и тот же каталог
на сервере. Если сервер также используется и в качестве клиента, то все
другие клиенты должны подключить его корневой каталог диска. Логический
диск при этом у клиентов может быть разным. Вот несколько примеров с
работающими и неработающими настройками:

Клиент1:
:   Путь: X:\Каталог общего доступа\Таблицы

Клиент2:
:   Путь: X:\Каталог общего доступа\Таблицы

Работоспособно!

Клиент1: (Также машина с таблицами): 
:   Путь: X:\Каталог общего доступа\Таблицы

Клиент2: 
:   Путь: X:\Каталог общего доступа\Таблицы

Работоспособно!

Клиент1: (Также машина с таблицами):
:    Путь: C:\Каталог общего доступа\Таблицы

Клиент2: 
:    Путь: X:\Каталог общего доступа\Таблицы

Клиент3: 
:   Путь: R:\Каталог общего доступа\Таблицы

Работоспособно!

Клиент1:
:   Путь: X:\Каталог общего доступа\Таблицы

Клиент2:
:   Путь: X:\Таблицы  
(Где "X:\Таблицы" реально - "X:\Каталог общего доступа\Таблицы", но имеющий
общий доступ в "Каталог общего доступа")

**Неработоспособно!**  
BDE должен иметь возможность иметь доступ к файлу Network Control (управление
сетью).

Итог (установки для сетей Peer-To-Peer):

16- и/или 32-битные приложения:

- В BDE Configuration Utility установите "LOCAL SHARE" в TRUE.
- Не используйте UNC-имена.
- Не используйте таблицы с длинными именами файлов.
- Убедитесь в том, что все клиенты подключены к одному и тому же каталогу на сервере.

Только 32-битные приложения:

- В BDE Configuration Utility установите "LOCAL SHARE" в TRUE.
- Для получения доступа к сетевому каталогу и каталогу с таблицами используйте UNC-имена.

При невыполнении описанных выше шагов пользователи могут блокировать
таблицы с получением следующей ошибки:

    "Directory is controlled by other .NET file."
    (Каталог управляется другим .NET-файлом)
    "File:  PDOXUSRS.LCK"
    ("Файл:  PDOXUSRS.LCK")
    "Directory: "
    (Каталог: )

ИЛИ

    "Multiple .NET files in use."
    (Используются несколько .NET-файлов.)
    "File:  PDOXUSRS.LCK"
    (Файл:  PDOXUSRS.LCK)

