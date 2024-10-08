---
Title: Работа с ресурсами без TResourceStream
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Работа с ресурсами без TResourceStream
======================================

Используем
FindResource + LoadResource + LockResource


Определяем размеры картинки хранящейся в ресурсах:

    function PictureSize: TSize;
    var
      ResHandle: HWND;
      ResData: HWND;
      BMI: PBitmapInfo;
    begin
      Result.cx := 0;
      Result.cy := 0;
      ResHandle := FindResource(HInstance,
        MAKEINTRESOURCE(200), RT_BITMAP);
      if ResHandle <> 0 then
      begin
        ResData := LoadResource(HInstance, ResHandle);
        if ResData <> 0 then
        try
          BMI := LockResource(ResData);
          if Assigned(BMI) then
          try
            Result.cx := BMI.bmiHeader.biWidth;
            Result.cy := BMI.bmiHeader.biHeight;
          finally
            UnlockResource(ResData);
          end;
        finally
          FreeResource(ResData);
        end;
      end;
    end;

Получаем список всех ресурсов:

    function GetResourceList: Boolean;
    var
      Errors: Cardinal;
     
      function CallBack(hModule: HMODULE; lpType: PChar;
        lpzName: LPTSTR; lParam: Longint): BOOL; stdcall;
      var
        Size: Cardinal;
      begin
        Result := True;
        if Assigned(lpzName) then
        begin
          Size := Length(ResourceName);
          Inc(Size);
          SetLength(ResourceName, Size);
          ResourceName[Size - 1] := ShortString(lpzName);
          if  (ResourceName[Size - 1] <> 'RES_INI') and
              (ResourceName[Size - 1] <> 'RES_MDB') then
            Inc(Errors);
        end;
      end;
     
    begin
      Result := True;
      ResourceName := nil;
      Errors := 0;
      EnumResourceNames(HInstance, 'INSTALL', @CallBack, 0);
      if (Length(ResourceName) <> 2) or (Errors > 0) then
      begin
        MessageBox(Handle, PChar(ERR_CORRUPT), PChar(ERR_GLOBAL),
          MB_OK + MB_ICONERROR);
        Result := False;
        PostQuitMessage(0); 
      end;
    end;

Извлекаем ресурс в файл:

    function ExtractResource: Boolean;
    const
      ResName = 'RES_MDB';
     
      function FileWrite(Handle: Integer; const Buffer; Count: LongWord): Integer;
      const
        BlockSize = 1024;
     
      type
        TArray = array of Byte;
     
      var
        Buff: array [0..BlockSize - 1] of Byte;
        Counter,
        CurCount, A, I: LongWord;
      begin
        Counter := 0;
        Result := Count;
        I := 10;
        repeat
          if Count - Counter > BlockSize then
            CurCount := BlockSize
          else
            CurCount := Count - Counter;
     
          Move(TArray(@Buffer)[Counter], Buff[0], CurCount);
          if WriteFile(THandle(Handle), Buff, CurCount, LongWord(Result), nil) then
            Inc(Counter, CurCount)
          else
          begin
            Result := -1;
            Exit;
          end;
     
          A := Round((Counter / Count) * 100);
          if A > I then
          begin
            I := A;
            SendMessage(Progress, PBM_SETPOS, A, 0);
          end;
     
        until Counter = Count;
      end;
     
    var
      ResHandle: HWND;
      ResData: HWND;
      LockRes: Pointer;
      fHandle: Integer;
      Size: Integer;
    begin
      Result := False;
      try
        ResHandle := FindResource(HInstance,
          PChar(ResName), 'INSTALL');
        if ResHandle = 0 then Exit;
        ResData := LoadResource(HInstance, ResHandle);
        if ResData = 0 then Exit;
        try
          LockRes := LockResource(ResData);
          if not Assigned(LockRes) then Exit;
          try
            fHandle := FileCreate(BasePath + '\MainDB.~mdb');
            if fHandle = -1 then Exit;
            try
              Size := SizeofResource(HInstance, ResHandle);
     
              if FileWrite(fHandle, LockRes^, Size) = -1 then Exit;
     
              Result := True;
              StatusDone := True;
            finally
              CloseHandle(THandle(fHandle));
            end;
          finally
            UnlockResource(ResData);
          end;
        finally
          FreeResource(ResData);
        end;
      finally
        PostMessage(Handle, WM_NOTIFY_THREAD_RESULT, Integer(Result), 0);
      end;
    end;

Отрисовываем картинку из ресурса на форме:

    procedure ShowPicture;
     
      function Rect(Left, Top, Right, Bottom: Integer): TRect;
      begin
        Result.Left := Left;
        Result.Top := Top;
        Result.Right := Right;
        Result.Bottom := Bottom;
      end;
     
    var
      Bitmap: HBITMAP;
      BitmapSize: TSize;
      DC, BitmapDC, OldDC: HDC;
      bLeft, bTop: Cardinal;
      _Rect: TRect;
      S: String;
      Pen: HPEN;
    begin
      Bitmap := LoadBitmap(HInstance, MAKEINTRESOURCE(200));
      if Bitmap <> 0 then
      try
        BitmapSize := PictureSize;
        DC := GetDC(Handle);
        try
          BitmapDC := CreateCompatibleDC(DC);
          try
            OldDC := SelectObject(BitmapDC, Bitmap);
            try
              bLeft := (Width - BitmapSize.cx);
              bTop := 0;
              StretchBlt(DC, 0, 0, bLeft, BitmapSize.cy, BitmapDC, 0, 0, 1, BitmapSize.cy, SRCCOPY);
              BitBlt(DC, bLeft, bTop, BitmapSize.cx, BitmapSize.cy, BitmapDC, 0, 0, SRCCOPY);
     
              SetBkMode(DC, OPAQUE);
              if hFontBold <> 0 then
                SelectObject(DC, hFontBold);
              S := INFO1;
              _Rect := Rect(10, 6, 230, 31);
              DrawText(DC, PChar(S), Length(S), _Rect, DT_WORDBREAK);
     
              if hFontNormal <> 0 then
                SelectObject(DC, hFontNormal);
              S := INFO2;
              _Rect := Rect(10, 40, 280, 70);
              DrawText(DC, PChar(S), Length(S), _Rect, DT_WORDBREAK + DT_NOCLIP);
              S := INFO3;
              _Rect := Rect(10, 55, 280, 100);
              DrawText(DC, PChar(S), Length(S), _Rect, DT_WORDBREAK + DT_NOCLIP);
     
              Pen := CreatePen(PS_SOLID, 1, GetSysColor(COLOR_BTNSHADOW));
              try
                SelectObject(DC, Pen);
                MoveToEx(DC, 6, 127, nil);
                LineTo(DC, 349, 127);
              finally
                DeleteObject(Pen);
              end;
     
              Pen := CreatePen(PS_SOLID, 1, GetSysColor(COLOR_BTNHIGHLIGHT));
              try
                SelectObject(DC, Pen);
                MoveToEx(DC, 348, 128, nil);
                LineTo(DC, 5, 128);
              finally
                DeleteObject(Pen);
              end;
     
            finally
            SelectObject(OldDC, Bitmap);
            end;
          finally
            DeleteDC(BitmapDC);
          end;
        finally
          ReleaseDC(Handle, DC);
        end;
      finally
        DeleteObject(Bitmap);
      end;
    end;

