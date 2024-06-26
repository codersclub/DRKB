---
Title: Копирование свойств одного компонента другому
Author: Alex
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Копирование свойств одного компонента другому
=============================================

    uses
       StrUtils;
     
    procedure CopyComponentProp(Source, Target: TObject; aExcept: array of string);
    // Копирование всех одинаковых по названию свойств/методов одного компонента в
    // другой за исключение "Name", "Left", "Top" и тех которые заданы в aExcept
    // Примеры использования:
    // CopyComponentProp(N11, N21, []);
    // CopyComponentProp(ListBox2, ListBox3, []);
    // CopyComponentProp(ListView1, ListView2, ['Items', 'Color']);
    var
      I, Index: Integer;
      PropName: string;
      Source_PropList , Target_PropList  : PPropList;
      Source_NumProps , Target_NumProps  : Word;
      Source_PropObject, Target_PropObject: TObject;
     
      // Поиск в списке свойства с заданным именем
     
      function FindProperty(const PropName: string; PropList: PPropList; NumProps: Word): Integer;
      var
        I: Integer;
      begin
        Result:= -1;
        for I:= 0 to NumProps - 1 do
          if CompareStr(PropList^[I]^.Name, PropName) = 0 then begin
            Result:= I;
            Break;
          end;
      end;
     
    begin
      if not Assigned(Source) or not Assigned(Target) then Exit;
     
      Source_NumProps:= GetTypeData(Source.ClassInfo)^.PropCount;
      Target_NumProps:= GetTypeData(Target.ClassInfo)^.PropCount;
     
      GetMem(Source_PropList, Source_NumProps * SizeOf(Pointer));
      GetMem(Target_PropList, Target_NumProps * SizeOf(Pointer));
      try
        // Получаем список свойств
        GetPropInfos(Source.ClassInfo, Source_PropList);
        GetPropInfos(Target.ClassInfo, Target_PropList);
     
        for I:= 0 to Source_NumProps - 1 do begin
          PropName:= Source_PropList^[I]^.Name;
     
          if  (AnsiIndexText('None'  , aExcept                ) =  -1) and
             ((AnsiIndexText(PropName, ['Name', 'Left', 'Top']) <> -1) or
              (AnsiIndexText(PropName, aExcept                ) <> -1)) then Continue;
     
          Index:= FindProperty(PropName, Target_PropList, Target_NumProps);
          if Index = -1 then Continue; // не нашли
     
          // Проверить совпадение типов
          if Source_PropList^[I]^.PropType^.Kind <> Target_PropList^[Index]^.PropType^.Kind then
            Continue;
     
          case Source_PropList^[I]^.PropType^^.Kind of
            tkClass:  begin
                        Source_PropObject:= GetObjectProp(Source, Source_PropList^[I    ]);
                        Target_PropObject:= GetObjectProp(Target, Target_PropList^[Index]);
                        CopyComponentProp(Source_PropObject, Target_PropObject, ['None']);
                      end;
            tkMethod: SetMethodProp(Target, PropName, GetMethodProp(Source, PropName));
          else
            SetPropValue(Target, PropName, GetPropValue(Source, PropName));
          end;
        end;
      finally
        FreeMem(Source_PropList);
        FreeMem(Target_PropList);
      end;
    end;

    uses
       StrUtils
     
    procedure AssignComponentProp(Source, Target: TObject; aProp: array of string);
    // Копирование свойств/методов заданых в aProp одного компонента в другой
    // Пример использования:
    // AssignedComponentProp(ListView1, ListView2, ['Items', 'Color']);
    var
      I, Index: Integer;
      PropName: string;
      Source_PropList , Target_PropList  : PPropList;
      Source_NumProps , Target_NumProps  : Word;
      Source_PropObject, Target_PropObject: TObject;
     
      // Поиск в списке свойства с заданным именем
     
      function FindProperty(const PropName: string; PropList: PPropList; NumProps: Word): Integer;
      var
        I: Integer;
      begin
        Result:= -1;
        for I:= 0 to NumProps - 1 do
          if CompareStr(PropList^[I]^.Name, PropName) = 0 then begin
            Result:= I;
            Break;
          end;
      end;
     
    begin
      if not Assigned(Source) or not Assigned(Target) then Exit;
     
      Source_NumProps:= GetTypeData(Source.ClassInfo)^.PropCount;
      Target_NumProps:= GetTypeData(Target.ClassInfo)^.PropCount;
     
      GetMem(Source_PropList, Source_NumProps * SizeOf(Pointer));
      GetMem(Target_PropList, Target_NumProps * SizeOf(Pointer));
      try
        // Получаем список свойств
        GetPropInfos(Source.ClassInfo, Source_PropList);
        GetPropInfos(Target.ClassInfo, Target_PropList);
     
        for I:= 0 to Source_NumProps - 1 do begin
          PropName:= Source_PropList^[I]^.Name;
     
          if (AnsiIndexText('None' , aProp   ) = -1) and
             (AnsiIndexText(PropName, aProp   ) = -1) then Continue;
     
          Index:= FindProperty(PropName, Target_PropList, Target_NumProps);
          if Index = -1 then Continue; // не нашли
     
          // Проверить совпадение типов
          if Source_PropList^[I]^.PropType^.Kind <> Target_PropList^[Index]^.PropType^.Kind then
            Continue;
     
          case Source_PropList^[I]^.PropType^^.Kind of
            tkClass:  begin
                        Source_PropObject:= GetObjectProp(Source, Source_PropList^[I    ]);
                        Target_PropObject:= GetObjectProp(Target, Target_PropList^[Index]);
                        AssignComponentProp(Source_PropObject, Target_PropObject, ['None']);
                      end;
            tkMethod: SetMethodProp(Target, PropName, GetMethodProp(Source, PropName));
          else
            SetPropValue(Target, PropName, GetPropValue(Source, PropName));
          end;
        end;
      finally
        FreeMem(Source_PropList);
        FreeMem(Target_PropList);
      end;
    end;

