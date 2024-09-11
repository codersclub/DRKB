---
Title: Как поменять иконку и стpокy в заголовке консольного окна?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Как поменять иконку и стpокy в заголовке консольного окна?
==========================================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      h: HWND;
      AIcon: TIcon;
    begin
      AllocConsole;
      SetConsoleTitle(PChar('Console Title'));
      Sleep(0);
      h := FindWindow(nil, PChar('Console Title'));
      AIcon := TIcon.Create;
      ImageList1.GetIcon(0, AIcon);
      SendMessage(h, WM_SETICON, 1, AIcon.Handle);
      AIcon.Free;
    end;

