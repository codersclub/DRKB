---
Title: Получить заголовок элемента управления под мышкой
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить заголовок элемента управления под мышкой
=================================================

    function GetCaptionAtPoint(CrPos: TPoint): string;
    var
      textlength: Integer;
      Text: PChar;
      Handle: HWND;
    begin
      Result := 'Empty';
      Handle := WindowFromPoint(CrPos);
      if Handle = 0 then Exit;
      textlength := SendMessage(Handle, WM_GETTEXTLENGTH, 0, 0);
      if textlength <> 0 then
      begin
        getmem(Text, textlength + 1);
        SendMessage(Handle, WM_GETTEXT, textlength + 1, Integer(Text));
        Result := Text;
        freemem(Text);
      end;
    end;

