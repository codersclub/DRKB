---
Title: Имитировать события мыши
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Имитировать события мыши
========================

В этом примере курсор мыши сам встает на кнопку и нажимает на нее.

    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      p: TPoint;
    begin
      p := Point(Button1.Left + Button1.Width div 2,
                 Button1.Top + Button1.Height div 2);
      p := Form1.ClientToScreen(p);
      SetCursorPos(p.x, p.y);
      p := Point(round(p.x * 65535 / Screen.Width),
                 round(p.y * 65535 / Screen.Height));
      Mouse_Event(MOUSEEVENTF_ABSOLUTE or MOUSEEVENTF_MOVE,
                  p.x, p.y, 0, 0);
      Application.ProcessMessages;
      sleep(100);
      Mouse_Event(MOUSEEVENTF_ABSOLUTE or MOUSEEVENTF_LEFTDOWN,
                  p.x, p.y, 0, 0);
      Application.ProcessMessages;
      sleep(300);
      Mouse_Event(MOUSEEVENTF_ABSOLUTE or MOUSEEVENTF_LEFTUP,
                  p.x, p.y, 0, 0);
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
