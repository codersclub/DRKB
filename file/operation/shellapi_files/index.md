---
Title: Файловые операции средствами ShellAPI
Date: 01.01.2007
---


Файловые операции средствами ShellAPI
=====================================

::: {.date}
01.01.2007
:::

Файловые операции средствами ShellAPI. 

В данной статье мы подробно рассмотрим применение функции
SHFileOperation.

function SHFileOperation(const lpFileOp: TSHFileOpStruct): Integer;
stdcall;

Данная функция позволяет производить копирование, перемещение,

переименование и удаление (в том числе и в Recycle Bin) объектов
файловой системы.

Функция возвращает 0, если операция выполнена успешно,

и ненулевое значение в противном :-) случае.

Функция имеет единственный аргумент - структуру типа TSHFileOpStruct,

в которой и передаются все необходимые данные.

Эта структура выглядит следующим образом:

    _SHFILEOPSTRUCTA = packed record
        Wnd: HWND;
        wFunc: UINT;
        pFrom: PAnsiChar;
        pTo: PAnsiChar;
        fFlags: FILEOP_FLAGS;
        fAnyOperationsAborted: BOOL;
        hNameMappings: Pointer;
        lpszProgressTitle: PAnsiChar; { используется только при установленном флаге FOF_SIMPLEPROGRESS }
      end;

Поля этой структуры имеют следующее назначение:

hwnd Хэндл окна, на которое будут выводиться диалоговые окна о ходе
операции.

wFunc Требуемая операция. Может принимать одно из значений:

FO\_COPY Копирует файлы, указанные в pFrom в папку, указанную в pTo.

FO\_DELETE Удаляет файлы, указанные pFrom (pTo игнорируется).

FO\_MOVE Перемещает файлы, указанные в pFrom в папку, указанную в pTo.

FO\_RENAME Переименовывает файлы, указанные в pFrom.

pFrom

Указатель на буфер, содержащий пути к одному или нескольким файлам.

Если файлов несколько, между путями ставится нулевой байт.

Список должен заканчиваться двумя нулевыми байтами.

pTo

Аналогично pFrom, но содержит путь к директории - адресату,

в которую производится копирование или перемещение файлов.

Также может содержать несколько путей.

При этом нужно установить флаг FOF\_MULTIDESTFILES.

fFlags

Управляющие флаги.

FOF\_ALLOWUNDO Если возможно, сохраняет информацию для возможности UnDo.

FOF\_CONFIRMMOUSE Не реализовано.

FOF\_FILESONLY Если в поле pFrom установлено \*.\*, то операция

будет производиться только с файлами.

FOF\_MULTIDESTFILES Указывает, что для каждого исходного

файла в поле pFrom указана своя директория - адресат.

FOF\_NOCONFIRMATION Отвечает \"yes to all\" на все запросы в ходе
опеации.

FOF\_NOCONFIRMMKDIR Не подтверждает создание нового каталога,

если операция требует, чтобы он был создан.

FOF\_RENAMEONCOLLISION В случае, если уже существует файл

с данным именем, создается файл с именем \"Copy \#N of...\"

FOF\_SILENT Не показывать диалог с индикатором прогресса.

FOF\_SIMPLEPROGRESS Показывать диалог с индикатором прогресса,

но не показывать имен файлов.

FOF\_WANTMAPPINGHANDLE Вносит hNameMappings элемент.

Дескриптор должен быть освобожден функцией SHFreeNameMappings.

fAnyOperationsAborted

Принимает значение TRUE если пользователь прервал любую файловую

операцию до ее завершения и FALSE в ином случае.

hNameMappings

Дескриптор объекта отображения имени файла, который содержит

массив структур SHNAMEMAPPING. Каждая структура содержит

старые и новые имена пути для каждого файла, который перемещался,

  скопирован, или переименован. Этот элемент используется только,

  если установлен флаг FOF\_WANTMAPPINGHANDLE.

lpszProgressTitle

Указатель на строку, используемую как заголовок для диалогового окна
прогресса.

Этот элемент используется только, если установлен флаг
FOF\_SIMPLEPROGRESS.

Примечание.

Если pFrom или pTo не указаны, берутся файлы из текущей директории.

Текущую директорию можно установить с помощью функции
SetCurrentDirectory

и получить функцией GetCurrentDirectory.

А теперь - примеры.

Разумеется, вам нужно вставить в секцию uses модуль ShellAPI, в котором
определена

функция SHFileOperation.

Рассмотрим самое простое - удаление файлов.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      SHFileOpStruct : TSHFileOpStruct;
      From : array [0..255] of Char;
    begin
      SetCurrentDirectory( PChar( 'C:\' ) );
      From := 'Test1.tst' + #0 + 'Test2.tst' + #0 + #0;
      with SHFileOpStruct do
        begin
          Wnd := Handle;
          wFunc := FO_DELETE;
          pFrom := @From;
          pTo := nil;
          fFlags := 0;
          fAnyOperationsAborted := False;
          hNameMappings := nil;
          lpszProgressTitle := nil;
        end;
      SHFileOperation( SHFileOpStruct );
    end;

Обратите внимание, что ни один из флагов не установлен.

Если вы хотите не просто удалить файлы, а переместить их

в корзину, должен быть установлен флаг FOF\_ALLOWUNDO.

Для удобства дальнейших экспериментов напишем функцию,

создающую из массива строк буфер для передачи его в качестве параметра
pFrom.

После каждой строки в буфер вставляется нулевой байт, в конце списка -
два нулевых байта.

    type TBuffer = array of Char;
     
     
    procedure CreateBuffer( Names : array of string; var P : TBuffer );
    var I, J, L : Integer;
    begin
      for I := Low( Names ) to High( Names ) do
        begin
          L := Length( P );
          SetLength( P, L + Length( Names[ I ] ) + 1 );
          for J := 0 to Length( Names[ I ] ) - 1 do
            P[ L + J ] := Names[ I, J + 1 ];
          P[ L + J ] := #0;
        end;
      SetLength( P, Length( P ) + 1 );
      P[ Length( P ) ] := #0;
    end;

Выглядит ужасно, но работает. Можно написать красивее, просто лень.

И, наконец, функция, удаляющая файлы, переданные ей в списке Names.

Параметр ToRecycle определяет, будут ли файлы перемещены в корзину

или удалены. Функция возвращает 0, если операция выполнена успешно,

и ненулевое значение, если руки у кого-то растут не из того места, и
этот

кто-то всунул функции имена несуществующих файлов.

    function DeleteFiles( Handle : HWnd; Names : array of string; ToRecycle : Boolean ) : Integer;
    var
      SHFileOpStruct : TSHFileOpStruct;
      Src : TBuffer;
    begin
      CreateBuffer( Names, Src );
      with SHFileOpStruct do
        begin
          Wnd := Handle;
          wFunc := FO_DELETE;
          pFrom := Pointer( Src );
          pTo := nil;
          fFlags := 0;
          if ToRecycle then fFlags := FOF_ALLOWUNDO;
          fAnyOperationsAborted := False;
          hNameMappings := nil;
          lpszProgressTitle := nil;
        end;
      Result := SHFileOperation( SHFileOpStruct );
      Src := nil;
    end;

Обратите внимание, что мы освобождаем буфер Src простым

присваиванием значения nil. Если верить документации,

потери памяти при этом не происходит, а напротив,

происходит корректное уничтожение динамического массива.

Каким образом, правда - это рак мозга :-).

Проверяем :

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DeleteFiles( Handle, [ 'C:\Test1', 'C:\Test2' ], True );
    end;

Вроде все работает.

Кстати, обнаружился забавный глюк - вызовем процедуру DeleteFiles таким
образом:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SetCurrentDirectory( PChar( 'C:\' ) );
      DeleteFiles( Handle, [ 'Test1', 'Test2' ], True );
    end;

Файлы \'Test1\' и \'Test2\' удаляются совсем, без помещения в корзину,

несмотря на установленный флаг FOF\_ALLOWUNDO.

Мораль: при использовании функции

SHFileOperation используйте полные пути всегда, когда это возможно.

Ну, с удалением файлов разобрались.

Теперь очередь за копированием и перемещением.

Следующая функция перемещает файлы указанные в списке Src в директорию
Dest.

Параметр Move определяет, будут ли файлы перемещаться или копироваться.

Параметр AutoRename указывает, переименовывать ли файлы в случае
конфликта имен.

    function CopyFiles( Handle : Hwnd; Src : array of string; Dest : string;
    Move : Boolean; AutoRename : Boolean ) : Integer;
    var
      SHFileOpStruct : TSHFileOpStruct;
      SrcBuf : TBuffer;
    begin
      CreateBuffer( Src, SrcBuf );
      with SHFileOpStruct do
        begin
          Wnd := Handle;
          wFunc := FO_COPY;
          if Move then wFunc := FO_MOVE;
          pFrom := Pointer( SrcBuf );
          pTo := PChar( Dest );
          fFlags := 0;
          if AutoRename then fFlags := FOF_RENAMEONCOLLISION;
          fAnyOperationsAborted := False;
          hNameMappings := nil;
          lpszProgressTitle := nil;
        end;
      Result := SHFileOperation( SHFileOpStruct );
      SrcBuf := nil;
    end;

Ну, проверим.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CopyFiles( Handle, [ 'C:\Test1', 'C:\Test2' ], 'C:\Temp', True, True );
    end;

Все в порядке (а кудa ж оно денется).

Есть, правда еще одна возможность - перемещать много файлов каждый

в свою директорию за один присест, но я с трудом представляю, кому это
может понадобиться.

Осталась последняя о

    function RenameFiles( Handle : HWnd; Src : string; New : string; AutoRename : Boolean ) : Integer;
    var SHFileOpStruct : TSHFileOpStruct;
    begin
      with SHFileOpStruct do
        begin
          Wnd := Handle;
          wFunc := FO_RENAME;
          pFrom := PChar( Src );
          pTo := PChar( New );
          fFlags := 0;
          if AutoRename then fFlags := FOF_RENAMEONCOLLISION;
          fAnyOperationsAborted := False;
          hNameMappings := nil;
          lpszProgressTitle := nil;
        end;
      Result := SHFileOperation( SHFileOpStruct );
    end;

И проверка ...

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      RenameFiles( Handle, 'C:\Test1' , 'C:\Test3' , False );
    end;

Взято с сайта <https://blackman.wp-club.net/>
