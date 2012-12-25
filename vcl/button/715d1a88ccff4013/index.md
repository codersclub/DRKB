---
Title: Из ресурсов поочередно загружать глифы для кнопок SpeedButton
Author: Dennis Passmore
Date: 01.01.2007
---


Из ресурсов поочередно загружать глифы для кнопок SpeedButton
=============================================================

::: {.date}
01.01.2007
:::

Автор: Dennis Passmore

Могу ли я из ресурсов поочередно загружать глифы для кнопок speedbutton
и, если да, то как это сделать?

Например, если в вашем проекте используется TDBGrid, то иконки кнопок
компонента DBNavigator могут линковаться вашей программой, и их можно
загрузить для использования в ваших speedbutton следующим образом:

    SpeedButton.Caption := '';
    SpeedButton1.Glyph.LoadFromResourcename(HInstance,'DBN_REFRESH');
    SpeedButton1.NumGlyphs := 2;

Другие зарезервированные имена:

DBN\_PRIOR, DBN\_DELETE, DBN\_CANCEL, DBN\_EDIT, DBN\_FIRST,
DBN\_INSERT, DBN\_LAST, DBN\_NEXT, DBN\_POST

Все имена должны использовать верхний регистр.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
