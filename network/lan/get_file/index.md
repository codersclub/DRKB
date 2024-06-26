---
Title: Получение файла из сети
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Получение файла из сети
=======================

_Перевод одноимённой статьи с сайта delphi.about.com )_

Обычно при разработке приложений, которые планируется в дальнейшем
обновлять и усовершенствовать, основные модули хранятся в виде пакетов
(Package) или библиотек DLL. В настоящее время Internet предоставляет
возможность без особых усилий осуществлять обновление этих модулей.
Поэтому добавление к Вашему приложению функции авто-обновления, является
наилучшим способом для обновления приложения.

Давайте посмотрим, как реализовывается данный механизм в любом FTP
приложении.

Delphi предоставляет нам полный доступ к WinInet API (wininet.pas),
который можно использовать для соединения и получения файлов с
веб-сайта, который использует либо Hypertext Transfer Protocol (HTTP)
либо File Transfer Protocol (FTP). Например, мы можем использовать
функции из WinInet API для: добавления FTP браузера в любое приложение,
создания приложения, которое автоматически скачивает файлы с
общедоступных FTP серверов или поиска Internet сайтов, ссылающихся на
графику и скачивать только графику.

Функция GetInetFile

    uses Wininet;
     
    function GetInetFile
    (const fileURL, FileName: String): boolean;
    const BufferSize = 1024;
    var
      hSession, hURL: HInternet;
      Buffer: array[1..BufferSize] of Byte;
      BufferLen: DWORD;
      f: File;
      sAppName: string;
    begin
     Result:=False;
     sAppName := ExtractFileName(Application.ExeName);
     hSession := InternetOpen(PChar(sAppName),
                    INTERNET_OPEN_TYPE_PRECONFIG,
                   nil, nil, 0);
     try
      hURL := InternetOpenURL(hSession,
                PChar(fileURL),
                nil,0,0,0);
      try
       AssignFile(f, FileName);
       Rewrite(f,1);
       repeat
        InternetReadFile(hURL, @Buffer,
                         SizeOf(Buffer), BufferLen);
        BlockWrite(f, Buffer, BufferLen)
       until BufferLen = 0;
       CloseFile(f);
       Result:=True;
      finally
       InternetCloseHandle(hURL)
      end
     finally
      InternetCloseHandle(hSession)
     end
    end;

Обратите внимание: Чтобы обеспечить некоторую визуальную обратную связь
для пользователя, Вы можете добавить строчку наподобие
FlashWindow(Application.Handle,True) в тело блока "повторить/до тех
пор" (repeat/until). Вызов FlashWindow API высвечивает заголовок Вашего
имени приложений в панели задач.

**Использование**

Для вызова функции GetInetFile можно использовать следующий код:

    var FileOnNet, LocalFileName: string
    begin
     FileOnNet:=
      'http://delphi.about.com/library/forminbpl.zip';
     LocalFileName:='File Downloaded From the Net.zip'
     
     if GetInetFile(FileOnNet,LocalFileName)=True then
      ShowMessage('Download successful')
     else
      ShowMessage('Error in file download')
    end;

Данный код запрашивает файл \'forminbpl.zip\' с сайта, скачивает его, и
сохраняет его как \'File Downloaded From the Net.zip\'.

**Обратите внимание:**
В зависимости от версии Delphi, Вы можете
использовать различные компоненты, которые можно найти на Интернет
страницах, посвещённых VCL и, которые можно использовать для упрощения
создания приложений (например FTP компонент, необходимый для TNMFTP,
находящийся на странице FastNet VCL).

