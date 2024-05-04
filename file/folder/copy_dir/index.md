---
Title: Как скопировать директорию?
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Как скопировать директорию?
===========================

Использовать ShFileOperation

    procedure TForm1.Button2Click(Sender: TObject);
    var  OpStruc: TSHFileOpStruct;
      frombuf, tobuf: Array [0..128] of Char;
    begin  FillChar( frombuf, Sizeof(frombuf), 0 );
      FillChar( tobuf, Sizeof(tobuf), 0 );
      StrPCopy( frombuf, 'd:\brief*.*' );
      StrPCopy( tobuf, 'd:\temp\brief' );
      with OpStruc do begin
        Wnd := Handle;
        wFunc := FO_COPY;
        pFrom := @frombuf;
        pTo := @tobuf;
        fFlags := FOF_NOCONFIRMATION or FOF_RENAMEONCOLLISION;
        fAnyOperationsAborted := False;
        hNameMappings := Nil;
        lpszProgressTitle := Nil;
      end;
      ShFileOperation( OpStruc );
    end;

