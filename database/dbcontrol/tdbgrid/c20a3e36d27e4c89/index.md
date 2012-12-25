---
Title: Как убрать HScroll у TDBGrid?
Author: Vit
Date: 01.01.2007
---


Как убрать HScroll у TDBGrid?
=============================

::: {.date}
01.01.2007
:::

Нужные нам свойства существуют, но вынесены в секцию Protected предка
DBGrid: TCustomGrid. Наиболее правильным способом было бы создание
класса наследника от TDBGrid с выводом ScrollBars в секцию Public, но
можно обойтись и без этого следующим способом:


     
    Type TFake=class(TCustomGrid);
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    TFake(DBGrid1).ScrollBars:=ssVertical;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
