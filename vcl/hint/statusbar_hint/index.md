---
Title: Всплывающие подсказки в различных панелях StatusBar
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Всплывающие подсказки в различных панелях StatusBar
==============================================================

Данный пример демонстрирует показ всплывающих подсказок для любой панели
статусбара. Этот метод отличается от того, который использует событие
MouseMove, и запускается только тогда, когда приложению необходимо
показать всплывающие подсказки. В то время как при использовании
MouseMove метод будет вызываться при каждом попадании курсора мышки на
statusbar.

    { Добавьте CommCtrl в uses. }
    { в интерфейсе формы для статусбара } 
      private 
        procedure AppShowHint(var HintStr: string; var CanShow: boolean; 
          var HintInfo: THintInfo);
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      Application.OnShowHint := AppShowHint; 
    end;
     
    procedure TForm1.AppShowHint(var HintStr: string; var CanShow: boolean; 
    var HintInfo: THintInfo); 
    const 
      PanelHints: array [0..6] of string = 
        ('Cursor position', 'Ascii char', 'Bookmarks', 'Caps lock', 
        'Insert/Overwrite', 'File size', 'File name');
    var 
      x: integer; 
      R: TRect; 
    begin 
      if HintInfo.HintControl = StatusBar1 then 
      begin 
        for x := 0 to StatusBar1.Panels.Count-1 do 
        begin 
          SendMessage(StatusBar1.Handle, SB_GETRECT, x, Longint(@R)); 
          if PtInRect(R, HintInfo.CursorPos) then 
          begin 
            HintStr := PanelHints[x]; 
            InflateRect(R, 3, 3);
            { Устанавливаем CursorRect говоря системе проверить новые
            строки с подсказками, когда курсор покинет этот прямоугольник. } 
            HintInfo.CursorRect := R; 
            break; 
          end; 
        end; 
      end; 
    end;

