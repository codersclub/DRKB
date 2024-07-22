---
Title: Манипулирование кнопками TOpenDialog
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Манипулирование кнопками TOpenDialog
====================================

    uses
      CommCtrl;
     
    // Example: Hide the "Create New Folder" Button.
     
    procedure TForm1.OpenPictureDialog1Show(Sender: TObject);
    const
      TB_BTN_NEWFOLDER  = 40962;
    var
       hWndToolbar, wnd: HWND;
       tbInfo: TTBButtonInfoA;
    begin
        tbInfo.cbSize := SizeOf(TTBButtonInfo);
        tbInfo.dwMask := TBIF_STATE;
        tbinfo.fsState := TBSTATE_HIDDEN or TBSTATE_INDETERMINATE;
     
        hWndToolbar := FindWindowEx(GetParent((Sender as TOpenPictureDialog).Handle), 0,
          'ToolbarWindow32', nil);
        SendMessage(hWndToolbar, TB_SETBUTTONINFO, TB_BTN_NEWFOLDER ,LParam(@tbinfo));
    end;

