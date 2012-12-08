---
Title: Как записать в BLOB- поле большой текст (более 255 символов)?
Date: 01.01.2007
---


Как записать в BLOB- поле большой текст (более 255 символов)?
=============================================================

::: {.date}
01.01.2007
:::

    var
      S: TBlobStream;
      B: pointer;
      c: integer;
     
    ...
     
      Table1.Edit;
      S := TBlobStream.Create(Table1BlobField as TBlobField, bmWrite); {кажется, так}
      C := S.write(B, C);
      Table1.Post;
      S.Destroy;
     
     
    или так 
     
    var
      S: TMemoryStream;
      B: pointer;
      C: integer;
     
    ...
     
    S := TMemoryStream.Create;
     
    ...
     
      Table1.Edit;
      S.Clear;
      S.SetSize(C);
      C := S.write(B,C);
      (Table1BlobField as TBlobField).LoadFromStream(S);
      S.Clear;
      Table1.Post;
     
    ...
     
    S.Destroy;

Взято с <https://delphiworld.narod.ru>
