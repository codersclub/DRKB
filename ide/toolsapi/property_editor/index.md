---
Title: Создание редактора свойства
Date: 01.01.2007
Source: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Создание редактора свойства
===========================

Если вы присвоили свойству имя TableName, то полный цикл создания
редактора свойств включает следующие шаги:

Опишите класс редактора свойства:

    type
      TTableNameProperty = class(TStringProperty)
        function GetAttributes: TPropertyAttributes; override;
        procedure GetValues(Proc: TGetStrProc); override;
      end;
     
    implementation
     
    { TTableNameProperty }
    function TTableNameProperty.GetAttributes: TPropertyAttributes;
    begin
      Result := [paValueList];
    end;
     
    procedure TTableNameProperty.GetValues(Proc: TGetStrProc);
    var
      TableName: String;
      I: Integer;
    begin
      { здесь вы должны добавить свой код, ?тобы с помощью цикла обойти имена всех
      таблиц, включенных в список }
      for I := 0 to ???? do 
      begin
        TableName := ????[I];
        Proc(TableName);
      end;
    end; 

Затем зарегистрируйте данный редактор свойства следующим образом:

     RegisterPropertyEditor(TypeInfo(string), TcsNotebook, 'TableName', TTableNameProperty);         
