---
Title: AVI файл проигрывается снова и снова
Date: 01.01.2007
---


AVI файл проигрывается снова и снова
====================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://blackman.wp-club.net/myfaq/default.php>
