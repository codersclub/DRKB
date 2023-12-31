---
Title: Создание и регистрация TAction на низком уровне
Date: 01.01.2007
---


Создание и регистрация TAction на низком уровне
===============================================

::: {.date}
01.01.2007
:::

Функция CreateAction (AOwner: TComponent;ActionClass: TBasicActionClass
):TBasicAction;

Модуль: ActnList

Функция создает действие (Action) заданного типа, которое отображается
во время проектирования в редакторе списка Action.

Тип Action указывается в параметре ActionClass.

Вызов функции аналогичен выполнению кода ActionClass.Create(AOwner), за
исключением того, что функция CreateAction использует значение параметра
Resource процедуры RegisterActions для инициализации значений
action-объекта, основанного на данном параметре.

Процедура EnumRegisteredActions (Proc: TEnumActionProc;Info: Pointer );

Модуль: ActnList

TEnumActionProc = Procedure( const Category: string;ActionClass:
TBasicActionClass;

Info: Pointer ) of object;

Процедура производит итерацию списка зарегистрированных действий
(Action), передавая их процедуре повторного вызова, определенной в
параметре Proc.

Параметр Category определяет категорию в списке, к которой относится
Action. Для потомков TContainedAction параметр Category должен
соответствовать свойству TContainedAction.Category. Для первичных
классов значение данного параметра может представлять собой пустую
строку.

Процедура RegisterActions (const CategoryName: string;const AClasses:
array of TBasicActionClass;Resource: TcomponentClass );

Модуль: ActnList

Процедура регистрирует множество Action так, чтобы ими можно было
оперировать с помощью редактора списка Action (Action list editor).

Зарегистрированный класс будет отображаться в "Action list editor" при
выборе команды редактора "New Action".

Процедура UnRegisterActions (const AClasses: array of TBasicActionClass
);

Модуль: ActnList

Отменяет регистрацию множества Action, зарегистрированных ранее
процедурой RegisterActions. Множество Action определяется параметром
AClasses

Взято с <https://atrussk.ru/delphi/>
