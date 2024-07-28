---
Title: Как сделать TMemo с закругленными краями?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать TMemo с закругленными краями?
=========================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      rgn: HRGN;
      r: TRect;
    begin
      r := memo1.ClientRect;
      rgn := CreateRoundRectRgn(r.Left, r.top, r.right, r.bottom, 20, 20);
      memo1.BorderStyle := bsNone;
      memo1.Perform(EM_GETRECT, 0, lparam(@r));
      InflateRect(r, -5, -5);
      memo1.Perform(EM_SETRECTNP, 0, lparam(@r));
      SetWindowRgn(memo1.Handle, rgn, true);
    end;

