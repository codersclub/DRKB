---
Title: Постраничная прокрутка Memo, когда фокус находится на Edit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Постраничная прокрутка Memo, когда фокус находится на Edit
==========================================================

    procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if Key = VK_F8 then
        SendMessage(Memo1.Handle, { HWND для Memo }
          WM_VSCROLL, { сообщение Windows }
          SB_PAGEDOWN, {на страницу вниз }
          0) { не используется }
      else if Key = VK_F7 then
        SendMessage(Memo1.Handle, WM_VSCROLL, SB_PAGEUP, 0);
    end;

