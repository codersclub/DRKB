---
Title: Длинные подсказки на StatusBar-e
Date: 01.01.2007
---


Длинные подсказки на StatusBar-e
=================================

::: {.date}
01.01.2007
:::

Этот пример показывает, как сделать, чтобы на StatusBar выводилась
длинная подсказка при поднесении мыши к объекту.

    public
      procedure DoShowHint(Sender: TObject);
     
    ...
    procedure TForm1.DoShowHint(Sender: TObject);
    begin
      StatusBar1.SimpleText := Application.Hint;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnHint := DoShowHint;
      Button1.Hint := 'Button 1|It is button 1';
      Button2.Hint := 'Button 2|It is button 2';
      Button3.Hint := 'Button 3|It is button 3';
      Form1.ShowHint := true;
    end;
     

Символ "\|" позволяет разделять две подсказки: та, что появляется на
желтом фоне, и та, что лежит в Application.Hint. Для работы с частями
подсказки существуют функции GetShortHint, GetLongHint.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

    private
       procedure MyHint(Sender: TObject);
     end;
     
     
        implementation
     
      {....}
     
     procedure TForm1.FormCreate(Sender: TObject);
     begin
       Application.OnHint := MyHint;
       ShowHint           := True;
       Button1.Hint       := 'normal yellow hint|Text in Statusbar';
       Button2.Hint       := 'only yellow hint|';
       Button3.Hint       := '|text only in statusbar';
       Edit1.Hint         := 'same text';
     end;
     
     procedure TForm1.MyHint(Sender: TObject);
     begin
       StatusBar1.SimpleText := Application.Hint;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
