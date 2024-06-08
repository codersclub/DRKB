---
Title: String -\> PWideChar
Author: Gua, gua@ukr.net
Date: 18.07.2002
---


String -\> PWideChar
===================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Конвертация String в PWideChar
     
    Зависимости: ???
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Andre .v.d. Merwe
    Дата:        18 июля 2002 г.
    ********************************************** }
     
    function StringToPWide( sStr: string; var iNewSize: integer ): PWideChar;
    var
      pw : PWideChar;
      iSize : integer;
    begin
      iSize := Length( sStr ) + 1;
      iNewSize := iSize * 2;
     
      pw := AllocMem( iNewSize );
     
      MultiByteToWideChar( CP_ACP, 0, PChar(sStr), iSize, pw, iNewSize );
     
      Result := pw;
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
       iSize: integer;
    begin
      ChangeWallpaper(StringToPWide('C:\1.jpg',iSize));
    end; 
