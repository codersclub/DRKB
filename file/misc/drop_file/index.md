---
Title: Перетаскивание файлов в приложение
Author: Vit
Date: 01.01.2007
---


Перетаскивание файлов в приложение
==================================

::: {.date}
01.01.2007
:::

Взято из FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>

Иногда очень полезно избавить пользователя от лишних операций при
открытии файла.

Он должен нажать на кнопку \" Открыть\" , затем найти интересующий
каталог, выбрать файл.

Проще перетащить мышкой файл сразу в окно приложения.

Рассмотрим пример перетаскивания Drag & Drop в окно произвольного
текстового файла,

который сразу же открывается в компоненте Memo1. Для начала в разделе
Uses необходимо подключить модуль ShellAPI.
В private области окна нужно вставить следующую строку:

    procedure WMDropFiles(var Msg: TWMDropFiles); message WM_DROPFILES;//получение сообщений о переносе файла в окно приложения
     

Процедура обработки этого сообщения будет выглядеть следующим образом:

    procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);

    var
      CFileName: array[0..MAX_PATH] of Char; // переменная, хранящая имя файла
    begin
    try
    If DragQueryFile(Msg.Drop, 0, CFileName, MAX_PATH)> 0 then
    // получение пути файла
    begin
      Form1.Caption:=CFileName; // имя файла в заголовок окна
      Memo1.Lines.LoadFromFile(CFileName); // открываем файл
      Msg.Result := 0;
    end;
    finally
      DragFinish(Msg.Drop); // отпустить файл
    end;
    end;

Для того, чтобы форма знала,
что может принимать такие файлы, необходимо в процедуре создания окна
указать:

    procedure TForm1.FormCreate(Sender: TObject);
     
    begin
      DragAcceptFiles(Handle, True); 
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
