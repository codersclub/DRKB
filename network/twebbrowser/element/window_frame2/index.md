---
Title: Как работать со всеми фреймами, отображенными в данный момент в TWebBrowser?
Author: Peter Friese
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как работать со всеми фреймами, отображенными в данный момент в TWebBrowser?
============================================================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

Данный пример показывает как определить в каких фреймах разрешена
команда `copy`:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      i: integer;
    begin
    for i := 0 to (WebBrowser1.OleObject.Document.frames.Length - 1) do
      if WebBrowser1.OleObject.Document.frames.item(i).document.queryCommandEnabled('Copy') then
        ShowMessage('copy command is enabled for frame no.' + IntToStr(i));
    end;

