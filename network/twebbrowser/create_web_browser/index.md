---
Title: Как сделать WebBrowser средствами Delphi?
Author: Лозовюк Александр (http://search3i.al.ru/)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как сделать WebBrowser средствами Delphi?
=========================================


Читая и перечитывая вопросы и ответы на Круглом столе сайта "Королевство
Дельфи" я все время натыкался на вопросы о компоненте TWebBrowser.
Сначала я думал, что все просто, но когда самому понадобилось написать
приложение с использованием TwebBrowser... оказалось, что не всё так
просто!

Эта статья не претендует на исчерпывающие руководство по написанию
браузера в Delphi 5 - скорее всего она будет со временем дополняться и
исправляться. Я постарался обобщить в одном работающем примере решения
большинства вопросов, заданных на этом сайте (признаюсь, там были и
мои). Также выражаю большую признательность Елене Филлиповой за
исчерпывающие ответы на некоторые из них, и всему Королевству за столь
хороший и полезный сайт.

Компонент TWebBrowser в Delphi 4 нужно было специально инсталлировать
как Active X компонент. В 5-й версии нам пошли навстречу, и он сразу
есть на вкладке Internet. Не буду останавливаться на особенностях
интерфейса программы - он очень прост (надеюсь, не очень) и не вызовет
трудностей.

Рассмотрим некоторые свойства и функции TwebBrowser.

    procedure GoBack;
    procedure GoForward;
    procedure GoHome;
    procedure GoSearch;
    procedure Refresh;
    procedure Stop;
    procedure Quit;

Названия этих процедур говорят сами за себя, а позволяют они осуществить
управление просмотром - перейти по истории просмотра вперед, назад,
перейти на страницу, установленную как домашняя, открыть страницу
поиска, обновить текущую страницу, остановить загрузку страницы, выйти.

Последняя команда самая интересная - в Help написано, что использовать
ее не надо. Она завершает работу IE и очищает окно. Но я проверял -
вроде вреда от ее использования не наблюдалось.

Далее идет целая группа процедур:

    procedure Navigate(const URL: WideString); overload;
    procedure Navigate(const URL: WideString; var Flags: OleVariant);
              overload;
    procedure Navigate(const URL: WideString; var Flags: OleVariant;
                       var TargetFrameName: OleVariant); overload;
    procedure Navigate(const URL: WideString; var Flags: OleVariant;
                       var TargetFrameName: OleVariant;
                       var PostData: OleVariant); overload;
    procedure Navigate(const URL: WideString; var Flags: OleVariant;
                       var TargetFrameName: OleVariant;
                       var PostData: OleVariant;
                       var Headers: OleVariant); overload;

Все они предназначены для указания того, какая и как страница должна
отображаться в браузере. В простейшем случае можно использовать первую
процедуру

    procedure Navigate(const URL: WideString);

Например так:

    WebBrowser1.Navigate('http://delphi.vitpc.com/');

Или

    WebBrowser1.Navigate('http://delphi.vitpc.com/',
                         empty,empty,empty,empty)

Для значения Flag определены такие константы:

Константа          | Значение |Описание
-------------------|----------|-------------------
navOpenInNewWindow | 1        |Открывает URL в новом окне браузера
navNoHistory       | 2        |Не заносит адрес в список History.
navNoReadFromCache | 4        |Не использует сохраненную в кеше страницу, а загружает с сервера.
navNoWriteToCache  | 8        |Не записывает страницу в дисковый кеш.
navAllowAutosearch | 16       |Если броузер не может найти указанный домен, он передает его в поисковый механизм.

Все, это можно также вручную установить в настройках браузера.

`TargetFrameName` указывает имя фрейма, куда надо загрузить страницу. Если
присвоить NULL страница просто загрузиться в текущее окно.

`PostData` - указывает на данные, которые нужно отослать, используя метод
HTTP POST. Если установить в NULL, процедура Navigate будет использовать
метод HTTP GET.

Следующая довольно интересная и полезная процедура

    procedure ExecWB(cmdID: OLECMDID; cmdexecopt: OLECMDEXECOPT);
              overload;

Позволяет осуществить управление браузером и вызывать различные
дополнительные функции - печать, сохранение и др. Использует
IoleCommandTarget интерфейс для управления браузером.

`CmdID` - задает команду, которую нужно выполнить. Может принимать
следующие значения:

- OLECMDID_OPEN,
- OLECMDID_NEW,
- OLECMDID_SAVE,
- OLECMDID_SAVEAS,
- OLECMDID_SAVECOPYAS,
- OLECMDID_PRINT,
- OLECMDID_PRINTPREVIEW,
- OLECMDID_PAGESETUP,
- OLECMDID_SPELL,
- OLECMDID_PROPERTIES,
- OLECMDID_CUT,
- OLECMDID_COPY,
- OLECMDID_PASTE,
- OLECMDID_PASTESPECIAL,
- OLECMDID_UNDO,
- OLECMDID_REDO,
- OLECMDID_SELECTALL,
- OLECMDID_CLEARSELECTION,
- OLECMDID_ZOOM,
- OLECMDID_GETZOOMRANGE,
- OLECMDID_UPDATECOMMANDS,
- OLECMDID_REFRESH,
- OLECMDID_STOP,
- OLECMDID_HIDETOOLBARS,
- OLECMDID_SETPROGRESSMAX,
- OLECMDID_SETPROGRESSPOS,
- OLECMDID_SETPROGRESSTEXT,
- OLECMDID_SETTITLE,
- OLECMDID_SETDOWNLOADSTATE,
- OLECMDID_STOPDOWNLOAD,
- OLECMDID_FIND,
- OLECMDID_ONTOOLBARACTIVATED,
- OLECMDID_DELETE,
- OLECMDID_HTTPEQUIV,
- OLECMDID_ENABLE_INTERACTION,
- OLECMDID_HTTPEQUIV_DONE,
- OLECMDID_ONUNLOAD,
- OLECMDID_PROPERTYBAG2,
- OLECMDID_PREREFRESH

Если присмотреться, то можно увидеть, что некоторые из них дублируються
процедурами Stop, Refresh и др. Но большенство очень даже нужные.

`Cmdexecopt` - указывает дополнительно, как команда должна исполняться.
Может принимать значения:

Константа          | Значение |Описание
-------------------|----------|-------------------
OLECMDEXECOPT_DODEFAULT       |0 |Команда исполняеться так, как принято по умолчанию.
OLECMDEXECOPT_PROMPTUSER      |1 |Перед выполнением выводиться окно диалога или дополнительных настроек.
OLECMDEXECOPT_DONTPROMPTUSER  |2 |Не задаеться никаких вопросов.
OLECMDEXECOPT_SHOWHELP        |3 |Выводиться справка по запрошеному действии, но сама команда не выполняеться. Удобно для вызова из вашего приложения справки по IE.

Вызывать эту комманду желательно и даже нужно в блоке

    try
        WebBrowser1.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_PROMPTUSER);
    except
    end;

Эта команда вызывает диалоговое окно печати документа. Если же опустить
`try...except`, то при нажатии "Отмена" в этом окне будет сгенерировано
уведомление об ошибке типа:

    raised exception class EOleException with message
    "Невозможно установить свойство coISpan.
     Недопустимое значения свойства.
     Требуется ввести значение от 1 до 1000".

Теперь поговорим о свойствах.

`PopupMenu;` Как оконный элемент управления, TwebBrowser поддерживает
всплывающие меню. НО! Ваше меню будет появляться только пока в браузер
не загружена страница. Дальше - только меню IE.

В Конференции предложили такой вариант для запрета появления
стандартного меню

    ...
    private
      { Private declarations }
    procedure WMMouseActivate(var Msg: TMessage); message WM_MOUSEACTIVATE;
    public
      { Public declarations }
    end;
    ...
    ...
    procedure TForm1.WMMouseActivate(var Msg: TMessage);
    begin
      try
        inherited;
        // right mouse button
        if Msg.LParamHi = 516 then
           Msg.Result:= MA_NOACTIVATEANDEAT;
        // insert code here for show own context menu
      except
      end;
    end;


`property OffLine : WordBool;` Позволяет загружать документы из локального
кеша - если присвоить True.

`property LocationURL: WideString;` Помечено как "только для чтения" и
содержит URL ресурса, загруженого в браузер.

Теперь события.

Среди самых важных/нужных есть:

- OnDownloadBegin
- OnDownloadComplete
- OnBeforeNavigate2
- OnNewWindow2
- OnNavigateComplete2
- OnDocumentComplete

`OnDownloadBegin` - происходит, когда вы, наберя URL, хотите перейти по
нему. Тут можно задать например анимацию или ProgressBar для индикации
процесса загрузки страницы ( совмесно с `OnProgressChange`).

`OnDownloadComplete, OnDocumentComplete, OnNavigateComplete2` -
происходят, когда страница закончила грузиться.

Правда, здесь есть много нюансов при загрузке страниц с графикой и
фреймами - для каждого загружаемого элемента будут генерироваться новые
события начала/окончания загрузки, а кроме того, если отключить загрузку
рисунков/анимации/видео, так вообще некоторые из них не будут
происходить! Так что пользоваться ими нужно осторожно.

`OnBeforeNavigate2` - происходит когда вы переходите по щелчку на
гиперссылке из основной страницы, загруженной в браузер. Сюда можно
писать код, который например, анализирует - куда пользователь переходит,
и соответственно, что-то делать. Или запретить открывание новых окно,
или открывать свои окна (типа сделать TtabbedNotebook c IE на каждой
странице)

`OnNewWindow2` - происходит, когда открывается новое окно браузера.

Я, конечно, много чего упустил - например, работу с интерфейсами, доступ
к тегам страницы - но надеюсь, эта статья и пример помогут вам сделать
работоспособный браузер для дальнейших эксперементов. Успехов!

