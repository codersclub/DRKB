---
Title: Как отобразить подсказку в TLabel?
Author: Vit
Date: 01.01.2007
---


Как отобразить подсказку в TLabel?
==================================

::: {.date}
01.01.2007
:::

На форме лежат TEdit, TCheckBox и TLabel. Я бы хотел, чтобы при
наведении на TEdit или TCheckBox в TLabel отображалась \"подсказка\".
Т.е. своего рода hint, но только отображаемый в TLabel. Как такое можно
сотворить?

Такое поведение Hint в VCL предусмотренно:

    procedure TForm1.DisplayHint(Sender: TObject);

     
    begin
      Label1.caption := GetLongHint(Application.Hint);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnHint := DisplayHint;
    end;

Теперь все хинты будут показываться на метке.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
