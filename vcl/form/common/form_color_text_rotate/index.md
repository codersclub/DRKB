---
Title: Выводим цветной текст на форме под любым углом
Author: Lutfi Baran
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Выводим цветной текст на форме под любым углом
==============================================

Пример демонстрирует вывод теста случайным образом на форме под
определённым углом. Добавляем в форму компонент TButton и в событие
OnClick следующий код:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      logfont: TLogFont;
      font: Thandle;
      count: integer;
    begin
      LogFont.lfheight := 20;
      logfont.lfwidth := 20;
      logfont.lfweight := 750;
      LogFont.lfEscapement := -200;
      logfont.lfcharset := 1;
      logfont.lfoutprecision := out_tt_precis;
      logfont.lfquality := draft_quality;
      logfont.lfpitchandfamily := FF_Modern;
      font := createfontindirect(logfont);
      Selectobject(Form1.canvas.handle, font);
      SetTextColor(Form1.canvas.handle, rgb(0, 0, 200));
      SetBKmode(Form1.canvas.handle, transparent);
      for count := 1 to 100 do
      begin
        canvas.textout(Random(form1.width), Random(form1.height), 'Hello');
        SetTextColor(form1.canvas.handle, rgb(Random(255), Random(255), Random
          (255)));
      end;
      Deleteobject(font);
    end;

