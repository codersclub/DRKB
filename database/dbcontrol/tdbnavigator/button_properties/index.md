---
Title: Свойства кнопок TDBNavigator
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Свойства кнопок TDBNavigator
============================

Как можно узнать значения свойств кнопок компонента DBNavigator
(enabled/disabled или видимая/невидимая)?

Для определения видимости вы можете использовать свойство
VisibleButtons. Например:

    if nbRefresh in DBNavigator1.VisibleButtons then
      ShowMessage('Кнопка Refresh видимая') ;

Для того, чтобы узнать, активизирована (enabled/disabled) кнопка или
нет:

    {Вместо nbFirst вы можете определить другой
    член TNavigateBtn (например, nbFirst, nbPrior,
    nbNext, nbLast, nbInsert, nbDelete, nbEdit,
    nbPost, nbCancel, nbRefresh)}
     
    if DBNavigator1.Controls[Ord(nbFirst)].Enabled then
      ShowMessage('Кнопка First активизирована') ;

