---
Title: Переназначения объектов
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Переназначения объектов
=======================

> Существует ли возможность переключения набора данных, используемого
> DBNavigator на набор данных активного элемента управления без из прямого
> указания?

Все, что вы хотите, поместится в пару строк кода. Добавьте "TypInfo" в
список используемых модулей и сделайте примерно следующее:

    var
      PropInfo: PPropInfo;
    begin
      PropInfo := GetPropInfo(PTypeInfo(ActiveControl.ClassInfo), 'DataSource');
      if (PropInfo <> nil)
        and (PropInfo^.PropType^.Kind = tkClass)
        and (GetTypeData(PropInfo^.PropType)^.ClassType = TDataSource) then
        DBNavigator1.DataSource := TDataSource(GetOrdProp(ActiveControl, PropInfo));
    end;

Некоторая избыточность в проверках гарантирует вам, что вам не попадется
некий странный объект (от сторонних производителей компонентов,
например), имеющий свойство DataSource, но не типа TDataSource.

