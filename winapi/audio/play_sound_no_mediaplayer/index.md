---
Title: Сыграть звуковой файл без компонентов
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Сыграть звуковой файл без компонентов
=====================================

Если Вам не нужен компонент MediaPlayer, а сыграть звук, например, при
нажатии на кнопку, нужно, воспользуйтесь функцией PlaySound. Одна из ее
возможностей - сыграть wav-файл.

    uses MMsystem;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if OpenDialog1.Execute then
        PlaySound(PChar(OpenDialog1.FileName), 0, SND_FILENAME);
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
