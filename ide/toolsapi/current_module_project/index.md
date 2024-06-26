---
Title: Текущий модуль и проект
Author: Dr. Bob
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Текущий модуль и проект
=======================

Компонент во время проектирования может знать имена текущих модулей и
имя проекта. Все это можно получить с помощью ToolServices (см. файл
TOOLINTF.PAS)

Имя текущего проекта можно получить с помощью вызова GetProjectName,
список модулей/форм - с помощью функции GetUnitCount, которая возвратит
количество модулей и затем с помощью GetUnitName(i) мы можем получить
имя каждого модуля (также и с формами).

Вот примерный образец кода (получение и запись имен всех модулей/форм в
StringGrid и имени проекта в Label):

    procedure TInformationFrm.FormActivate(Sender: TObject);
    { необходимо: StringGrid1 (2 колонки, масса строк), Label1, Label2 }
    var
      i, j: Integer;
      Tmp: string;
    begin
      StringGrid1.Cells[0, 0] := 'модулей:';
      StringGrid1.Cells[1, 0] := 'форм:';
      if ToolServices <> nil then
        with ToolServices do
        begin
          Label1.Caption := ExtractFileName(GetProjectName); { простое имя }
          Label2.Caption := GetProjectName;   { полное правильное имя пути }
          for i := 0 to GetUnitCount do
          begin
            Tmp := ExtractFileName(GetUnitName(i));
            StringGrid1.Cells[0, i + 1] := Tmp;
            Tmp := ChangeFileExt(Tmp, '.DFM');
            for j := 0 to GetFormCount do
              if ExtractFileName(GetFormName(j)) = Tmp then
                StringGrid1.Cells[1, i + 1] := Tmp
          end;
        end;
    end;

