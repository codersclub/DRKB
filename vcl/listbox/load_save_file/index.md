---
Title: TCheckListBox: использование методов LoadFromFile / SaveToFile
Author: Bjarne Winkler
Date: 01.01.2007
---


TCheckListBox: использование методов LoadFromFile / SaveToFile
==============================================================

::: {.date}
01.01.2007
:::

Автор: Bjarne Winkler

Пример показывает как можно сохранять в файл содержимое TCheckListBox и
соответственно восстанавливать из файла ранее сохранённые состояния
Чекбоксов.

На самом деле всё просто. Метод SaveToFile просто напросто сохраняет в
обычном текстовом виде значения чекбоксов. Но предварительно нам нужно
преобразовать состояния чекбоксов в текстовый вид, соответственно "1"
или "0".

Далее задача метода LoadFromFile считать эти значения и преобразовать
сначало в числовой вид, а затем в логический (true или false).

    {====================================} 
    Procedure TFrameRuleEngine.SaveRules; 
    {====================================} 
    Var 
      i: Integer; 
     
    begin 
      i := 0; 
      While i < CheckListBoxRule.Items.Count Do 
      Begin 
        If CheckListBoxRule.Items[i] = '' Then 
        Begin 
          // Если ячейка пустая, то удаляем её 
          CheckListBoxRule.Items.Delete(i); 
        End 
        Else 
        Begin 
          // Добавляем 1 или 0 соответственно checked или not checked 
          CheckListBoxRule.Items[i] := IntToStr(Integer(CheckListBoxRule.Checked[i])) + CheckListBoxRule.Items[i]; 
          Inc(i); 
        End; 
      End; 
      // Сохраняем весь список 
      CheckListBoxRule.Items.SaveToFile(ExtractFilePath(Application.ExeName) + 'Rule.Txt'); 
    end; 
     
    {===================================} 
    Procedure TFrameRuleEngine.LoadRules; 
    {===================================} 
    Var 
      sChecked: String; 
      i: Integer; 
     
    begin 
      If FileExists(ExtractFilePath(Application.ExeName) + 'Rule.Txt') Then 
      Begin 
        // Считываем файл 
        CheckListBoxRule.Items.LoadFromFile(ExtractFilePath(Application.ExeName) + 'Rule.Txt'); 
        i := 0; 
        While i < CheckListBoxRule.Items.Count Do 
        Begin 
          If CheckListBoxRule.Items[i] = '' Then 
          Begin 
            // Удаляем пустую ячейку 
            CheckListBoxRule.Items.Delete(i); 
          End 
          Else 
          Begin 
            // получаем состояние чекбокса 
            sChecked := Copy(CheckListBoxRule.Items[i], 1, 1); 
            CheckListBoxRule.Items[i] := Copy(CheckListBoxRule.Items[i], 2, Length(CheckListBoxRule.Items[i])); 
            // Обновляем свойство Checked 
            CheckListBoxRule.Checked[i] := Boolean(StrToInt(sChecked)); 
            Inc(i); 
          End; 
        End; 
      End; 
    end; 

Bjarne \\v/

https://www.go2NTS.com

Взято из <https://forum.sources.ru>
