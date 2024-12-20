---
Title: Определение координат расположения TaskBar
Date: 01.01.2007
---

Определение координат расположения TaskBar
==========================================

Вариант 1:

Source: <https://delphiworld.narod.ru>

    uses.., ShellApi;
     
    var
      AppBarData: TAppBarData;
      bAlwaysOnTop: Boolean; {Поверх окон}
      bAutoHide: boolean; {Авт. убирать с экрана}
      ClRect: TRect; {Клиентские области}
      Rect: TRect;
      Edge: UInt; {Местоположение TaskBar}
     
    procedure DetectTaskBar;
    begin
      AppBarData.hWnd := FindWindow('Shell_TrayWnd', nil);
      AppBarData.cbSize := sizeof(AppBarData);
      bAlwaysOnTop := (SHAppBarMessage(ABM_GETSTATE, AppBardata) and ABS_ALWAYSONTOP) < > 0;
      bAutoHide := (SHAppBarMessage(ABM_GETSTATE, AppBardata) and ABS_AUTOHIDE) < > 0;
      GetClientRect(AppBarData.hWnd, ClRect.rc);
      GetWindowRect(AppBarData.hwnd, rect);
      if (Rect.top > 0) then
        Edge := ABE_BOTTOM
      else if (Rect.Bottom < Screen.Height) then
        Edge := ABE_TOP
      else if Rect.Right < Screen.Width then
        Edge := ABE_LEFT
      else
        Edge := ABE_RIGHT;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    {With SHAppBarMessage }
     
    uses
      ShellAPI;
    
    procedure TForm1.Button1Click(Sender: TObject);
    var
      tabd: TAppBarData;
      PosString: string;
    begin
      FillChar(tabd, SizeOf(TAppBarData), 0);
      tabd.cbSize := SizeOf(TAppBarData);
      if SHAppBarMessage(ABM_GETTASKBARPOS, Tabd) = 0 then Exit;
      with Tabd.rc do
        PosString := Format(' (%d, %d);(%d, %d) ', [Left, Top, Right, Bottom]);
      case tabd.uEdge of
        ABE_LEFT: ShowMessage('Left Position' + PosString);
        ABE_TOP: ShowMessage('Top Position' + PosString);
        ABE_RIGHT: ShowMessage('Right Position' + PosString);
        ABE_BOTTOM: ShowMessage('Bottom Position' + PosString);
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    {With FindWindow, GetWindowRect }
    
    type
      TTaskBarPos = (_TOP, _BOTTOM, _LEFT, _RIGHT, _NONE);
    
    function GetTaskBarPos: TTaskBarPos;
    var
      hTaskbar: HWND;
      T: TRect;
      scrW, scrH: integer;
    begin
      hTaskBar := FindWindow('Shell_TrayWnd', nil);
      if hTaskbar <> 0 then
      begin
        GetWindowRect(hTaskBar, T);
        ScrW := Screen.Width;
        ScrH := Screen.Height;
        if (T.Top > scrH div 2) and (T.Right >= scrW) then
          Result := _BOTTOM
        else if (T.Top < scrH div 2) and (T.Bottom <= scrW div 2) then
          Result := _TOP
        else if (T.Left < scrW div 2) and (T.Top <= 0) then
          Result := _LEFT
        else // the last "if" is not really needed 
       if T.Left >= ScrW div 2 then
          Result := _RIGHT;
      end;
    end;
    
    procedure TForm1.Button5Click(Sender: TObject);
    var
      TaskBarPos: TTaskBarPos;
    begin
      TaskBarPos := GetTaskBarPos;
      case TaskBarPos of
        _LEFT: ShowMessage('Left Position');
        _TOP: ShowMessage('Top Position');
        _RIGHT: ShowMessage('Right Position');
        _BOTTOM: ShowMessage('Bottom Position');
      end;
    end;

