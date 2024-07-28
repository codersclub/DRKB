---
Title: AVI файл проигрывается снова и снова
Date: 01.01.2007
Source: <https://blackman.wp-club.net/myfaq/default.php>
---


AVI файл проигрывается снова и снова
====================================

В примере AVI файл проигрывается снова и снова - используем событие
MediaPlayer\'а Notify

    procedure TForm1.MediaPlayer1Notify(Sender: TObject);
    begin with MediaPlayer1 do
      if NotifyValue = nvSuccessful then
        begin
          Notify := True;
          Play;
        end;
    end;

