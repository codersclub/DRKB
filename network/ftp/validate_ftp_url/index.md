---
Title: Разбор адреса FTP
Author: Роман Василенко, romix@nm.ru
Date: 13.06.2004
---


Разбор адреса FTP
=================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Разбор адреса FTP
     
    Функция анализирует строку aSrc
    и если в стоке дан корректный адрес FTP,
    возвращает имя пользователя, пароль, хост, порт и каталог.
    Если дан некорректный адрес, функция возвращает false, иначе - true.
    Учтена возможность, когда в адресе не указываются некоторые параметры.
    В этом случае, если нотация соблюдена,
    опущенные параметры возвращаются пустыми строками.
     
    Минимально подробный адрес:
      ftp://myftp.ru
      В этом случае будет возвращён адрес, порт по умолчанию (21) и true.
    Максимально подробный адрес:
      ftp://MyLogin:MyPassword@MyFtp.ru:6000/MyDirectory/
      Будут возвращены все параметры и true.
     
    Зависимости: Classes, SysUtils
    Автор:       Роман Василенко, romix@nm.ru, ICQ:826361, Пятигорск
    Copyright:   Роман Василенко
    Дата:        13 июня 2004 г.
    ********************************************** }
     
    function ParseFTP(aSrc: string; out oUserName, oPassword, oHost: string;
        out oPort: word; out oDir: string): boolean;
    const
        ssPrefix = 0;
        ssUserName = 1;
        ssPassword = 2;
        ssHost = 3;
        ssPort = 4;
        ssDir = 5;
    var
        f, StrState: integer;
        sPort, pfx: string;
    begin
        oUserName:='';
        oPassword:='';
        oHost:='';
        sPort:='';
        oPort:=21;
        oDir:='';
        StrState:=ssPrefix;
        result:=false;
        f:=1;
        repeat
            case StrState of
                ssPrefix: //Разбор префикса ftp:// и определение анонимности адреса
                if aSrc[f]<>':' then
                    pfx:=pfx+aSrc[f]
                else begin
                    if (ansisametext(trim(pfx),'ftp')) and
                       (aSrc[f]+aSrc[f+1]+aSrc[f+2]='://') then begin
                        if pos('@',aSrc)<1 then
                            StrState:=ssHost //Anonymous
                        else
                            StrState:=ssUserName; //UserName[:Password]
                        inc(f,2);
                    end else break;
                end;
                ssUserName: //Извлечение имени пользователя
                if aSrc[f]='@' then //Пароль не указан
                    StrState:=ssHost
                else
                    if aSrc[f]=':' then //Пароль указан
                        StrState:=ssPassword
                    else
                        oUserName:=oUserName+aSrc[f];
                ssPassword: //Извлечение пароля
                if aSrc[f]='@' then
                    StrState:=ssHost
                else
                    oPassword:=oPassword+aSrc[f];
                ssHost: //Извлечение хоста
                if aSrc[f]=':' then //Порт указан
                    StrState:=ssPort
                else
                    if aSrc[f]='/' then //Порт не указан, возможно указан каталог
                        StrState:=ssDir
                    else
                        oHost:=oHost+aSrc[f];
                ssPort: //Извлечение порта
                if aSrc[f]='/' then
                    StrState:=ssDir
                else
                    sPort:=sPort+aSrc[f];
                ssDir: oDir:=oDir+aSrc[f];
            end;
            inc(f);
        until f>length(aSrc);
        if (StrState>ssPassword) and (trim(oHost)<>'') then
            result:=true;
        try
            if trim(sPort)<>'' then oPort:=strtoint(sPort);
        except
            result:=false;
        end;
    end; 

Пример использования:

    ...
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
        yn: array[false..true] of string=('INVALID', 'VALID');
    var
        xValid: boolean;
        xUser, xPassword, xHost, xDir: string;
        xPort: word;
    begin
        xValid:=ParseFTP(Edit1.Text, xUser, xPassword, xHost, xPort, xDir);
        ShowMessage(format('Address is %s'#13#13'Host: %s'#13'Port: %d'#13+
            'Dir: %s'#13'User: %s'#13'Password: %s',
            [yn[xValid], xHost, xPort, xDir, xUser, xPassword]));
    end;
     
    ... 
