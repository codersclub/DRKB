---
Title: Как сделать окно системно-модальным?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как сделать окно системно-модальным?
====================================

Используйте функцию Windows API SetSysModalWindow(). Код ниже
демонстрирует технологию работы с этой функцией. В любой момент времени
может быть возможен только один модально-системны диалог, чей дескриптор
возвращается функцией SetSysModalWindow(). Вам необходимо запомнить
возвращаемую функцией величину для того, чтобы завершить показ диалога
таким образом. Вот как примерно это должно выглядеть:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      x: word ;
    begin
      x := SetSysModalWindow(AboutBox.handle) ;
      AboutBox.showmodal ;
      SetSysModalWindow(x) ;
    end;

