---
Title: Как сделать дырку в окне?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сделать дырку в окне?
=========================

    procedure TForm1.Button4Click(Sender: TObject);
    var
      HRegion1, Hreg2, Hreg3: THandle;
      Col: TColor;
    begin
      ShowMessage ('Ready for a real crash?');
      Col := Color;
      Color := clRed;
      PlaySound ('boom.wav', 0, snd_sync);
      HRegion1 := CreatePolygonRgn (Pts,
        sizeof (Pts) div 8,
        alternate);
      SetWindowRgn (
        Handle, HRegion1, True);
      ShowMessage ('Now, what have you done?');
      Color := Col;
      ShowMessage ('Вам лучше купить новый монитор');
    end;

