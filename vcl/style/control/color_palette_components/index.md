---
Title: Компоненты настройки цветовой палитры
Date: 01.01.2007
---


Компоненты настройки цветовой палитры
=====================================

Помимо создания собственных визуальных стилей, что является делом
довольно трудоемким и хлопотным, вы можете изменить внешний вид
пользовательского интерфейса приложения более легким способом. Впервые в
составе Палитры компонентов Delphi 7 появились специализированные
компоненты, позволяющие настраивать цветовую палитру всех возможных
деталей пользовательского интерфейса одновременно. Эти компоненты
расположены на странице Additional:

TstandardColorMap - по умолчанию настроен на стандартную цветовую
палитру Windows;

TXPColorMap - по умолчанию настроен на стандартную цветовую палитру
Windows XP;

TTwilightColorMap - по умолчанию настроен на стандартную полутоновую
(черно-белую) палитру Windows.

Все они представляют собой контейнер, содержащий цвета для раскраски
различных деталей элементов управления. Разработчику необходимо лишь
настроить эту цветовую палитру и по мере необходимости подключать к
пользовательскому интерфейсу приложения. Для этого снова используется
компонент TActionManager.

Все панели инструментов (класс TActionToolBar), созданные в этом
компоненте (см. гл. 8), имеют свойство

    property ColorMap: TCustomActionBarColorMap; 

в котором и задается необходимый компонент цветовой палитры. Сразу после
подключения все элементы управления на такой панели инструментов
перерисовываются в соответствии с цветами новой палитры.

Обратите внимание, что в компоненте TToolBar, перенесенном из Палитры
компонентов на форму вручную, это свойство отсутствует.

Все компоненты настройки цветовой палитры имеют один метод-обработчик

    property OnColorChange: TnotifyEvent; 

который вызывается при изменении любого цвета палитры.
