---
Title: BlobField как Bitmap
Date: 01.01.2007
---


BlobField как Bitmap
====================

::: {.date}
01.01.2007
:::

Сохраняем Bitmap в поле dbase с именем Icon. Icon представляет собой
двоичное Blob-поле.

    procedure ....
    var IconStream : TMemoryStream;
    ..
    ..
    begin
     
    .
    .
    IconStream := TMemoryStream.Create;
    Image1.picture.icon.savetostream(IconStream);
    (Table1.fieldbyname('Icon') as TBlobField).LoadFromStream(IconStream);
    Table1.post;
    IconStream.Free;
    .
    .
    end;

\*\* Читаем Bitmap в Timage из поля dbase с именем Icon.

    procedure .....
    var IconStream : TMemoryStream;
    ..
    ..
    begin
    .
    .
    IconStream := TMemoryStream.Create;
    (Table1.fieldbyname('Icon') as TBlobField).SaveToStream(IconStream);
    {что бы что-нибудь записать, необходимо установить позицию потока в ноль!}
    IconStream.Position := 0;
    appointment.iconimage.picture.icon.loadfromstream(iconstream);
    IconStream.Free;
    end;

Надеюсь это поможет, поскольку найти информацию в справочной системе по
этой теме практически невозможно. Чтобы сделать это, я перепробовал
множество способов. Я пробовал использовать TBlobField и TBlobStream, но
они не смогли мне помочь (может быть из-за убогой документации
borland?).

Взято с <https://delphiworld.narod.ru>
