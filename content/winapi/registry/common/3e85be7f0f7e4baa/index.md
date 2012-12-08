---
Title: Объекты и TRegistry
Date: 01.01.2007
---

Объекты и TRegistry
===================

::: {.date}
01.01.2007
:::

Кто-нибудь знает, как сохранить общие настройки шрифтов моей
формы/пенели/списка и пр. пр. в регистрах; конечно, можно легко обойтись
построчным сохранением, но, к примеру, в случае сохранения свойств
шрифтов количество строк выйдет за пределы разумного - кто нибудь может
подсказать мне решение покороче и полегче?

Delphi имеет маленький секрет, позволяющий рекурсивно сохранять в
регистрах любые публичные свойства объектов. В качестве примера покажем
как это работает для TFont.

    uses TypInfo;
     
    { Определяем тип-набор для доступа к битам целого. }
    const
     
      BitsPerByte = 8;
    type
     
      TIntegerSet = set of 0..SizeOf(Integer) * BitsPerByte - 1;
     
      { Сохраняем набор свойств в виде подключа. Каждый элемент перечислимого типа -
     
      отдельная логическая величина. Истина означает что элемент включен в набор,
      Ложь - элемент в наборе отсутствует. Это позволит пользователю
      с помощью редактора ресурсов (REGEDIT) легко изменять конфигурацию. }
     
    procedure SaveSetToRegistry(const Name: string; Value: Integer;
     
      TypeInfo: PTypeInfo; Reg: TRegistry);
    var
     
      OldKey: string;
      I: Integer;
    begin
     
      TypeInfo := GetTypeData(TypeInfo)^.CompType;
      OldKey := '\' + Reg.CurrentPath;
      if not Reg.OpenKey(Name, True) then
        raise ERegistryException.CreateFmt('Не могу создать ключ: %s',
          [Name]);
     
      { Организуем цикл для всех элементов перечислимого типа. }
      with GetTypeData(TypeInfo)^ do
        for I := MinValue to MaxValue do
          { Записываем логическую величину для каждого установленного элемента. }
          Reg.WriteBool(GetEnumName(TypeInfo, I), I in
            TIntegerSet(Value));
     
      { Возвращаем родительский ключ. }
      Reg.OpenKey(OldKey, False);
    end;
     
    { Сохраняем объект в регистрах в отдельном подключе. }
     
    procedure SaveObjToRegistry(const Name: string; Obj: TPersistent;
     
      Reg: TRegistry);
    var
     
      OldKey: string;
    begin
     
      OldKey := '\' + Reg.CurrentPath;
      { Открываем подключ для объекта. }
      if not Reg.OpenKey(Name, True) then
        raise ERegistryException.CreateFmt('Не могу создать ключ: %s',
          [Name]);
     
      { Сохраняем свойства объекта. }
      SaveToRegistry(Obj, Reg);
     
      { Возвращаем родительский ключ. }
      Reg.OpenKey(OldKey, False);
    end;
     
    { Сохраняем в регистрах метод путем записи его имени. }
     
    procedure SaveMethodToRegistry(const Name: string; const Method:
      TMethod;
     
      Reg: TRegistry);
    var
     
      MethodName: string;
    begin
     
      { Если указатель на метод содержит nil, сохраняем пустую строку. }
      if Method.Code = nil then
        MethodName := ''
      else
        { Находим имя метода. }
        MethodName := TObject(Method.Data).MethodName(Method.Code);
      Reg.WriteString(Name, MethodName);
    end;
     
    { Сохраняем в регистре каждое свойство в виде значения текущего
    ключа. }
     
    procedure SavePropToRegistry(Obj: TPersistent; PropInfo: PPropInfo;
      Reg: TRegistry);
    begin
     
      with PropInfo^ do
        case PropType^.Kind of
          tkInteger,
            tkChar,
            tkWChar:
            { Сохраняем порядковые свойства в виде целочисленного значения. }
            Reg.WriteInteger(Name, GetOrdProp(Obj, PropInfo));
          tkEnumeration:
            { Сохраняем имена перечислимых величин. }
            Reg.WriteString(Name, GetEnumName(PropType, GetOrdProp(Obj,
              PropInfo)));
     
          tkFloat:
            { Сохраняем реальные числа как Doubles. }
            Reg.WriteFloat(Name, GetFloatProp(Obj, PropInfo));
          tkString,
            tkLString:
            { Сохраняем строки как строки. }
            Reg.WriteString(Name, GetStrProp(Obj, PropInfo));
          tkVariant:
            { Сохраняем вариантные величины как строки. }
            Reg.WriteString(Name, GetVariantProp(Obj, PropInfo));
          tkSet:
            { Сохраняем набор как подключ. }
            SaveSetToRegistry(Name, GetOrdProp(Obj, PropInfo), PropType,
              Reg);
     
          tkClass:
            { Сохраняем класс как подключ, а его свойства
            в виде значений подключа. }
            SaveObjToRegistry(Name, TPersistent(GetOrdProp(Obj, PropInfo)),
              Reg);
     
          tkMethod:
            { Сохраняем в регистрах метод путем записи его имени. }
            SaveMethodToRegistry(Name, GetMethodProp(Obj, PropInfo), Reg);
        end;
    end;
     
    { Записываем объект в регистр, сохраняя опубликованные свойства. }
     
    procedure SaveToRegistry(Obj: TPersistent; Reg: TRegistry);
    var
     
      PropList: PPropList;
      PropCount: Integer;
      I: Integer;
    begin
     
      { Получаем список опубликованных свойств. }
      PropCount := GetTypeData(Obj.ClassInfo)^.PropCount;
      GetMem(PropList, PropCount * SizeOf(PPropInfo));
      try
        GetPropInfos(Obj.ClassInfo, PropList);
        { Сохраняем каждое свойство в виде значения текущего ключа. }
        for I := 0 to PropCount - 1 do
          SavePropToRegistry(Obj, PropList^[I], Reg);
      finally
        FreeMem(PropList, PropCount * SizeOf(PPropInfo));
      end;
    end;
     
    { Сохраняем опубликованные свойства в виде значения данного ключа.
     
    Корневой улей - HKEY_CURRENT_USER. }
     
    procedure SaveToKey(Obj: TPersistent; const KeyPath: string);
    var
     
      Reg: TRegistry;
    begin
     
      Reg := TRegistry.Create;
      try
        if not Reg.OpenKey(KeyPath, True) then
          raise ERegistryException.CreateFmt('Не могу создать ключ: %s',
            [KeyPath]);
     
        SaveToRegistry(Obj, Reg);
      finally
        Reg.Free;
      end;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
