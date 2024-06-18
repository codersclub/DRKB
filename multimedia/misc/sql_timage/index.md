---
Title: Как поместить картинку из базы данных, например MsSQL, в компонент TImage?
Date: 01.01.2007
Author: Зайцев О.В., Владимиров А.М.
Source: <https://forum.sources.ru>
---


Как поместить картинку из базы данных, например MsSQL, в компонент TImage?
==========================================================================

1) Предполагается, что поле BLOB (например, Pict)

2) в запросе Query.SQL пишется что-то вроде

    'select Pict from sometable where somefield=somevalue'

3) запрос открывается

4) делается "присваивание":

    Image1.Picture.Assing(TBlobField(Query.FieldByName('Pict'))

или, если известно, что эта картинка - Bitmap, то можно

    Image1.Picture.Bitmap.Assing(TBlobField(Query.FieldByName('Pict'))

А ещё можно воспользоваться компонентом TDBImage.

