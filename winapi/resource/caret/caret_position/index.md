---
Title: Найти позицию каретки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Найти позицию каретки
=====================

    function GetCaretPosition(var APoint: TPoint): Boolean;
    var w: HWND;
      aID, mID: DWORD;
    begin
      Result:= False;
      w:= GetForegroundWindow;
      if w <> 0 then
      begin
        aID:= GetWindowThreadProcessId(w, nil);
        mID:= GetCurrentThreadid;
        if aID <> mID then
        begin
          if AttachThreadInput(mID, aID, True) then
          begin
            w:= GetFocus;
            if w <> 0 then
            begin
              Result:= GetCaretPos(APoint);
              Windows.ClientToScreen(w, APoint);
            end;
            AttachThreadInput(mID, aID, False);
          end;
        end;
      end;
    end;
     
     
    //Small demo: set cursor to active caret position 
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      Pt: TPoint;
    begin
      if GetCaretPosition(Pt) then
      begin
        ListBox1.Items.Add(Format('Caret position is %d %d', [Pt.x, Pt.y]));
        SetCursorPos(Pt.X, Pt.Y);
      end;
    end;

