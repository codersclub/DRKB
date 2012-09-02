<h1>Пространство имен оболочки Windows</h1>
<div class="date">01.01.2007</div>

Автор: Акжан Абдулин  </p>
<p>Введение </p>
<p>В операционных системах компании Microsoft с 1995 года используется новая оболочка, построенная на основе компонентной объектной модели. Одним из нововведений оболочки операционной системы стало понятие пространства имён оболочки. Пространство имён оболоч ки являет собой иерархически упорядоченный мир объектов, известных операционной системе, с их свойствами и предоставляемыми действиями. Оно во многом сходно со структурой файловой системы, но включает в себя не только файлы и каталоги. Такие понятия файло вой системы, как имя файла и путь, заменены более универсальными. </p>
<p>Основное пространство имён начинается с корневого объекта "Рабочий стол", и его легко исследовать, запустив приложение "Проводник". Параллельно основному пространству имён могут сосуществовать множество дополнительных пространств имён, о которых подробнее будет рассказано позднее. </p>
<p>Основные понятия </p>
<p>Пространство имён (Shell namespace) является древовидной структурой, состоящей из COM-объектов. Объекты, владеющие дочерними объектами, именуются папками (Shell folder), причём среди таковых могут оказаться и другие папки (Subfolders). Объекты, не владеющ ие дочерними объектами, именуются файловыми объектами (file objects), причём файловым объектом может представлять собой не только файл файловой системы, но и принтер, компонент "Панели Управления" или объект другого типа. Каждый объект имеет идентификатор элемента (Item identifier), однозначно определяющий его расположение в папке. Таким образом, чтобы указать на некий объект в данной папке, нам потребуется лишь передать его идентификатор. Если же мы хотим указать на некий объект в известном пространстве имён, тогда нам придётся указать идентификаторы всех папок, начиная с корня, и до самого объекта включительно. В качестве примера приведём аналогию из файловой системы: </p>
<p>"C:\Мои документы\Доклад о возможных способах реализации интерфейса к корпоративной БД.doc" уникально представит файл относительно файловой системы известного (моего домашнего) компьютера. </p>
<p>То, что в файловой системе именуется путём к файлу, в пространстве имён именуется списком идентификаторов (Identifier List). </p>
<p>Объекты-папки знают о тех обьектах, которыми они владеют, и о тех операциях, которые с ними возможны. Папки предоставляют нам механизм для перечисления всех объектов, которыми данный объект-папка владеет - интерфейс IShellFolder. Получение от объекта указ ателя на данный интерфейс называется привязкой (Binding). </p>
<p>Большая часть объектов основного пространства имён оболочки являются объектами, представляющими часть файловой системы. Те же объекты, что не представлены в файловой системе, называются виртуальными. Такие виртуальные папки, как папки рабочего стола (Desk top), "Мой Компьютер" (My Computer) и "Сетевое окружение" (Network Neighborhood), позволяют реализовать унифицированное пространство имён. </p>
<p>Каталоги файловой системы, используемые оболочкой в особых целях, называются специальными. Одной из таких папок, например, является папка "Программы" (Programs). Местонахождение специальных папок файловой системы указывается в подразделе ветви HKEY_CURREN T_USER/Software/Microsoft/Windows/CurrentVersion/Explorer/Shell Folders/. </p>
<p>Идентификаторы элементов </p>
<p>Идентификатор элемента является уникальным для той папки, в которой данный элемент (объект пространства имён оболочки) находится, и является двоичной структурой переменного размера, чей формат определяется тем программным обеспечением, которое поддерживае т существование папки, владеющей определяемым данным идентификатором объектом. Идентификатор элемента имеет смысл только в контексте той папки, которая его сконструировала. </p>
<p>Идентификатор элемента описывается структурой SHITEMID, для которой определено лишь значение первого поля - размер данной структуры. </p>
<p>Список идентификаторов, уникально идентифицирующих объект в определённом пространстве имён, эквивалентен понятию пути для файловой системы, и определяется как список из последовательно расположенных идентификаторов, за которыми следует завершающее список 16-битное значение 0x0000 (ITEMIDLIST). Список идентификаторов может быть как абсолютным, то есть определяющим положение объекта относительно корневой папки, так и относительным, то есть определяющим положение элемента относительно какой-либо конкретной п апки. </p>
<p>Приложение оперирует понятием указателя на список идентификаторов (Pointer to an Identifier List), который кратко именуют как PIDL-указатель. Все глобальные методы (утилиты) оболочки, принимающие в качестве одного из параметров PIDL-указатель, ожидают его в абсолютном формате. В то же время все методы интерфейса IShellFolder, принимающие в качестве одного из параметров PIDL-указатель, ожидают его в относительном формате (если только в описании метода не указано иначе). </p>
<p>Ниже представлена функция, позволяющая получить указатель на следующий элемент в списке идентификаторов. В случае неудачи возвращается пустой указатель. </p>
<pre>
// C/C++
#include 
 
LPITEMIDLIST GetNextItemID(const LPITEMIDLIST pidl)
{
  size_t cb = pidl-&gt;mkid.cb;
  if( cb == 0 )
  {
    return NULL;
  }
  pidl = (LPITEMIDLIST) (((LPBYTE) pidl) + cb);
  if( pidl-&gt;mkid.cb == 0 )
  {
    return NULL;
  }
  return pidl;
}
</pre>
<pre>
// Delphi
uses ShlObj;
 
type
  PByte = ^Byte;
 
function GetNextItemID(pidl: PItemIDList): PItemIDList;
var
  cb: Integer;
begin
  cb := pidl^.mkid.cb;
  if cb = 0 then
  begin
    Result := nil;
    Exit;
  end;
  pidl := PItemIDList ( Integer(PByte(pidl)) + cb );
  if pidl^.mkid.cb = 0 then
  begin
    Result := nil;
    Exit;
  end;
  Result := pidl;
end;
</pre>
<p>За размещение списков идентификаторов отвечает распределитель памяти оболочки (Shell's allocator), предоставляющий интерфейс IMalloc. Указатель на данный интерфейс распределителя памяти оболочки можно получить через метод SHGetMalloc. </p>
<p>Таким образом, если Ваше приложение получает от оболочки PIDL-указатель, то оно становится ответственным за обязательное в дальнейшем освобождение этого списка с помощью распределителя памяти оболочки. </p>
<p>Ниже представлен пример копирования списка идентификаторов: </p>
<pre>
// C++
#include 
 
size_t GetItemIDListSize(const LPITEMIDLIST pidl)
{
  size_t size = 0;
  LPBYTE p = LPBYTE(pidl);
  while( p != NULL )
  {
    if( static_cast(p + size)-&gt;mkid.cb == 0 )
    {
      size += sizeof( USHORT ); // size of terminator;
      break;
    }
    size += static_cast(p + size)-&gt;mkid.cb;
  }
  return size;
}
 
LPITEMIDLIST CopyItemIDList(const LPITEMIDLIST pidl)
{
  LPMALLOC pMalloc;
  LPITEMIDLIST pidlResult;
  if( pidl == NULL )
  {
    return NULL;
  }
  if( ! SUCCEEDED(SHGetMalloc(&amp; pMalloc))
  {
    return NULL;
  }
  size_t size = GetItemIDListSize(pidl);
  pidlResult = pMalloc-&gt;Alloc( size );
  if( pidlResult != NULL )
  {
    CopyMemory( pidlResult, pidl, size );
  }
  pMalloc-&gt;Release();
  return pidlResult;
}
</pre>

<pre>
// Delphi
uses Windows, ActiveX, ShlObj;
 
type
  PByte = ^Byte;
 
function GetItemIDListSize(pidl: PItemIDList): Integer;
var
  p: PChar;
begin
  Result := 0;
  p := PChar(pidl);
  while p &lt;&gt; nil do
  begin
    if PItemIDList(p + Result)^.mkid.cb = 0 then
    begin
      Inc( Result, sizeof(Word) ); // size of terminator;
      break;
    end;
    Inc( Result, PItemIDList(p + Result)^.mkid.cb );
  end;
end;
 
function CopyItemIDList(pidl: PItemIDList): PItemIDList;
var
  pMalloc: IMalloc;
  size: Integer;
begin
  Result := nil;
  if not Assigned( pidl ) then
  begin
    Exit;
  end;
  if not SUCCEEDED(SHGetMalloc(pMalloc)) then
  begin
    Exit;
  end;
  size := GetItemIDListSize(pidl);
  Result := pMalloc.Alloc( size );
  if Assigned(Result) then
  begin
    CopyMemory( Result, pidl, size );
  end;
  pMalloc := nil; // Interface reference releasing
                  // will be proceed automatically
                  // by assigning a nil value
end;
</pre>
<p>Для увеличения эффективности работы Ваших приложений рекомендуется брать ссылку на распределитель памяти оболочки при запуске приложения, и освобождать эту ссылку при выходе из приложения. </p>
<p>Интерфейс IShellFolder предоставляет метод CompareIDs для определения расположения двух идентификаторов относительно друг друга (выше, ниже или равны) в данной папке. При этом параметр lParam определяет критерий упорядочивания, но заранее определённым для всех объектов-папок является только сортировка по имени (значение 0). Если вызов этого метода завершён успешно, то поле CODE возвращаемого значения содержит ноль при равенстве объектов, отрицательно, если первое меньше второго, и положительно в обратном случае. </p>
<pre>
// C/C++
  hr = ppsf-&gt;CompareIDs(0, pidlA, pidlB);
  if( SUCCEEDED(hr) )
  {
    iComparisonResult = short(HRESULT_CODE(hr))
  }
</pre>
<pre>
// Delphi
function HRESULT_CODE(hr: HRESULT): Word;
begin
  Result := Word(LongWord(hr) and $FFFF)
end;
 
  hr := ppsf.CompareIDs(0, pidlA, pidlB);
  if Succeeded(hr) then
  begin
    iComparisonResult := Shortint(HRESULT_CODE(hr));
  end;
</pre>
<p>Местонахождение объектов-папок </p>
<p>Некоторые папки имеют особое значение для оболочки. Для нахождения этих специальных папок, а также для того, чтобы пользователь мог сам искать необходимые ему папки, оболочка предоставляет специализированный набор функций: SHGetDesktopFolder Возвращает ин терфейс IShellFolder объекта-папки "Рабочий стол" (Desktop); </p>
<p>SHGetSpecialFolderLocation Возвращает указатель на список идентификаторов специального объекта-папки. </p>
<p>SHBrowseForFolder Проводит диалог с пользователем и возвращает указатель на список идентификаторов выбранного пользователем объекта-папки; </p>
<p>SHGetSpecialFolderPath Версия 4.71. Возвращает путь файловой системы для специального объекта-папки. Функция предназначена для работы со специальными папками, а не для работы с виртуальными. </p>
<p>При отсутствии нужной папки может, по требованию приложения, её создавать. </p>
<p>Для указания необходимой специальной папки функции SHGetSpecialFolderLocation и SHGetSpecialFolderPath принимают в качестве параметра одно из ниже указанных значений: </p>
<p>CSIDL_DESKTOP Рабочий стол (Desktop) для данного пользователя; Виртуальная папка, являющаяся корнем основного пространства имён оболочки </p>
<p>CSIDL_INTERNET Интернет (Internet); Виртуальная папка, представляющая пространство Internet </p>
<p>CSIDL_PROGRAMS Программы (Programs) для данного пользователя; Каталог файловой системы, содержащий в себе группы программ пользователя, также являющиеся каталогами файловой системы </p>
<p>CSIDL_CONTROLS Панель управления (Control Panel); Виртуальная папка, содержащая в себе набор иконок панели управления </p>
<p>CSIDL_PRINTERS Принтеры (Printers); Виртуальная папка, содержащая в себе инсталлированные принтеры </p>
<p>CSIDL_PERSONAL Мои документы (My Documents); Каталог файловой системы, служащий общим репозиторием для документов </p>
<p>CSIDL_FAVORITES Избранное (Favorites) для данного пользователя; Каталог файловой системы, служащий общим репозиторием избранных пользователем элементов </p>
<p>CSIDL_STARTUP Автозагрузка (Startup) для данного пользователя; Каталог файловой системы, который является пользовательской папкой программ "Автозагрузка". Система запускает эти программы каждый раз, когда данный пользователь входит в Windows NT, или когда стартует Windows 95/98 </p>
<p>CSIDL_RECENT Документы (Documents); Каталог файловой системы, содержащий в себе ссылки на самые последние документы, с которыми недавно работал пользователь </p>
<p>CSIDL_SENDTO Отправить (Send To); Каталог файловой системы, содержащий в себе пункты меню Send To </p>
<p>CSIDL_BITBUCKET Корзина (Recycle Bin); </p>
<p>CSIDL_STARTMENU Главное меню (Start menu) для данного пользователя; Каталог файловой системы, содержащий в себе пункты меню Start </p>
<p>CSIDL_DESKTOPDIRECTORY Каталог файловой системы, хранящий файловые объекты Рабочего стола (Desktop directory) для данного пользователя; </p>
<p>CSIDL_DRIVES Мой компьютер (My computer); Виртуальная папка, содержащая в себе всё, что находится на локальном компьютере: устройства хранения, принтеры и панель управления. Эта папка может также содержать в себе спроецированные сетевые диски </p>
<p>CSIDL_NETWORK Сетевое окружение (Network Neighborhood); Виртуальная папка, представляющая верхний уровень иерархии сети </p>
<p>CSIDL_NETHOOD Каталог файловой системы, хранящий файловые объекты Сетевого окружения (Network Neighborhood); </p>
<p>CSIDL_FONTS Шрифты (Fonts); Виртуальная папка, содержащая шрифты </p>
<p>CSIDL_TEMPLATES Шаблоны (Templates); Каталог файловой системы, служащий общим репозиторием шаблонов документов (пункт контекстного меню оболочки "Создать") </p>
<p>CSIDL_COMMON_STARTMENU Каталог файловой системы, содержащий в себе общие пункты меню Start, которые появляются у всех пользователей; </p>
<p>CSIDL_COMMON_PROGRAMS Каталог файловой системы, содержащий в себе общие группы программ пользователя, которые появляются у всех пользователей; </p>
<p>CSIDL_COMMON_STARTUP Каталог файловой системы, содержащий в себе общие программы, которые появляются в папке Startup для всех пользователей; </p>
<p>CSIDL_COMMON_DESKTOPDIRECTORY Каталог файловой системы, хранящий общие файловые объекты Рабочего стола (Desktop directory), которые появляются на рабочих столах всех пользователей; </p>
<p>CSIDL_APPDATA Каталог файловой системы, служащий общим репозиторием данных, специфичных для приложения; </p>
<p>CSIDL_PRINTHOOD Каталог файловой системы, служащий общим репозиторием ссылок на принтеры; </p>
<p>CSIDL_ALTSTARTUP Каталог файловой системы, который является нелокализованной пользовательской папкой программ "Автозагрузка". </p>
<p>CSIDL_COMMON_ALTSTARTUP Каталог файловой системы, содержащий в себе общие программы, которые появляются в нелокализованной папке Startup для всех пользователей; </p>
<p>CSIDL_COMMON_FAVORITES Каталог файловой системы, содержащий в себе общие избранные элементы, которые появляются в папке "Избранное" у всех пользователей; </p>
<p>CSIDL_INTERNET_CACHE Каталог файловой системы, служащий общим репозиторием для временного хранения файлов, кэшируемых при работе с Internet; </p>
<p>CSIDL_COOKIES Каталог файловой системы, служащий общим репозиторием для Internet Cookies; </p>
<p>CSIDL_HISTORY Каталог файловой системы, служащий общим репозиторием для хранения истории работы с Internet; </p>
<p>CSIDL_PROGRAM_FILES Версия 5.00. Каталог файловой системы, в котором должны располагаться программные продукты; </p>
<p>CSIDL_PROGRAM_FILES_COMMON Версия 5.00. Каталог файловой системы, в котором должны располагаться компоненты, общие для группы продуктов. </p>
<p>Необходимо отметить, что эти функции недавно были выделены в отдельную библиотеку - shfolder.dll. </p>
<p>Функция SHBrowseForFolder позволяет ограничить видимое пространство имён, задав в поле pidlRoot корневую папку, с которой будет идти просмотр (по умолчанию - "Рабочий стол"), и указав типы объектов, которые приемлемы в качестве выбранных, в поле ulFlags. </p>
<p>Описание флагов, которые допустимы в поле ulFlags: BIF_BROWSEFORCOMPUTER В качестве выбора допустимы только компьютеры. </p>
<p>BIF_BROWSEFORPRINTER В качестве выбора допустимы только принтеры. </p>
<p>BIF_BROWSEINCLUDEFILES В диалоговом окне, помимо папок, будут также представлены и файлы. </p>
<p>BIF_DONTGOBELOWDOMAIN Не показывать сетевые папки, расположенные ниже уровня домена. </p>
<p>BIF_EDITBOX Версия 4.71. В диалоговом окне будет присутствовать строка редактирования, таким образом пользователь может набрать имя элемента. </p>
<p>BIF_RETURNFSANCESTORS В качестве выбора допустимы только объекты, представленные в файловой системе. </p>
<p>BIF_RETURNONLYFSDIRS В качестве выбора допустимы только каталоги файловой системы. </p>
<p>BIF_STATUSTEXT В диалоговом окне появится строка статуса, функция обратного вызова сожет устанавливать текст в этой строке с помощью посылки сообщений диалоговому окну. </p>
<p>BIF_VALIDATE Версия 4.71. Если пользователь введёт неверное имя в строке редактирования, то диалоговое окно вызовет функцию обратного вызова приложения по сообщению BFFM_VALIDATEFAILED. </p>
<p>Ниже представлен пример работы с функцией SHBrowseForFolder на Delphi. Очень часто приложение использует функцию обратного вызова, чтобы указать исходную папку для просмотра. Здесь мы будем использовать механизм обратного вызова именно для этой цели, а та кже для того, чтобы установить некий текст при инициализации диалога: </p>
<pre>
// Delphi
(*
 * Эта программа показывает на экране диалог выбора папки,
 * где корнем дерева им?н служит папка "Мой компьютер", а текущим
 * каталогом - папка "Файлы программ".
 *)
 
program ShellD;
 
uses
  SysUtils, Windows, ActiveX, ShlObj;
 
var
  Malloc: IMalloc;
  Desktop: IShellFolder;
  pidlMyComputer: PItemIDList;
  pidlResult: PItemIDList;
  pidlInitialFolder: PItemIDList;
 
function BrowseCallbackProc( hWnd: HWND; uMsg: UINT; lParam: LPARAM;
  lpData: LPARAM ): Integer; stdcall; // обратите внимание на соглашение о вызовах -
                                      // stdcall
begin
  Result := 0;
  case uMsg of
    BFFM_INITIALIZED:
    begin
      PostMessage( hWnd, BFFM_SETSELECTION, 0, Integer(pidlInitialFolder) );
      PostMessage( hWnd, BFFM_SETSTATUSTEXT, 0,
        Integer(PChar('Функция обратного вызова установлена.')) );
    end;
  end;
end;
 
function GetProgramFilesDirByKeyStr(KeyStr: string): string;
var
  dwKeySize: DWORD;
  Key: HKEY;
  dwType: DWORD;
begin
  if
    RegOpenKeyEx( HKEY_LOCAL_MACHINE, PChar(KeyStr), 0, KEY_READ, Key ) = ERROR_SUCCESS
  then
  try
    RegQueryValueEx( Key, 'ProgramFilesDir', nil, @dwType, nil, @dwKeySize );
    if (dwType in [REG_SZ, REG_EXPAND_SZ]) and (dwKeySize &gt; 0) then
    begin
      SetLength( Result, dwKeySize );
      RegQueryValueEx( Key, 'ProgramFilesDir', nil, @dwType, PByte(PChar(Result)),
        @dwKeySize );
    end
    else
    begin
      RegQueryValueEx( Key, 'ProgramFilesPath', nil, @dwType, nil, @dwKeySize );
      if (dwType in [REG_SZ, REG_EXPAND_SZ]) and (dwKeySize &gt; 0) then
      begin
        SetLength( Result, dwKeySize );
        RegQueryValueEx( Key, 'ProgramFilesPath', nil, @dwType, PByte(PChar(Result)),
          @dwKeySize );
      end;
    end;
  finally
    RegCloseKey( Key );
  end;
end;
 
// Here is old way to retrieve Program Files folder location,
// Modern way is using of SHGetSpecialFolder (shfolder.dll) with
// CSIDL_PROGRAM_FILES constant.
 
function GetProgramFilesDir: string;
const
  DefaultProgramFilesDir = '%SystemDrive%\Program Files';
var
  FolderName: string;
  dwStrSize: DWORD;
begin
  if Win32Platform = VER_PLATFORM_WIN32_NT then
  begin
    FolderName :=
      GetProgramFilesDirByKeyStr('Software\Microsoft\Windows NT\CurrentVersion');
  end;
  if Length(FolderName) = 0 then
  begin
    FolderName :=
      GetProgramFilesDirByKeyStr('Software\Microsoft\Windows\CurrentVersion');
  end;
  if Length(FolderName) = 0 then FolderName := DefaultProgramFilesDir;
  dwStrSize := ExpandEnvironmentStrings( PChar(FolderName), nil, 0 );
  SetLength( Result, dwStrSize );
  ExpandEnvironmentStrings( PChar(FolderName), PChar(Result), dwStrSize );
end;
 
var
  bi: TBrowseInfo;
  DisplayName: string;
  ProgramFilesDir: WideString;
  CharsDone: ULONG;
  dwAttributes: DWORD;
  Temp: string;
 
begin
  ProgramFilesDir := GetProgramFilesDir;
  // acquire shell's allocator
  if SUCCEEDED( SHGetMalloc( Malloc ) ) then
  try
    // acquire shell namespace root folder
    if SUCCEEDED( SHGetDesktopFolder( Desktop ) ) then
    try
      // acquire folder that will serve as root in dialog
      if SUCCEEDED( SHGetSpecialFolderLocation( 0, CSIDL_DRIVES, pidlMyComputer ) ) then
      try
        // acquire PIDL for folder that will be selected by default
        if
          SUCCEEDED(
            Desktop.ParseDisplayName( 0, nil, PWideChar(ProgramFilesDir), CharsDone,
            pidlInitialFolder, dwAttributes )
          )
        then
        try
          SetLength( DisplayName, MAX_PATH );
          FillChar( bi, sizeof(bi), 0 );
          bi.pidlRoot := pidlMyComputer; // roots from 'My Computer'
          bi.pszDisplayName := PChar( DisplayName );
          bi.lpszTitle := PChar('Выберите папку');
          bi.ulFlags := BIF_STATUSTEXT;
          bi.lpfn := BrowseCallbackProc;
          pidlResult := SHBrowseForFolder( bi );
          if Assigned(pidlResult) then
          try
            SetLength( Temp, MAX_PATH );
            if SHGetPathFromIDList( pidlResult, PChar(Temp) ) then
            begin
              DisplayName := Temp;
            end;
            DisplayName := Trim(DisplayName) + '.';
            MessageBox( 0, PChar(DisplayName), 'Вы успешно выбрали папку',
              MB_OK or MB_ICONINFORMATION );
          finally
            Malloc.Free( pidlResult ); // release returned value
          end;
        finally
          Malloc.Free( pidlInitialFolder ); // release PIDL for folder that
                                            // was selected by default
        end;
      finally
        Malloc.Free( pidlMyComputer ); // release folder that was served as root in dialog
      end;
    finally
      Desktop := nil; // release shell namespace root folder
    end;
  finally
    Malloc := nil; // release shell's allocator
  end;
end.
</pre>

<p>В вышеприведённом коде есть некоторые моменты, которые будут разьяснены ниже. </p>
<p>Навигация по пространству имён </p>
<p>Каждый объект-папка прдоставляет Вам возможность перебора всех объектов, которыми данный объект владеет. Для этого Вам предоставляется метод EnumObjects интерфейса IShellFolder, который возвращает интерфейс-итератор IEnumIDList. При этом Вы можете огранич ить список (включать папки, не папки, скрытые и системные объекты). </p>
<p>Описание методов интерфейса IEnumIDList: </p>
<p>Clone Создаёт новый объект-итератор, идентичный данному; </p>
<p>Next Восстанавливает указанное количество идентификаторов элементов, находящихся в папке; </p>
<p>Reset Возвращает итератор к началу последовательности; </p>
<p>Skip Пропускает указанное количество элементов; </p>
<p>Таким образом Вы сможете получить набор указателей на списки идентификаторов, причём эти списки будут относительными по отношению к папке-владельцу. </p>
<p>Чтобы получить интерфейс IShellFolder для любого из этих объектов, Вам потребуется осуществить привязку, вызвав метод BindToObject интерфейса IShellFolder папки-владельца. </p>
<p>Чтобы узнать атрибуты данного объекта или нескольких объектов, необходимо вызвать метод GetAttributesOf интерфейса IShellFolder папки-владельца. При этом перед вызовом этого метода необходимо установить те атрибуты, значения которых Вы бы хотели выяснить. Если запрошены атрибуты нескольких элементов, то метод вернёт только те значения атрибутов, которые совпадают у всех переданных элементов. В частности, Вы сможете взять интерфейс IShellFolder только от тех объектов, которые имеют атрибут SFGAO_FOLDER. Вы можете обновить информацию об элементах, входящих в папку, использовав флаг SFGAO_VALIDATE. Ниже представлен пример навигации по основному пространству имён: </p>
<pre>
// C++ with Microsoft extensions
 
// Это консольное приложение печатает на стандартный вывод дерево папок
// основного пространства имён оболочки Windows.
 
#define _WIN32_DCOM
 
#include 
#include 
#include 
#include 
 
using namespace std;
 
// Эта процедура производит вывод строки, попутно
// конвертируя её из кодировки ANSI в кодировку OEM.
void WriteStr(const char * s)
{
  char * s1 = strdup( s );
  CharToOemBuff( s1, s1, strlen(s1) );
  cout &lt;&lt; s1;
  free( reinterpret_cast( s1 ) );
}
 
// Эта процедура производит вывод указанного
// количества символов, попутно конвертируя их из кодировки ANSI
// в кодировку OEM.
void WriteChar(char ch, size_t count)
{
  CharToOemBuff( &amp;ch, &amp;ch, 1 );
  for(int i=0; i &lt; count; i++) cout &lt;&lt; ch;
}
 
// Эта процедура производит вывод строки, попутно
// конвертируя её из кодировки ANSI в кодировку OEM.
// Эта процедура также добавляет перевод каретки по окончании вывода.
void WritelnStr(const char * s)
{
  WriteStr( s );
  cout &lt;&lt; "\n";
}
 
LPMALLOC pMalloc = NULL;
HRESULT hr;
 
// Эта процедура интерпретирует содержание структуры STRRET.
// Также она освобождает временные буфера при необходимости, так что
// для её корректной работы требуется наличие объекта pMalloc.
// После завершения работы с возвращаемым именем необходимо освободить буфер
// с помощью процедуры ::free.
char * GetDisplayName( LPCITEMIDLIST pidl,  const STRRET&amp; value )
{
  char * result = NULL;
  switch( value.uType )
  {
  case STRRET_CSTR:
    result = strdup( value.cStr );
    break;
  case STRRET_WSTR:
    {
      int iSize = WideCharToMultiByte( CP_THREAD_ACP, 0, value.pOleStr, -1, NULL, 0, NULL, NULL );
      result = (char *)malloc(iSize);
      WideCharToMultiByte( CP_THREAD_ACP, 0, value.pOleStr, -1, result, iSize, NULL, NULL );
      pMalloc-&gt;Free( value.pOleStr );
    }
    break;
  case STRRET_OFFSET:
    result = strdup( PSTR( PBYTE(pidl) + value.uOffset ) );
    break;
  }
  return result;
}
 
int Level = 0;
 
// Основная процедура выполняет рекурсивный просмотр структуры папок, начиная с данной.
// Она выводит имена элементов, попутно отслеживая отступы.
void ShowFolder( LPSHELLFOLDER folder )
{
  LPITEMIDLIST pidlChild;
  STRRET Value;
  LPENUMIDLIST Iterator;
  ULONG celtFetched;
  LPSHELLFOLDER child;
 
  hr = folder-&gt;EnumObjects( NULL /* no owner window */, SHCONTF_FOLDERS | SHCONTF_INCLUDEHIDDEN, &amp;Iterator );
  if( SUCCEEDED( hr ) )
  __try
  {
    Level++;
    for(;;)
    {
      hr = Iterator-&gt;Next( 1, &amp;pidlChild, &amp;celtFetched );
      if( hr != NOERROR ) break;
      __try
      {
        hr = folder-&gt;GetDisplayNameOf( pidlChild, SHGDN_INFOLDER | SHGDN_INCLUDE_NONFILESYS, &amp;Value );
        if( SUCCEEDED( hr ) )
        {
          char * s = GetDisplayName( pidlChild, Value );
          WriteChar( ' ', Level );
          WritelnStr( s );
          free( reinterpret_cast( s ) );
        }
        hr = folder-&gt;BindToObject( pidlChild, NULL, IID_IShellFolder, (void**)&amp;child );
        if( SUCCEEDED( hr ) )
        __try
        {
          ShowFolder( child );
        }
        __finally
        {
          child-&gt;Release();
        }
      }
      __finally
      {
        pMalloc-&gt;Free( pidlChild );
      }
    }
    Level--;
  }
  __finally
  {
    Iterator-&gt;Release();
  }
}
 
LPSHELLFOLDER desktop = NULL;
ITEMIDLIST itemidlist = { { 0 } };
LPITEMIDLIST pidlItself = &amp; itemidlist; // This pidl now points to an empty Identifier List.
                                        // It is point to owner folder itself.
                                        // NB: It works only for a root folder!
STRRET Value;
 
// Основное тело программы выполняет необходимую инициализацию, затем
// восстанавливает имя корневой папки, выводит его, и обращается к ShowFolder для выполнения рекурсии.
void main( int argc, char *argv[])
{
  hr = CoInitializeEx( NULL, COINIT_MULTITHREADED );
  if( SUCCEEDED( hr ) )
  __try
  {
    hr = SHGetMalloc( &amp;pMalloc );
    if( SUCCEEDED( hr ) )
    __try
    {
      hr = SHGetDesktopFolder( &amp;desktop );
      if( SUCCEEDED( hr ) )
      __try
      {
        hr = desktop-&gt;GetDisplayNameOf( pidlItself, SHGDN_NORMAL | SHGDN_INCLUDE_NONFILESYS, &amp;Value );
        if( SUCCEEDED( hr ) )
        {
          char * sTempName = GetDisplayName( pidlItself, Value );
          WritelnStr( sTempName );
          free( reinterpret_cast(sTempName) );
        }
        ShowFolder( desktop );
      }
      __finally
      {
        desktop-&gt;Release();
      }
    }
    __finally
    {
      pMalloc-&gt;Release();
    }
  }
  __finally
  {
    CoUninitialize();
  }
}
</pre>

<pre>
// Delphi
 
program ShellA;
 
// Это консольное приложение печатает на стандартный вывод дерево папок
// основного пространства им?н оболочки Windows.
 
uses
  Windows, ActiveX, ShlObj;
 
{$APPTYPE CONSOLE}
 
// Эта процедура производит вывод строки, попутно
// конвертируя е? из кодировки ANSI в кодировку OEM.
procedure WriteStr(s: string);
begin
  UniqueString( s );
  CharToOemBuff( PChar(s), PChar(s), Length(s) );
  Write(s);
end;
 
// Эта процедура производит вывод указанного
// количества символов, попутно конвертируя их из кодировки ANSI
// в кодировку OEM.
procedure WriteChars(Ch: char; Count: Integer);
var
  s: string;
begin
  CharToOemBuff( @Ch, @Ch, 1 );
  s := StringOfChar(Ch, Count);
  Write( s );
end;
 
// Эта процедура производит вывод строки, попутно
// конвертируя е? из кодировки ANSI в кодировку OEM.
// Эта процедура также добавляет перевод каретки по окончании вывода.
procedure WritelnStr(const s: string);
begin
  WriteStr( s + #13#10 );
end;
 
var
  pMalloc: IMalloc;
  hr: HRESULT;
 
// Эта процедура интерпретирует содержание структуры STRRET.
// Также она освобождает временные буфера при необходимости, так что
// для е? корректной работы требуется наличие объекта pMalloc.
function GetDisplayName( pidl: PItemIDList; const Value: STRRET ): string;
begin
  with Value do
  case uType of
    STRRET_CSTR: Result := PChar(@cStr[0]);
    STRRET_WSTR:
    begin
      Result := pOleStr;
      pMalloc.Free( pOleStr );
    end;
    STRRET_OFFSET: Result := PChar( LongWord(pidl) + uOffset );
  end;
end;
 
var
  Level: Integer;
 
// Основная процедура выполняет рекурсивный просмотр структуры папок, начиная с данной.
// Она выводит имена элементов, попутно отслеживая отступы.
procedure ShowFolder(folder: IShellFolder);
var
  pidlChild: PItemIDList;
  Value: STRRET;
  Iterator: IEnumIDList;
  celtFetched: ULONG;
  child: IShellFolder;
begin
  hr := folder.EnumObjects( 0 (* no owner window *), SHCONTF_FOLDERS or SHCONTF_INCLUDEHIDDEN, Iterator );
  if Succeeded( hr ) then
  try
    Inc(Level);
    while true do
    begin
      hr := Iterator.Next( 1, pidlChild, celtFetched );
      if hr &lt;&gt; NOERROR then Break;
      try
        hr := folder.GetDisplayNameOf( pidlChild, SHGDN_INFOLDER or SHGDN_INCLUDE_NONFILESYS, Value );
        if Succeeded( hr ) then
        begin
          WriteChars( ' ', Level );
          WritelnStr( GetDisplayName( pidlChild, Value ) );
        end;
        hr := folder.BindToObject( pidlChild, nil, IID_IShellFolder, Pointer(child) );
        if Succeeded( hr ) then
        try
          ShowFolder( child );
        finally
          child := nil;
        end;
      finally
        pMalloc.Free( pidlChild );
      end;
    end;
    Dec(Level);
  finally
    Iterator := nil;
  end;
end;
 
var
  desktop: IShellFolder;
  mkid: SHITEMID;
  pidlItself: PItemIDList;
  Value: STRRET;
 
// Основное тело программы выполняет необходимую инициализацию, затем
// восстанавливает имя корневой папки, выводит его, и обращается к ShowFolder для выполнения рекурсии.
begin
  Level := 0;
  mkid.cb := 0;
  pidlItself := @mkid; // This pidl now points to an empty Identifier List. It is points to owner folder itself.
                       // NB: It works only for a root folder!
  hr := CoInitializeEx( nil, COINIT_MULTITHREADED );
  if Succeeded( hr ) then
  try
    hr := SHGetMalloc( pMalloc );
    if Succeeded( hr ) then
    try
      hr := SHGetDesktopFolder( desktop );
      if Succeeded( hr ) then
      try
        hr := desktop.GetDisplayNameOf( pidlItself, SHGDN_NORMAL or SHGDN_INCLUDE_NONFILESYS, Value );
        if Succeeded( hr ) then
        begin
          WritelnStr( GetDisplayName( pidlItself, Value ) );
        end;
        ShowFolder( desktop );
      finally
        desktop := nil;
      end;
    finally
      pMalloc := nil;
    end;
  finally
    CoUninitialize;
  end;
end.
</pre>

<p>Дополнительные возможности </p>
<p>Прежде всего, Ваше приложение всегда можете получить строку с именем объекта, представленном в удобном для Вас формате. Для этого интерфейс IShellFolder предоставляет метод GetDisplayNameOf. </p>
<p>Вы можете указать один из следующих требующихся форматов: </p>
<p>SHGDN_NORMAL Обычный формат представления; </p>
<p>SHGDN_INFOLDER Формат представления относительно данной папки; </p>
<p>SHGDN_INCLUDE_NONFILESYS Приложение заинтересовано в именах элементов всех типов. Если этот флаг не установлен, то приложение заинтересовано лишь в тех элементах, которые представляют часть файловой системы. Если этот флаг не установлен, и элемент не пред ставляет собой часть файловой системы, то этот метод может быть выполнен неудачно; </p>
<p>SHGDN_FORADDRESSBAR Имя будет использовано для показа в адресном комбобоксе; </p>
<p>SHGDN_FORPARSING Формат представления, используемый для дальнейшего разбора имени; </p>
<p>Имя элемента, полученное с установленным флагом SHGDN_FORPARSING, имеет особое значение. Вы можете использовать такое имя как командную строку для запуска приложения. Говоря точнее - такое имя эквивалентно понятию пути файловой системы. </p>
<p>Интерфейс IShellFolder предоставляет метод SetNameOf, позволяющий изменить экранное имя файлового объекта или вложенной папки. Изменяя экранное имя элемента, Вы изменяете его идентификатор, поэтому функция возвращает PIDL-указатель на новый идентификатор. Изменение экранного имени файлового объекта приводит к его фактическому переименованию в файловой системе. </p>
<p>Интерфейс IShellFolder также предоставляет метод ParseDisplayName, который позволяет узнать идентификатор элемента по его имени. Этому методу необходимо передавать имя, сгенерированное методом GetDisplayNameOf с установленным флагом SHGDN_FORPARSING. </p>
<p>С помощью глобального метода SHGetPathFromIDList по списку идентификаторов, определяющих объект относительно корня пространства имён, можно определить путь к объекту файловой системы. </p>
<p>С помощью глобального метода SHAddToRecentDocs Ваше приложение может добавить документ к списку последних, с которыми работал пользователь, или очистить этот список. </p>
<p>С помощью глобального метода SHEmptyRecycleBin, появившегося в версии 4.71 оболочки Windows, Ваше приложение может очистить корзину (Recycle Bin). Удаление файла в корзину (то есть - с возможностью дальнейшего восстановления) производится глобальным метод ом SHFileOperation, подробное описание которого выходит за рамки этого обзора. Вы также можете узнать количество объектов, расположенных в корзине, и их суммарный размер, с помощью метода SHQueryRecycleBin. </p>
<pre>
// C/C++
// Проверка и очистка корзины на локальном диске C:
  SHQueryRBInfo.cbSize = sizeof(SHQUERYRBINFO);
  hr = SHQueryRecycleBin("C:\\", &amp;SHQueryRBInfo);
  if( SUCCEEDED(hr) &amp;&amp; (SHQueryRBInfo.i64NumItems &gt; 0) )
  {
    SHEmptyRecycleBin( 0, "C:\\", 0 );
  }
</pre>
<pre>
// Delphi
// Данные типы и методы не описаны в ShlObj.Pas,
//  поэтому опишем их сами.
type
  SHQUERYRBINFO = record
    cbSize: DWORD;
    i64Size: Int64;
    i64NumItems: Int64;
  end;
  LPSHQUERYRBINFO = ^SHQUERYRBINFO;
  TSHQueryRBInfo = SHQUERYRBINFO;
 
const
  shell32 = 'shell32.dll';
 
function SHQueryRecycleBinA(pszRootPath: PAnsiChar;
  var pSHQueryRBInfo: TSHQueryRBInfo): HResult; stdcall;
  external shell32 name 'SHQueryRecycleBinA';
function SHQueryRecycleBinW(pszRootPath: PWideChar;
  var pSHQueryRBInfo: TSHQueryRBInfo): HResult; stdcall;
  external shell32 name 'SHQueryRecycleBinW';
function SHQueryRecycleBin(pszRootPath: PChar;
  var pSHQueryRBInfo: TSHQueryRBInfo): HResult; stdcall;
  external shell32 name 'SHQueryRecycleBinA';
 
function SHEmptyRecycleBinA(hWnd: HWND;
  pszRootPath: PAnsiChar; dwFlags: DWORD): HResult; stdcall;
  external shell32 name 'SHEmptyRecycleBinA';
function SHEmptyRecycleBinW(hWnd: HWND;
  pszRootPath: PWideChar; dwFlags: DWORD): HResult; stdcall;
  external shell32 name 'SHEmptyRecycleBinW';
function SHEmptyRecycleBin(hWnd: HWND;
  pszRootPath: PChar; dwFlags: DWORD): HResult; stdcall;
  external shell32 name 'SHEmptyRecycleBinA';
 
// Проверка и очистка корзины на локальном диске C:
  SHQueryRBInfo.cbSize := sizeof(TSHQueryRBInfo);
  hr := SHQueryRecycleBin(PChar('C:\'), SHQueryRBInfo);
  if Succeeded(hr) and (SHQueryRBInfo.i64NumItems &gt; 0) then
  begin
    SHEmptyRecycleBin( Self.Handle, PChar('C:\'), 0 );
  end;
</pre>
<p>Поиск интерфейсов, позволяющих оперировать с данным объектом, можно осуществить через метод GetUIObjectOf интерфейса IShellFolder (обычно запрашиваются интерфейсы контекстных меню и операций drag-and-drop). </p>
<p>Частой задачей является выполнение некоторых команд контекстного меню для данного элемента. Например, для открытия окна свойств объекта нужно запросить интерфейс IContextMenu этого объекта, и активизировать команду "Properties". Ниже представлен пример: </p>
<pre>
// C++
 
#define _WIN32_DCOM
 
#include 
#include 
 
// Это приложение выводит на экран
// окно свойств "Мой компьютер".
 
HRESULT hr;
LPMALLOC pMalloc = NULL;
LPSHELLFOLDER desktop = NULL;
LPCONTEXTMENU mnu = NULL;
LPITEMIDLIST pidlDrives = NULL;
CMINVOKECOMMANDINFO cmd;
 
void main( int argc, char *argv[])
{
  hr = CoInitializeEx( NULL, COINIT_MULTITHREADED );
  if( SUCCEEDED( hr ) )
  __try
  {
    hr = SHGetMalloc( &amp;pMalloc );
    if( SUCCEEDED( hr ) )
    __try
    {
      hr = SHGetDesktopFolder( &amp;desktop );
      if( SUCCEEDED( hr ) )
      __try
      {
        hr = SHGetSpecialFolderLocation( NULL, CSIDL_DRIVES, &amp;pidlDrives );
        if( SUCCEEDED( hr ) )
        __try
        {
          hr = desktop-&gt;GetUIObjectOf( NULL, 1, const_cast(&amp;pidlDrives), IID_IContextMenu, NULL, (void**) &amp;mnu );
          if( SUCCEEDED( hr ) )
          __try
          {
            memset( &amp; cmd, 0, sizeof( cmd ) );
            cmd.cbSize = sizeof( cmd );
            cmd.fMask = 0;
            cmd.hwnd = 0;
            cmd.lpVerb = "Properties";
            cmd.nShow = SW_SHOWNORMAL;
            hr = mnu-&gt;InvokeCommand( &amp; cmd );
          }
          __finally
          {
            mnu-&gt;Release();
          }
        }
        __finally
        {
          pMalloc-&gt;Free( pidlDrives );
        }
      }
      __finally
      {
        desktop-&gt;Release();
      }
    }
    __finally
    {
      pMalloc-&gt;Release();
    }
  }
  __finally
  {
    CoUninitialize();
  }
}
</pre>
<pre>// Delphi
 
program ShellB;
 
// Это приложение выводит на экран
// окно свойств "Мой компьютер".
 
uses
  Windows,
  ActiveX,
  ShlObj;
 
var
  pMalloc: IMalloc;
  desktop: IShellFolder;
  mnu: IContextMenu;
  hr: HRESULT;
  pidlDrives: PItemIDList;
  cmd: TCMInvokeCommandInfo;
begin
  hr := CoInitializeEx( nil, COINIT_MULTITHREADED );
  if SUCCEEDED( hr ) then
  try
    hr := SHGetMalloc( pMalloc );
    if SUCCEEDED( hr ) then
    try
      hr := SHGetDesktopFolder( desktop );
      if SUCCEEDED( hr ) then
      try
        hr := SHGetSpecialFolderLocation( 0, CSIDL_DRIVES, pidlDrives );
        if SUCCEEDED( hr ) then
        try
          hr := desktop.GetUIObjectOf( 0, 1, pidlDrives, IContextMenu, nil, Pointer(mnu) );
          if SUCCEEDED( hr ) then
          try
            FillMemory( @cmd, sizeof(cmd), 0 );
            with cmd do
            begin
              cbSize := sizeof( cmd );
              fMask := 0;
              hwnd := 0;
              lpVerb := PChar( 'Properties' );
              nShow := SW_SHOWNORMAL;
            end;
            hr := mnu.InvokeCommand( cmd );
          finally
            mnu := nil;
          end;
        finally
          pMalloc.Free( pidlDrives );
        end;
      finally
        desktop := nil;
      end;
    finally
      pMalloc := nil;
    end;
  finally
    CoUninitialize;
  end;
end.
</pre>
<p>Все примеры в данном обзоре являются реально работающими (предварительно скомпилированными). Для компиляции использовались Microsoft Visual C++ 6.0 SP3 и Borland Delphi 4.0 UP3. К сожалению, при конвертации в HTML могли возникнуть маленькие погрешности, к оторые пока мне неизвестны. </p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
