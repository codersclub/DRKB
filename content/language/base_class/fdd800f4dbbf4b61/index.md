---
Title: TComponent
Date: 01.01.2007
---


TComponent
==========

::: {.date}
01.01.2007
:::

Класс TComponent является предком всех компонентов VCL. Он используется
в качестве основы для создания невизуальных компонентов и реализует
основные механизмы, которые обеспечивают функционирование любого
компонента. В нем появляются первые свойства, которые отображаются в
Инспекторе объектов. Это свойство

property Name: TComponentName;

Оно содержит имя экземпляра компонента, которое используется для
идентификации компонента в приложении.

Примечание 

Тип TComponentName представляет собой обычную строку:

type TComponentName = type string;

Свойство

property Tag: Longint;

является вспомогательным и не влияет на работу компонента. Оно отдано на
откуп разработчику, который может присваивать ему значения по своему
усмотрению. Например, это свойство можно использовать для
дополнительной, более удобной идентификации компонентов.

Для компонентов существует своя иерархия, поэтому в классе введен
механизм учета и управления компонентами, для которых данный компонент
является владельцем. Свойства и методы, которые отвечают за управление,
приведены в табл. 2.1.

Таблица 2.1. Свойства и методы для управления списком компонентов

Свойство (метод)

Описание

property Components \[Index: Integer\]: TComponent ;

Содержит индексированный список указателей всех компонентов, для которых
данный компонент является владельцем (owner)

property ComponentCount : Integer;

Число подчиненных компонентов

property Owner: TComponent;

Указывается, какой компонент является владельцем данного

property Componentlndex: Integer;

Индекс данного компонента в списке владельца

procedure InsertComponent (AComponent : TComponent) ;

Вставляет компонент AComponent в список

procedure RemoveComponent (AComponent : TComponent};

Удаляет компонент AComponent из списка

procedure FindComponent (AName: string): TComponent;

Осуществляет поиск компонента по имени AName

procedure DestroyComponents;

Предназначен для уничтожения всех компонентов, подчиненных данному

Очень важное свойство

type TComponentState = set of (csLoading, csReading, csWriting,
csDestroying, csDesigning, csAncestor, csllpdating, csFixups,
csFreeNotification, cslnline, csDesignlnstance); property
ComponentState: TComponentState;

дает представление о текущем состоянии компонента. В табл. 2.2 описаны
возможные состояния компонента. Состояние может измениться в результате
получения компонентом некоторого сообщения, действий разработчика,
выполнения акции и т. д. Это свойство активно используется средой
разработки.

Таблица 2.2. Возможные состояния компонента

csLoading

Устанавливается при загрузке компонента из потока

csReading

Устанавливается при чтении значений свойств из потока

csWriting

Устанавливается при записи значений свойств в поток

csDestroying

Устанавливается при уничтожении компонента

csDesigning

Состояние разработки. Устанавливается при работе с формой во время
разработки

csAncestor

Устанавливается при переносе компонента на форму. Для перехода в это
состояние должно быть уже установлено состояние csDesigning

csUpdating

Устанавливается при изменении значений свойств и отображения результата
на форме-владельце. Для перехода в это состояние должно быть уже
установлено состояние csAncestor

CsFixups

Устанавливается, если компонент связан с компонентом другой формы,
которая еще не загружена в среду разработки

csFreeNotification

Если это состояние устанавливается, другие компоненты, связанные с
данным, уведомляются о его уничтожении

cslnline

Определяет компонент верхнего уровня в иерархии. Используется для
обозначения корневого объекта в разворачивающихся свойствах

csDesignlnstance

Определяет корневой компонент на этапе разработки

Для обеспечения работы механизма действий (см. гл. 8) предназначен

метод

function ExecuteAction(Action: TBasicAction): Boolean; dynamic;

Он вызывается автоматически при необходимости выполнить акцию,
предназначенную для данного компонента.

На уровне класса TComponent обеспечена поддержка СОМ-интерфейсов
IUnknown и IDispatch.

Через свойство

property ComObject: IUnknown;

вы можете обеспечить применение методов этих интерфейсов.

Таким образом, класс TComponent имеет все для использования в качестве
предка, для создания собственных невизуальных компонентов.