---
Title: Как поместить картинку из базы данных, например MsSQL, в компонент TImage?
Date: 01.01.2007
---


Как поместить картинку из базы данных, например MsSQL, в компонент TImage?
==========================================================================

::: {.date}
01.01.2007
:::

Предполагается, что поле BLOB (например, Pict)

2\) в запросе Query.SQL пишется что-то вроде

\'select Pict from sometable where somefield=somevalue\'

3\) запрос открывается

4\) делается "присваивание":

Image1.Picture.Assing(TBlobField(Query.FieldByName(\'Pict\'))

или, если известно, что эта картинка - Bitmap, то можно

Image1.Picture.Bitmap.Assing(TBlobField(Query.FieldByName(\'Pict\'))

А можно воспользоваться компонентом TDBImage.

Зайцев О.В.

Владимиров А.М.

Взято из <https://forum.sources.ru>
