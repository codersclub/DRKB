---
Title: Имя класса компонента и модуля
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Имя класса компонента и модуля
==============================

> Мне необходима функция, которая возвращала бы имя класса компонента и
> имя модуля, где определен данный класс.
> 
> Например: `xxx('TPanel')` возвращала бы `'ExtCtrls'`.
> 
> Также мне необходима функция, возвращающая список имен страниц палитры
> компонентов.

    Uses TypInfo;
     
    Function ObjectsUnit (Obj: TClass): String; 
    Begin
      Result := GetTypeData (PTypeInfo(Obj.ClassInfo))^.UnitName
    end;

Для создания описанной вами функции "Какой модуль" могут
использоваться описанные в TOOLINTF.INT методы GetModuleCount,
GetModuleName, GetComponentCount и GetComponentName.

Для получения представления о формате палитры компонентов обратитесь к
файлу DELPHI.INI.

