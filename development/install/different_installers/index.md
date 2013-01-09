---
Title: Такие разные инсталляторы
author: Татьяна Михно
Date: 23.06.2004
---


Такие разные инсталляторы
=========================

::: {.date}
01.01.2007
:::


Конечный пользователь - нежен и привередлив, ему приятно, когда
программа сама устанавливается на его компьютер и радостно сообщает о
своей готовности к работе

Поговорим о верных помощниках разработчика - инсталляторах,
программах, которые умеют создавать дистрибутив приложения. Дистрибутивы
обычно занимаются установкой приложения на компьютер пользователя, а в
случае необходимости - переустановкой или удалением.

Для сравнения инсталляторов воспользуемся приложением Ins - это
простенький текстовый редактор, за 10 минут созданный в MS Visual C++,
MFC. Он состоит из двух файлов: C:\\InS.src\\ins.exe и
C:\\InS.src\\mfc42.dll. Чтобы корректно установить его на другой
компьютер, нужно:

1.   скопировать исполняемый файл ins.exe на жесткий диск;
1.   скопировать в системный каталог Windows файл библиотеки MFC mfc42.dll;
1.   прописать в системном реестре каталог установки и текущий каталог редактора;
1.   создать каталог С:\\Мои документы - текущий каталог редактора по умолчанию;
1.   создать ярлык для запуска Ins на рабочем столе и в меню Пуск =\> Программы панели задач.

Несмотря на то что опытный программист может проделать это без
посторонней помощи, давайте все же проследим, как с этой задачей
справятся различные инсталляторы.

Семейство InstallShield

Одним из гигантов производства инсталляторов (причем гигантов в мировом
масштабе) признана компания InstallShield. На ее сайте
(http://www.installshield.com) представлена целая линейка этих продуктов -
различных по сложности и стоимости (кстати, после регистрации можно
получить пробную 30-дневную версию:

-   InstallShield Developer (поддержка распараллеленной установки, интеграция с Visual Studio .NET, создание патчей, визуальный редактор диалогов, контроль исходного кода);
-   InstallShield Professional (скриптовый язык, средства отладки, многочисленные настройки пользовательского интерфейса, возможность создания дистрибутивов под Web);
-   InstallShield Express - облегченная версия, простая в использовании, поставляется с Delphi 5 и Visual Studio 6;
-   InstallShield MultiPlatform (поддержка Linux, Solaris, HP-UX, AIX, OS/2, Windows и OS/400, функционирование на основе Java VM);
-   InstallShield AdminStudio (системное администрирование, управление рабочим процессом, разрешение конфликта приложений, поддержка модулей MSI (Microsoft Installer));
-   InstallShield DemoShield - средство создания итерактивных презентаций, каталогов на компакт-диске;
-   InstallShield Update Service - инструмент для создания и управления обновлениями программного обеспечения на компьютерах клиентов;
-   InstallShield Package for the Web - средство для распространения приложений через интернет, для доставки и цифровой подписи интернет-модулей.

InstallShield for Windows Installer

Среди разработчиков особую популярность приобрел InstallShield for
Windows Installer. У этого продукта понятный интерфейс, подсказки на
каждом шагу, да и занимает он на жестком диске всего 66 Mб.

Мастера в InstallShield for Windows Installer удобны и продвинуты; кроме
того, предусмотрена возможность изменения настроек дистрибутива в
следующих секциях раздела Workspace:

-   Project (общие настройки проекта, пути, переменные проекта, строковые ресурсы инсталлятора);
-   Setup Design (файлы, включенные в проект, пути реестра, ярлыки, регистрация COM-объектов и типов файлов, управление службами Windows NT);
-   Sequences (последовательность инсталляции);
-   Actions/Scripts (комментарии к действиям, добавление скриптов);
-   User Interface (настройка интерфейса: диалогов и сообщений);
-   Release - результат (дистрибутивы и log-файлы их создания; подстройка под физический носитель (сеть, компакт-диск), посредством которого будет распространяться приложение; языки интерфейса).

Мастер (wizard) создания дистрибутива (кстати, достаточно длинный: 11
шагов, в каждом из которых несколько настроек) справился с поставленной
задачей. Дистрибутив InS занял 872 Mб (с компрессией, без модулей MSI).

InstallShield Professional

Наиболее весомое (267 Mб в полной установке) и наиболее сложное средство
создания дистрибутивов. InstallShield Professional 6.2 имеет собственный
скриптовый язык, большое количество настроек и предназначен для создания
дистрибутивов крупных корпоративных приложений.

При создании нового проекта основную работу (как и в случае с предыдущим
продуктом) можно поручить мастеру - для обычного проекта или для
проекта Visual Basic. Мастер задаст много вопросов, потом немного
попыхтит и, в конце концов, покажет проект инсталляции, скомпилировав
который, мы и получим дистрибутив.

На левой панели InstallShield Professional видны семь вкладок, каждая из
которых отвечает за свою группу настроек инсталляции:

-   Scripts - здесь находится основной скрипт процесса инсталляции - файл setup.rul, который можно создать с помощью мастера, а после редактировать вручную, отлаживать и компилировать. Скриптовый язык InstallShield немного похож на VB, но вполне поддается пониманию;
-   File Groups - на этой вкладке в проект добавляются файлы: исполняемые, библиотеки, файлы помощи и примеров;
-   Components - здесь перечислены компоненты проекта. Они обязательно должны включать группы файлов из предыдущего раздела;
-   Setup Types - тут описываются типы установки (компактная, обычная, пользовательская) и то, какие компоненты из предыдущего раздела включаются в каждый тип установки;
-   Setup Files - здесь перечислены файлы, включенные в инсталляцию, настраиваются зависимости от операционной системы и языка. Тут же можно отредактировать или заменить заставку;
-   Resources - ресурсные файлы инсталляции: таблица переменных проекта (для каждого языка своя), записи в реестр, включение в меню Пуск =\> Программы =\> Автозагрузка, добавление объектов различных сред исполнения;
-   Media - на этой вкладке находится результат нашей работы: дистрибутив, файлы журнала и отчета. Широко варьируется способ распространения дистрибутива: на компакт-диске, дискетах 3,5\", через интернет и пр.

Размер дистрибутива InS занял 2 Mб.

Wise InstallMaster

Wise InstallMaster 8.1 - произведение компании Wise Solutions
(http://www.wise.com) - обладает не меньшей функциональностью, чем
предыдущий продукт. Однако его интерфейс более понятен простому
человеку.

Процесс создания дистрибутива разбит на 6 этапов:

1.   files and components - задается список файлов и компонент, составляющих наше приложение. В этом разделе нужно указать, откуда и какие файлы помещать в дистрибутив, куда их класть при инсталляции. Задаются также настройки для патчей, деинсталляции, шрифтов, сред исполнения (runtime) Visual Basic, Visual Foxpro, BDE, Crystall Reports, Windows и баз данных;
1.   system additions - в этом разделе задаются настройки для иконок, ключей реестра, INI-файлов и регистрации типов файлов Windows. Здесь же добавляются службы Windows NT и устройства Windows 3.1х и 9х, необходимые для работы приложения. Кроме того, задаются изменения, которые необходимо добавить в файлы autoexec.bat и config.sys, а также информация о том, в каком каталоге создавать log-файл инсталляции нашего приложения;
1.   user system checks - этот раздел отвечает за системные требования нашего приложения к компьютеру пользователя и ранее установленные версии нашего приложения;
1.   wizard appearance - в этом разделе описывается, как будет выглядеть процесс инсталляции. Редактированию поддаются фон и диалоговые окна, можно добавить свою рекламу, которая будет показываться в процессе инсталляции;
1.   advanced functionality - в раздел включены возможности защиты дистрибутива паролем, online-регистрации и поддержки Windows CE;
1.   finish - здесь указывается, в каком виде будет создан дистрибутив (в одном файле или в нескольких), и создавать ли CAB-файл. В этом же разделе находятся настройки для распространения приложения через интернет, контроля версий и специальные настройки для установки и удаления в Windows 2000.

Скрипт создания дистрибутива в Wise можно редактировать.

Дистрибутив приложения InS, созданный в Wise, занял 600 Kб.

Следует заметить, что с сайта компании-изготовителя можно загрузить не
только 30-дневную демонстрационную версию инсталлятора под Windows, но и
надстройки для нескольких сред исполнения (runtime) и руководство
пользователя. Дистрибутив Wise InstallMaster 8.1 занимает 9 Мб, а после
установки на жесткий диск - 15,5 Мб.

Inno Setup

Далее в нашем хит-параде - Inno Setup. Это небольшой (1,1 Мб -
дистрибутив, 2 Мб - в установке), но очень шустрый (а главное,
бесплатный) продукт. Разработчик - Jordan Russel
(http://www.jrsoftware.org/isdl.php).

Inno Setup может стать хорошим решением для распространения совсем
простых программ. Имеет 2 режима - мастер установки и редактирование
скрипта. Позволяет показать файл лицензии, добавить ярлык нашей
программы в меню Пуск и на рабочий стол, запустить программу после
установки, но не может работать с реестром.

За 2 минуты (в нем действительно просто разобраться!) Inno Setup создал
файл setup.exe - дистрибутив нашей программки размером 700 Кб. Но, к
сожалению, он справился не со всеми пунктами поставленной задачи.

Quick Install Maker 2000

Программа компании MJK Software Writers, Inc (http://www.mjksw.com)
сразу очаровывает приятным и нестандартным интерфейсом. Большие и с
красивыми рисунками кнопки расположены удобно; ничего лишнего (кроме
назойливых приглашений зарегистрироваться) нет. Четыре правые кнопки
отвечают за следующие аспекты создания инсталляции:

-   Main Screen - настройка внешнего вида инсталляции нашего приложения: фон или изображение на экране, надписи, а также начальные параметры установки;
-   Install Files - включение в инсталляцию файлов, добавление ярлыков на рабочий стол и в меню Пуск \* Программы;
-   INI\\REG - добавление ключей реестра или INI-файла, строк в файлы autoexec.bat и config.sys;
-   Disk Builder - создание дистрибутива, его архивирование и копирование на дискеты.

Демо-версия QIM2000, которую можно загрузить с сайта производителя,
весит 2,2 Мб, а установка программы занимает 2,8 Мб.

Дистрибутив InS занял 754 Kб, с поставленной задачей справился
полностью. Правда, при установке несколько раз сообщил о том, что он не
зарегистрирован и вообще является демо-версией.

Конечно, инсталляторов существует намного больше, чем рассмотрено в этой
статье. Бесплатные и условно-бесплатные продукты различных компаний и
отдельных разработчиков можно загрузить с сервера SoftArea.ru
<http://www.softarea.ru/cgi-bin/show.pl?70> или SoftPC.ru
<http://www.softpc.ru/cgi-bin/cat.cgi?id=3&cat=1514>.

Если уж на то пошло, инсталлятор можно написать самостоятельно.


2004.06.23 Автор: Татьяна Михно

<https://www.cpp.com.ua>