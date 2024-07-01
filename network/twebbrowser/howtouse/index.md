---
Title: Использование TWebBrowser (статья)
Date: 01.01.2007
Author: Тенцер А.Л., tolik@katren.nsk.ru
---


Использование TWebBrowser (статья)
==================================

Во многих современных программах требуется работа с данными в формате
HTML. В качестве средства для просмотра таких данных в Delphi
используется ActiveX компонент TWebBrowser, который использует компонент
WebBrowser, входящий в состав Microsoft Internet Explorer. Таким
образом, он имеется на любом компьютере, на котором установлен Internet
Explorer. Все последние версии Windows включают этот компонент в
стандартной поставке и, более того, практически неработоспособны без
него.

**Базовые операции**

Для того, чтобы использовать TWebBrowser в своей программе необходимо
разместить на форме соответствующий компонент, размещенный на закладке
Internet. После этого, чтобы отобразить в нем страницу HTML, необходимо
вызвать его метод Navigate

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Flags, TargetFrameName, PostData, Headers: OleVariant;
    begin
      WebBrowser1.Navigate('http://www.borland.com', Flags, 
        TargetFrameName, PostData, Headers);
    end;

Рассмотрим подробнее параметры, передаваемые в метод Navigate.

Первым параметром передается строка с URL, указывающим адрес, из
которого должна осуществляться загрузка. Поддерживаются все протоколы,
доступные в IE, например file:// - загрузка файла, res:// - загрузка из
ресурса.

Остальные параметры не являются обязательными и служат для передачи
дополнительной информации.

`Flags` - Целое число, представляющее из себя битовую маску из
следующих флагов:

    1  Открыть ресурс в новом окне
    2  Не добавлять страницу в историю просмотренных
    4  Не загружать страницу из кэша
    8  Не сохранять страницу в кэше

`TargetFrameName` - Задает имя фрейма, в который будет загружена страница.

`PostData` - Задает данные для запроса с сервера методом HTTP POST.
Если этот параметр пустой - используется метод GET.

`Headers` - Задает дополнительные заголовки HTTP.

Наиболее интересным является параметр PostData, позволяющий передать на
Web-Server данные, полученные в результате заполнения формы, если этот
сервер требует HTTP - транзакции POST. Например, следующий фрагмент
кода передает на сервер имя пользователя и пароль, заполненные в форме
Delphi

    var
      LoginDialog: TLoginDialog;
      Flags, TargetFrameName, PostData, Headers: OleVariant;
      S: String;
     
    ...
    with TLoginDialog.Create(Application) do 
    try
      if ShowModal = mrOk then 
      begin
        S := Format('UserName=%s&Password=%s', [Edit1.Text, Edit2.Text]);
        PostData := VarArrayCreate([1, Length(S) + 1], varByte);
        System.Move(S[1], VarArrayLock(PostData)^, Length(S) + 1);
        VarArrayUnlock(PostData);
        Headers := 
          'Content-Type: application/x-www-form-urlencoded'#10#13;
        WebBrowser1.Navigate('http://intranetserver/secretpage', Flags,
          TargetFrameName, PostData, Headers);
      end;
    finally
      Free;
    end;

На Web-сервере этот запрос может быть обработан, например,
следующим ASP - скриптом:

      Dim sConnect
      Dim sUserName
      Dim sPassword
      sUserName = Request.Form("User")
      sPassword = Request.Form("Pass"
      sConnect = "Provider=SQLOLEDB.1;Persist Security Info=True;" & _
                 "Initial Catalog=Katren;Data Source=DBSERVER;" & _
                 "Password=" & sPassword & _
                 ";User ID=" & sUserName
      Session("ConnectString") = sConnect

После того как данные получены, необходимо дать пользователю возможность
для работы с ними. Многие функции TWebBrowser доступны через метод
ExecWB, предоставляющий простой способ обращения к интерфейсу
IOleCommandTarget.

Этот метод имеет вид:

    procedure TWebBrowser.ExecWB(
      cmdID: OLECMDID;            // идентификатор команды
      cmdexecopt: OLECMDEXECOPT;  // параметры выполнения
      var pvaIn,                  // дополнительные параметры,
      pvaOut: OleVariant          // зависящие от команды
    ); safecall;

CmdID может быть одной из констант OLECMDID, определенных в файле
ShDocVw.pas.

Параметр cmdexecopt может принимать одно из следующих четырех значений:

- `OLECMDEXECOPT_DODEFAULT`       Выполнить команду с настройками «по умолчанию»
- `OLECMDEXECOPT_PROMPTUSER`      Запросить у пользователя настройки для выполнения команды (например, при печати - вывести диалог Print Setup)
- `OLECMDEXECOPT_DONTPROMPTUSER`  Выполнить команду не запрашивая пользователя
- `OLECMDEXECOPT_SHOWHELP`        Вывести справку о команде

Параметры `pvaIn` и `pvaOut` - дополнительные и зависят от конкретной команды.

Имеется возможность запросить у TWebBrowser доступность той или иной
команды при помощи функции:

    function TWebBrowser.QueryStatusWB(
                 cmdID: OLECMDID   // идентификатор команды
             ): OLECMDF; safecall;

Функция возвращает битовую маску из следующих значений:

- `OLECMDF_SUPPORTED` Команда поддерживается
- `OLECMDF_ENABLED`   Команда поддерживается и разрешена
- `OLECMDF_LATCHED`   Команда - переключатель и сейчас включена
- `OLECMDF_NINCHED`   Зарезервировано

Таким образом, можно настраивать интерфейс, в зависимости от
поддерживаемых текущей версией TWebBrowser возможностей:

    var
      Flags: OLECMDF;
     
    ...
     
    Flags := WebBrowser1.QueryStatusWB(OLECMDID_COPY);
    ActionCopy.Visible := (Flags and OLECMDF_SUPPORTED) = 
      OLECMDF_SUPPORTED;
    ActionCopy.Enabled := (Flags and OLECMDF_ENABLED) = 
      OLECMDF_ENABLED;

Для печати содержимого TWebBrowser служит команда OLECMDID\_PRINT. Метод
печати, может выглядеть, например, следующим образом:

    procedure TForm1.ActionPrintExecute(Sender: TObject);
    var
      A, B: OleVariant;
      UserAction: Cardinal;
    begin
      if Sender = ActionPrintWithSetup then
        UserAction := OLECMDEXECOPT_PROMPTUSER
      else
        UserAction := OLECMDEXECOPT_DONTPROMPTUSER;
      try
        WebBrowser1.ExecWB(OLECMDID_PRINT, UserAction, A, B);
      except
      end;
    end;

Блок `try ... except ... end` необходим, поскольку TWebBrowser при
выполнении любой команды при помощи ExecWB генерирует исключение
`EOleException` с кодом:

    -2147221248 ($80040100) Trying to revoke a drop target
     that has not been registered.

Начиная с Internet Explorer 5 документированы дополнительные команды,
поддерживаемые через интерфейс IOleCommandTarget. Они существенно
расширяют возможности по управлению компонентом, однако недоступны, либо
не документированы в версии 4. Это создает определенные сложности при
программировании. Например, чтобы организовать поиск внутри загруженной
страницы необходим следующий код:

    const
      // Недокументированная константа
      CGID_IE4: TGUID = '{ed016940-bd5b-11cf-ba4e-00c04fd70816}';
      // Документировано в IE5 SDK
      CGID_MSHTML: TGUID = '{DE4BA900-59CA-11CF-9592-444553540000}';
      IDM_FIND = 67;
     
    procedure TForm1.ActionFindExecute(Sender: TObject);
    var
      A, B: OleVariant;
      Target: IOleCommandTarget;
      OleCmd: TOLECMD;
    begin
      // Получаем интерфейс IOleCommandTarget
      Target := wbMain.Document as IOLECommandtarget;
      with OleCmd do
      begin
        cmdId := IDM_FIND;
        cmdf  := 0;
      end;
      // Запрашиваем, поддерживается ли команда
      Target.QueryStatus(@CGID_MSHTML, 1, @OleCmd, NIL);
      if (OleCmd.cmdf and OLECMDF_SUPPORTED) = OLECMDF_SUPPORTED then
        // Да, у нас IE5+ - вызываем документированным способом
        Target.Exec(@CGID_MSHTML, IDM_FIND, 
          OLECMDEXECOPT_DODEFAULT, A, B)
      else
        // Нет, у нас IE4 - вызываем недокументированным способом
        Target.Exec(@CGID_IE4, 1, OLECMDEXECOPT_DODEFAULT, A, B);
    end;

Использование недокументированного вызова в данном случае оправдано,
т.к. в версии 4 этот вызов уже не будет изменяться, а в версию 5 мы
обнаруживаем и используем документированный метод. В то же время IE4 еще
достаточно распространен и совсем лишать программу возможности поиска на
таких компьютерах не оправдано.

**Тонкая настройка**

Если необходима более тонкая настройка компонента - необходимо
реализовать интерфейс IDocHostUIHandler, позволяющий программисту взять
под контроль поведение TWebBrowser.

Интерфейс объявлен как:

    type
      TDocHostInfo = packed record
        cbSize: ULONG;
        dwFlags: DWORD;
        dwDoubleClick: DWORD;
      end;
     
    const
      DOCHOSTUIFLAG_DIALOG = 1;
      DOCHOSTUIFLAG_DISABLE_HELP_MENU = 2;
      DOCHOSTUIFLAG_NO3DBORDER = 4;
      DOCHOSTUIFLAG_SCROLL_NO = 8;
      DOCHOSTUIFLAG_DISABLE_SCRIPT_INACTIVE = 16;
      DOCHOSTUIFLAG_OPENNEWWIN = 32;
      DOCHOSTUIFLAG_DISABLE_OFFSCREEN = 64;
      DOCHOSTUIFLAG_FLAT_SCROLLBAR = 128;
      DOCHOSTUIFLAG_DIV_BLOCKDEFAULT = 256;
      DOCHOSTUIFLAG_ACTIVATE_CLIENTHIT_ONLY = 512;
     
    const
      DOCHOSTUIDBLCLK_DEFAULT = 0;
      DOCHOSTUIDBLCLK_SHOWPROPERTIES = 1;
      DOCHOSTUIDBLCLK_SHOWCODE = 2;
    type
      IDocHostUIHandler = interface(IUnknown)
        ['{bd3f23c0-d43e-11cf-893b-00aa00bdce1a}']
        function ShowContextMenu(const dwID: DWORD; const ppt: PPOINT;
          const pcmdtReserved: IUnknown; 
          const pdispReserved: IDispatch): HRESULT; stdcall;
        function GetHostInfo(var pInfo: TDOCHOSTUIINFO): HRESULT; 
          stdcall;
        function ShowUI(const dwID: DWORD; 
          const pActiveObject: IOleInPlaceActiveObject;
          const pCommandTarget: IOleCommandTarget; 
          const pFrame: IOleInPlaceFrame;
          const pDoc: IOleInPlaceUIWindow): HRESULT; stdcall;
        function HideUI: HRESULT; stdcall;
        function UpdateUI: HRESULT; stdcall;
        function EnableModeless(const fEnable: BOOL): HRESULT; stdcall;
        function OnDocWindowActivate(const fActivate: BOOL): HRESULT; 
          stdcall;
        function OnFrameWindowActivate(const fActivate: BOOL): HRESULT; 
          stdcall;
        function ResizeBorder(const prcBorder: PRECT;
          const pUIWindow: IOleInPlaceUIWindow;
          const fRameWindow: BOOL): HRESULT; stdcall;
        function TranslateAccelerator(const lpMsg: PMSG; 
          const pguidCmdGroup: PGUID;
          const nCmdID: DWORD): HRESULT; stdcall;
        function GetOptionKeyPath(var pchKey: POLESTR; 
          const dw: DWORD): HRESULT; stdcall;
        function GetDropTarget(const pDropTarget: IDropTarget;
          out ppDropTarget: IDropTarget): HRESULT; stdcall;
        function GetExternal(out ppDispatch: IDispatch): HRESULT; 
          stdcall;
        function TranslateUrl(const dwTranslate: DWORD; 
          const pchURLIn: POLESTR; var ppchURLOut: POLESTR): HRESULT;
          stdcall;
        function FilterDataObject(const pDO: IDataObject;
          out ppDORet: IDataObject): HRESULT; stdcall;
      end; 

Наследник TWebBrowser, реализующий этот интерфейс должен быть объявлен
как

    type
      TCustomizedWebBrowser = class(TWebBrowser, IDocHostUIHandler)
        // Реализация методов IDocHostUIHandler
      end;

Код такого компонента, реализующего минимальную функциональность
приведен на CD-ROM. Вы можете использовать его как основу для создания
своих расширенных наследников TWebBrowser.

Рассмотрим наиболее интересные с точки зрения программиста методы
интерфейса IDocHostUIHandler.

    function ShowContextMenu(const dwID: DWORD; const ppt: PPOINT;
      const pcmdtReserved: IUnknown;
      const pdispReserved: IDispatch): HRESULT;

Эта функция вызывается, когда TWebBrowser должен показать контекстное
меню. Если Вы отображаете собственное меню, либо хотите подавить меню -
функция должна вернуть S\_OK, если меню должен показать TWebBrowser -
S\_FALSE.

В неё передаются следующие параметры:

`DwID` - идентификатор меню, который может принимать одно из следующих
значений констант:

    CONTEXT_MENU_DEFAULT   = 0;
    CONTEXT_MENU_IMAGE     = 1;
    CONTEXT_MENU_CONTROL   = 2;
    CONTEXT_MENU_TABLE     = 3;
    CONTEXT_MENU_DEBUG     = 4;
    CONTEXT_MENU_1DSELECT  = 5;
    CONTEXT_MENU_ANCHOR    = 6;
    CONTEXT_MENU_IMGDYNSRC = 7;

в зависимости от значения идентификатора Вы можете вывести подходящее
меню.

`ppt` - координаты, в которых должно быть показано меню

`pcmdtReserved` - интерфейс IOleCommandTarget, позволяющий запросить
состояние команд и их выполнение

`pdispReserved` - интерфейс IDispatch объекта, для которого вызывается меню

Простейшая реализация этого метода может выглядеть следующим образом:

    function TcustomizedWebBrowser.ShowContextMenu(const dwID: DWORD;
      const ppt: PPOINT;  const pcmdtReserved: IUnknown; 
          const pdispReserved: IDispatch): HRESULT;
    begin
      // Предполагаем, что поле FPopupMenu хранит ссылку
      // на компонент TPopupMenu
      if Assigned(FPopupMenu) then begin
        pmContext.Popup(ppt.X, ppt.Y);
        Result := S_OK;
      end 
      else Result := S_FALSE;
    end;

Для полного запрета контекстного меню метод должен всегда возвращать
S\_OK.

    function GetHostInfo(var pInfo: TDocHostInfo): HRESULT; stdcall;

Приложение может заполнить структуру pInfo, определенную как:

    TDocHostInfo = packed record
      cbSize: ULONG;
      dwFlags: DWORD;
      dwDoubleClick: DWORD;
    end;

`dwFlags` - битовая маска из следующих флагов:

Флаг                                 |Назначение
-------------------------------------|-----------------------
DOCHOSTUIFLAG_DIALOG                 |Запрещает выделение текста в форме
DOCHOSTUIFLAG_DISABLE_HELP_MENU      |Запрещает контекстное меню
DOCHOSTUIFLAG_NO3DBORDER             |Подавляет вывод 3-мерной рамки вокруг компонента
DOCHOSTUIFLAG_SCROLL_NO              |Отключает полосы прокрутки
DOCHOSTUIFLAG_DISABLE_SCRIPT_INACTIVE|Запрещает исполнение скриптов
DOCHOSTUIFLAG_OPENNEWWIN             |Открывает ссылки в новых окнах
DOCHOSTUIFLAG_FLAT_SCROLLBAR         |Использует плоский стиль для полос прокрутки
DOCHOSTUIFLAG_DIV_BLOCKDEFAULT       |При вводе возврата каретки в режиме редактирования будет использоваться тег \<DIV\>, вместо \<P\>
DOCHOSTUIFLAG_ACTIVATE_CLIENTHIT_ONLY|Компонент получает фокус только при щелчке мышью в клиентской области окна. При щелчке в не клиентской области (например на полосе прокрутке) компонент фокуса не получает.

`dwDoubleClick` задает реакцию на двойной щелчок мышью и может принимать
одно из следующих значений:

Флаг|Назначение
----|----------------------------------------------------------------------------
DOCHOSTUIDBLCLK_DEFAULT                      |Выполнять действие «по умолчанию»
DOCHOSTUIDBLCLK_SHOWPROPERTIES               |Показывать окно свойств страницы
DOCHOSTUIDBLCLK_SHOWCODE|Показывать HTML-код страницы
DOCHOSTUIFLAG_DIALOG| Метод должен вернуть S\_OK или код ошибки OLE

Например, чтобы создать окно с плоскими полосами прокрутки и без
3-мерной рамки необходимо реализовать этот метод следующим образом:

    function TCustomizedWebBrowser.GetHostInfo(
      var pInfo: TDocHostInfo): HRESULT; stdcall; 
    begin
      with pInfo do
        dwFlags := dwFlags or DOCHOSTUIFLAG_NO3DBORDER or 
          DOCHOSTUIFLAG_FLAT_SCROLLBAR;
      Result := S_OK;
    end;
     
    function TranslateAccelerator(const lpMsg: TMsg;
      const pguidCmdGroup: TGUID; nCmdID: DWORD): HRESULT; stdcall;

Позволяет перехватить исполнение команд и обработку «горячих» клавиш и
заменить её на свою.

    function GetOptionKeyPath(var pchKey: PWideChar;
      dwReserved: DWORD): HRESULT; stdcall;

Позволяет задать путь в реестре, который TWebBrowser будет использовать
для хранения настроек. Это дает возможность, например, сделать
используемый в программе компонент независимым от текущих настроек
Internet Explorer\`а.

Путь должен находится под ключом HKEY\_CURRENT\_USER.

Метод должен выделить память под строку функцией CoTackMemAlloc. Даже в
случае ошибки параметр pchKey должен быть инициализирован значением NIL
или адресом строки. Метод возвращает S\_OK в случае успеха или S\_FALSE
в противном случае.

Типичная реализация этого метода может выглядеть следующим образом:

    function TCustomizedWebBrowser.GetOptionKeyPath(
      var pchKey: PWideChar;  dwReserved: DWORD): HRESULT;
    var
      ResultLen: Integer;
    begin
      Result := S_FALSE;
      // В поле TCustomizedWebBrowser.FOptionKeyPath: String 
      // хранится путь к настройкам
      if Length(FOptionKeyPath) > 0 then
      begin
        // Получаем длину строки UNICODE
        ResultLen := MultiByteToWideChar(CP_ACP, 0, 
          PChar(FOptionKeyPath), -1, NIL, 0);
        // Выделяем память под буфер
        pchKey := CoTaskMemAlloc(ResultLen * SizeOf(WideChar));
        // Если выделение успешно – копируем строку в буфер
        if Assigned(pchKey) then 
        begin
          MultiByteToWideChar(CP_ACP, 0, PChar(FOptionKeyPath), -1, 
            pchKey, ResultLen);
          Result := S_OK;
        end;
      end else begin
        // Свойство не задано – инициализируем параметр в NIL
        pchKey := NIL;
      end;
    end;

Существует ряд настроек, которые, несмотря на наличие обработчика
GetOptionKeyPath в любом случае берутся из стандартных параметров
Internet Explorer. Наиболее важными из них являются колонтитулы,
используемые при печати. В версиях Internet Explorer до 5.5 включительно
единственным способом изменить (или подавить) колонтитулы является
запись новых значений в ключ реестра:

    HKCU\Software\Microsoft\Internet Explorer\PageSetup

перед печатью и восстановление их после печати.

    function GetExternal(var ppDispatch: IDispatch): HRESULT; stdcall;

Позволяет вернуть указатель на реализованный в Вашем приложении
интерфейс IDispatch, который будет доступен для скриптов в TWebBrowser.
Если Вы не реализуете этого интерфейса - параметр ppDispatch должен
быть инициализирован в NIL. Метод возвращает S\_OK в случае успеха или
код ошибки OLE в случае ошибки.

Методы этого интерфейса доступны из скриптов, выполняющихся в
TWebBrowser следующим образом:

    window.external.MethodName

Реализовать IDispatch можно, например, при помощи класса TAutoObject.

    function TranslateURL(dwTranslate: DWORD; pchURLIn: PWideChar;
      var ppchURLOut: PWideChar): HRESULT; stdcall;

Позволяет изменить URL по которому осуществляется загрузка страницы.

`pchURLIn` указывает на строку, содержащую исходный URL. Если Ваше
приложение осуществляет трансляцию, оно должно выделить память под новое
значение используя функцию CoTaskMemAlloc, заполнить буфер новым
значением URL и вернуть S\_OK.

В противном случае Вы должны присвоить ppchURLOut значение NIL и вернуть
S\_FALSE. В случае возникновения ошибки метод должен вернуть OLE-код
ошибки.

Обработчик вызывается только при интерактивном переходе по ссылке из
TWebBrowser и не вызывается при переходе при помощи метода Navigate.

**Доступ к документной модели TWebBrowser**

В Internet Explorer реализовано расширение HTML, под названием Dynamic
HTML (DHTML). Эта модель представляет все элементы HTML-документа в виде
набора коллекций объектов, доступных для изменения. Скрипты, встроенные
в страницы и приложения, имеющие доступ к этим коллекциям могут находить
и изменять их элементы, добавлять новые, причем изменения будут
немедленно отражены в окне TWebBrowser. Иерархическое объектное
представление HTML объектов называется DOM (Document Object Model).

DOM в IE ActiveX доступна программисту в виде набора COM интерфейсов.
Отправной точкой для доступа к ней служит свойство

    property Document: IDispatch;

Это свойство обеспечивает доступ к интерфейсу, IHtmlDocument2
позволяющему работать с содержимым документа. Для получения интерфейса
необходимо запросить его при помощи оператора `as`

    var
    Document: IHtmlDocument2;
    ...
    Document := WebBrowser.Document as IHtmlDocument2;

Документ в DOM представляет из себя набор коллекций элементов. Для
доступа к коллекции служит интерфейс IHtmlElementCollection, а к
элементу коллекции - IHtmlElement. Следующий пример выводит все тэги,
имеющиеся в текущем документе и текст внутри тэгов.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      HtmlDocument: IHtmlDocument2;
      HtmlCollection: IHtmlElementCollection;
      HtmlElement: IHtmlElement;
      I: Integer;
    begin
      Memo1.Lines.Clear;
      HtmlDocument := WebBrowser.Document as IHtmlDocument2;
      HtmlCollection := HtmlDocument.All;
      for I := 0 to HtmlCollection.Length - 1 do begin
        HtmlElement := HtmlCollection.Item(i, 0) as IHtmlElement;
        Memo1.Lines.Add(HtmlElement.TagName + ' ' +
          HtmlElement.InnerText);
    end;

Возможно динамическое создание документов в памяти, без необходимости
записи их на диск и вызова метода Navigate с протоколом \'file://\'

Проиллюстрируем работу с документной модели TWebBrowser на примере.
Расположим на форме компоненты TWebBrowser, TMemo и три TButton, и
создадим следующие обработчики событий:

    uses MSHTML, ActiveX;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Инициализируем пустой документ в TWebBrowser
      WebBrowser1.Navigate('about:blank');
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Document: IHTMLDocument2;
      V: OleVariant;
    begin
      // Этот метод переписывает в TWebBrowser HTML-
      // документ из TMemo
      Document := WebBrowser1.Document as IHtmlDocument2;
      V := VarArrayCreate([0, 0], varVariant);
      V[0] := Memo1.Text;
      Document.Write(PSafeArray(TVarData(v).VArray));
      Document.Close;
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    var
      Document: IHTMLDocument2;
      Collection: IHTMLElementCollection;
      Element: IHTMLElement;
      I: Integer;
    begin
      // Этот метод модифицирует текст документа при помощи DHTML
      Document := WebBrowser1.Document as IHtmlDocument2;
      Collection := Document.all;
      Collection := Collection.Tags('BODY') as IHTMLElementCollection;
      Element := Collection.Item(NULL, 0) as IHTMLElement;
      Element.InnerText := 'Modifyed by DHTML';
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      Document: IHTMLDocument2;
    begin
      // Этот метод позволяет просмотреть в TMemo код HTML
      // документа из TWebBrowser
      Document := WebBrowser1.Document as IHtmlDocument2;
      Memo1.Text := (Document.all.Item(NULL, 0) 
        as IHTMLElement).OuterHTML;
    end;

В Memo1.Lines в дизайнере запишем следующий текст:

    <HTML>
    <HEAD>
       <TITLE>Hello World</TITLE>
    </HEAD>
    <BODY>
      Hello again !
    </BODY>
    </HTML>

Таким образом, мы получили возможность динамически создавать HTML
документы и предоставлять их пользователю.

Тенцер А. Л.  
ICQ UIN 15925834  
tolik@katren.nsk.ru
