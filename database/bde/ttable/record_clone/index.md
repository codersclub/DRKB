---
Title: Как добавить копию текущей записи?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как добавить копию текущей записи?
==================================

Следующая функция добавит в конец данных точную копию текущей записи.

    procedure AppendCurrent(Dataset:Tdataset); 
    var 
      aField : Variant ; 
      i      : Integer ; 
    begin 
      // Создаём массив
      aField := VarArrayCreate([0,DataSet.Fieldcount-1],VarVariant); 
     
      // считываем значения в массив
      for i := 0 to (DataSet.Fieldcount-1) do 
         aField[i] := DataSet.fields[i].Value ; 
     
      DataSet.Append ; 
     
      // помещаем значения массива в новую запись
      for i := 0 to (DataSet.Fieldcount-1) do 
         DataSet.fields[i].Value := aField[i] ; 
    end;


**Примечания Vit:**

1) Если таблица имеет ключевые поля или уникальные индексы данный код
приведёт к ошибке "Key violation"
