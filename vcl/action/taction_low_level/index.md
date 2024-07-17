---
Title: Создание и регистрация TAction на низком уровне
Date: 01.01.2007
Source: <https://atrussk.ru/delphi/>
---


Создание и регистрация TAction на низком уровне
===============================================

Модуль: ActnList

    CreateAction (AOwner: TComponent;
                  ActionClass: TBasicActionClass
                 ):TBasicAction;

Функция создает действие (Action) заданного типа, которое отображается
во время проектирования в редакторе списка Action.

Тип Action указывается в параметре ActionClass.

Вызов функции аналогичен выполнению кода ActionClass.Create(AOwner), за
исключением того, что функция CreateAction использует значение параметра
Resource процедуры RegisterActions для инициализации значений
action-объекта, основанного на данном параметре.

    EnumRegisteredActions (Proc: TEnumActionProc;Info: Pointer);
    TE numActionProc = Procedure(const Category: string;
                                 ActionClass:TBasicActionClass;
                                 Info: Pointer ) of object;

Процедура EnumRegisteredActions производит итерацию списка зарегистрированных действий
(Action), передавая их процедуре повторного вызова, определенной в
параметре Proc.

Параметр Category определяет категорию в списке, к которой относится
Action. Для потомков TContainedAction параметр Category должен
соответствовать свойству TContainedAction.Category. Для первичных
классов значение данного параметра может представлять собой пустую
строку.

    RegisterActions (const CategoryName: string;
                     const AClasses:array of TBasicActionClass;
                     Resource: TcomponentClass);

Процедура RegisterActions регистрирует множество Action так, чтобы ими можно было
оперировать с помощью редактора списка Action (Action list editor).

Зарегистрированный класс будет отображаться в "Action list editor" при
выборе команды редактора "New Action".

    UnRegisterActions (const AClasses: array of TBasicActionClass);

Процедура UnRegisterActions отменяет регистрацию множества Action, зарегистрированных ранее
процедурой RegisterActions. Множество Action определяется параметром
AClasses.

